<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\ItemsUpdate\createItemsExport;
use App\Actions\ItemsUpdate\updateDBFromDofusFiles;
use App\Actions\ItemsUpdate\uploadToFtp;
use App\Actions\ItemsUpdate\uploadToSsh;
use App\Models\Item;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

class AdminPanel extends Component
{
    // FONCTIONNE AVEC PYTHON 3.12.6

    /**
     * @var array<int, mixed>
     */
    public array $newItems = [];

    /**
     * @var int[]
     */
    public array $iconIds = [];

    public bool $showUpdateButtons;

    private int $maxStep;

    private int $currentStep;

    private string $stepName;

    private string $logTitle;

    private string $logIcon;

    private string $dofusContentPath = 'C:\Users\thefl\AppData\Local\Ankama\Dofus-dofus3\Dofus_Data\StreamingAssets\Content/';

    /**
     * @var string[]
     */
    private array $rootToExport = [
        'data_assets_breedsroot.asset.bundle' => 'BreedsRoot',
        'data_assets_headsroot.asset.bundle' => 'HeadsRoot',
        'data_assets_itemsroot.asset.bundle' => 'ItemsRoot',
        'data_assets_livingobjectskinjntmoodroot.asset.bundle' => 'LivingObjectSkinJntMoodRoot',
        'data_assets_skinslotsrulesroot.asset.bundle' => 'SkinSlotsRulesRoot',
        'data_assets_mountsroot.asset.bundle' => 'MountsRoot',
    ];

    /**
     * @var string[]
     */
    private array $langs = ['fr', 'en', 'es', 'pt'];

    public function mount(): void
    {
        $this->currentStep = 0;
        $this->showUpdateButtons = ! Str::startsWith(Request::url(), 'https://barbofus.com');
    }

    public function render(): View
    {
        return view('livewire.user-panel.admin-panel');
    }

    /**
     * Ajoute une ligne dans les logs du php artisan serve
     */
    public function stepLog(): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput;
        $output->writeln("$this->logTitle $this->logIcon $this->currentStep/$this->maxStep - $this->stepName");
    }

    /**
     * Première étape de la mise à jour, centralise toutes les fonctions nécessaires
     */
    public function InitiateItemsUpdate(): void
    {
        $this->maxStep = 6 + count($this->rootToExport) + count($this->langs);
        $this->currentStep = 0;

        // Export des fichiers data en json
        $this->getDataRootFiles();

        // Export des fichiers lang.bin en json
        $this->getLangFiles();

        // Met à jour avec les fichiers fraichement dl. Return la liste des nouveautés ainsi que les icons à récupèrer
        $this->updateDB();

        // Récupèrer les icones des items/mounts/visage
        $this->getIcons();

        // Récupère les skins / bones de ce que nous avons déjà (heads, breeds, mounts)
        $this->getRootFilesSkins();

        // Exporte les nouveaux bundle pour identifier les skins / bones id
        $this->exportBundleDifference();

        $this->currentStep = $this->maxStep;
        $this->stepName = 'Mise à jour terminé';
        $this->logIcon = '✅';
        $this->logTitle = 'FIN';
        $this->stepLog();
    }

    /**
     * Seconde étape de la mise à jour, exporter les skins/bones qui ont été modifié, puis reconstruit l'itemExport
     */
    public function InitiateSkinsUpdate(): void
    {
        $this->maxStep = 5;
        $this->currentStep = 0;

        // Récupère les skins/bones nécessaires
        $this->exportNecessarySkins();

        // Construit le fichier itemsExport.json
        $this->makeItemExportFile();

        // Construit le fichier itemsExport.json
        $this->restartRendererServer();

        $this->currentStep = $this->maxStep;
        $this->stepName = 'Mise à jour terminé';
        $this->logIcon = '✅';
        $this->logTitle = 'FIN';
        $this->stepLog();
    }

    public function restartRendererServer() : void
    {
        $this->currentStep++;
        $this->stepName = 'Redémarrage du serveur OVH';
        $this->logIcon = '🌱';
        $this->logTitle = 'RESTART';
        $this->stepLog();

        $ssh_host = env('ssh_ovh_server_host');
        $ssh_port = env('ssh_ovh_server_port');
        $ssh_user = env('ssh_ovh_server_user');
        $ssh_key_path = 'C:/Users/thefl/.ssh/id_rsa_barbofus_renderer';
        $ssh_passphrase = env('SSH_OVH_SERVER_PASSWORD');

        $key = PublicKeyLoader::load(file_get_contents($ssh_key_path), $ssh_passphrase);

        $ssh = new SSH2($ssh_host, $ssh_port);
        if (! $ssh->login($ssh_user, $key)) {
            exit('❌ Connexion SSH échouée');
        }

        $output = $ssh->exec('sudo systemctl restart skinator');

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }

    /**
     * Récupère les skins/bones nécessaires
     */
    public function exportNecessarySkins(): void
    {
        $this->currentStep++;
        $this->stepName = 'Récupération des fichiers + vérifs dates modif';
        $this->logIcon = '🌱';
        $this->logTitle = 'GET BONES';
        $this->stepLog();

        /**
         * @var array<string, array<int, string>> $files
         */
        $files = ['bones' => [], 'skins' => []];

        // Récupèration asset_id et female_id de tout, sauf les mount mimisymbic
        $items = Item::query()->whereNot(function ($query) {
            $query->whereIn('pet_type', ['dragodinde', 'muldo', 'volkorne'])
                ->where('subcategory', 'mimisymbic');
        })
            ->orWhere('pet_type', null)
            ->get();

        // Conserve les ids des skins et bones qu'on doit exporter
        foreach ($items as $item) {
            $folder = $item->folder;
            $aId = $item->asset_id;
            $faId = $item->female_asset_id;

            if ($aId == '' || $faId == '') {
                continue;
            }

            $localFile = storage_path('app/json/skinator/').$folder.($folder === 'skins' ? '/' : '/Bones_Data/').$aId.'.json';
            $dofusFile = $this->dofusContentPath.'Characters/'.ucfirst($folder).'/'.$folder.'_assets_'.rtrim($folder, 's').'_'.$aId.'.bundle';

            if ($this->checkIfDofusNewer($localFile, $dofusFile)) {
                $files[$folder][] = $aId;
            }

            if ($faId != $aId) {
                $localFile = storage_path('app/json/skinator/').$folder.($folder === 'skins' ? '/' : '/Bones_Data/').$faId.'.json';
                $dofusFile = $this->dofusContentPath.'Characters/'.ucfirst($folder).'/'.$folder.'_assets_'.rtrim($folder, 's').'_'.$faId.'.bundle';
                if ($this->checkIfDofusNewer($localFile, $dofusFile)) {
                    $files[$folder][] = $faId;
                }
            }
        }

        $files['bones'] = array_values(array_unique($files['bones']));
        $files['skins'] = array_values(array_unique($files['skins']));

        // Prépare les noms de fichiers pour python
        file_put_contents(storage_path('app/json/skinator/skinIds.txt'), implode("\n", $files['skins']));
        file_put_contents(storage_path('app/json/skinator/boneIds.txt'), implode("\n", $files['bones']));

        $this->stepName = 'Export des bundles BONES';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les bones via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Bones'),
            escapeshellarg(storage_path('app/')),
            escapeshellarg('bones'),
            escapeshellarg(storage_path('app/json/skinator/boneIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les bones', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        $this->currentStep++;
        $this->logTitle = 'GET SKINS';
        $this->stepName = 'Export des bundles SKINS';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les skins via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Skins'),
            escapeshellarg(storage_path('app/')),
            escapeshellarg('skins'),
            escapeshellarg(storage_path('app/json/skinator/skinIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les skins', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        // Envoie les fichiers au serveur
        $this->currentStep++;
        $this->logTitle = 'SEND ASSETS';
        $this->stepName = 'Envoi les fichiers au serveur ';
        $this->logIcon = '✈️';
        $this->stepLog();

        $ftpFiles = [
            'skins_png' => ['remoteDestination' => '/storage/app/public/images/skinator/skins/'],
            'skins_json' => ['remoteDestination' => '/home/debian/data/skins/'],
            'bones_png' => ['remoteDestination' => '/storage/app/public/images/skinator/bones/'],
            'bones_data' => ['remoteDestination' => '/home/debian/data/bones/Bones_Data/'],
            'bones_asset' => ['remoteDestination' => '/home/debian/data/bones/Bones_AssetData/'],
        ];

        foreach ($files as $typeKey => $type) {
            foreach ($type as $file) {
                if ($typeKey === 'skins') {
                    $ftpFiles['skins_png']['files'][] = [
                        'file' => storage_path('app/public/images/skinator/skins/').$file.'.png',
                        'name' => $file.'.png',
                    ];
                    $ftpFiles['skins_json']['files'][] = [
                        'file' => storage_path('app/json/skinator/skins/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                } elseif ($typeKey === 'bones') {
                    $ftpFiles['bones_png']['files'][] = [
                        'file' => storage_path('app/public/images/skinator/bones/').$file.'.png',
                        'name' => $file.'.png',
                    ];
                    $ftpFiles['bones_data']['files'][] = [
                        'file' => storage_path('app/json/skinator/bones/Bones_Data/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                    $ftpFiles['bones_asset']['files'][] = [
                        'file' => storage_path('app/json/skinator/bones/Bones_AssetData/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                }
            }
        }

        $count = 0;
        foreach ($ftpFiles as $key => $ftpFile) {
            $count++;
            $this->stepName = $count.'/'.count($ftpFiles).' Envoi les fichiers au serveur à '.$ftpFile['remoteDestination'];
            $this->stepLog();

            if (! isset($ftpFile['files'])) {
                continue;
            }

            if(in_array($key, ['skins_png', 'bones_png'])) {
                (new uploadToFtp)($ftpFile['files'], $ftpFile['remoteDestination']);
            }
            else {
                (new uploadToSsh)($ftpFile['files'], $ftpFile['remoteDestination']);
            }
        }

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }

    /**
     * Créé le fichier itemsExport pour le skinator
     *
     * @return void
     */
    public function makeItemExportFile()
    {
        $this->currentStep++;
        $this->logTitle = 'CREATING ITEMSEXPORT JSON';
        $this->stepName = 'Créé itemsExport.json local';
        $this->logIcon = '🌱';
        $this->stepLog();

        (new createItemsExport)();

        $this->stepName = 'Créé itemsExport.json serveur';
        $this->logIcon = '✈️';
        $this->stepLog();

        $files[] = [
            'file' => storage_path('app/json/skinator/itemsExport.json'),
            'name' => 'itemsExport.json',
        ];

        (new uploadToSsh)($files, '/home/debian/data/');

        $this->stepName = 'FIN';
        $this->logIcon = '✅';
        $this->stepLog();

    }

    /**
     * Récupère les fichiers root dans Data puis les envois au serveur via ftp
     */
    public function getDataRootFiles(): void
    {
        $this->logTitle = 'ROOT FILES';
        $files = [];

        foreach ($this->rootToExport as $key => $value) {
            $this->currentStep++;
            $this->stepName = 'Export '.str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '🌱';
            $this->stepLog();

            // Prépare la commande python
            $command = sprintf(
                'python %s %s %s %s',
                escapeshellarg(base_path('app/Actions/ItemsUpdate/bundle_extractor.py')),
                escapeshellarg($this->dofusContentPath.'Data/'.$key),
                escapeshellarg(storage_path('app')),
                escapeshellarg('data'),
            );

            // Execute le python
            exec($command, $output, $exitCode);

            // S'il y a une erreur, la retourne
            if ($exitCode != 0) {
                dd('Erreur pour '.$value, [
                    'cmd' => $command,
                    'output' => $output,
                    'code' => $exitCode,
                ]);
            }

            $files[] = [
                'file' => storage_path('app/json/skinator/').$value.'.json',
                'name' => $value.'.json',
            ];

            $this->stepName = 'Fin '.str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '✅';
            $this->stepLog();
        }

        // Envoie les fichiers au serveur o2switch
        $this->stepName = 'Envoi les fichiers au serveur o2switch';
        $this->logIcon = '✈️';
        $this->stepLog();

        // Envoie au serveur o2dwitch
        (new uploadToFtp)($files, '/storage/app/json/skinator/');

        // Envoie les fichiers au serveur ovh
        $this->stepName = 'Envoi les fichiers au serveur ovh';
        $this->logIcon = '✈️';
        $this->stepLog();

        // Envoie au serveur ovh
        (new uploadToSsh)($files, '/home/debian/data');
    }

    /**
     * Recupère les fichiers lang.bin puis les transforme en json
     */
    public function getLangFiles(): void
    {
        $this->logTitle = 'LOCALIZATION FILES';
        $files = [];

        foreach ($this->langs as $lang) {
            $this->currentStep++;
            $this->stepName = 'Export '.$lang.'.bin';
            $this->logIcon = '🌱';
            $this->stepLog();

            // Prépare la commande python
            $command = sprintf(
                'python %s %s %s',
                escapeshellarg(base_path('app/Actions/ItemsUpdate/bin_to_json.py')),
                escapeshellarg($this->dofusContentPath.'I18n/'.$lang.'.bin'),
                escapeshellarg(storage_path('app/json/skinator/lang')),
            );

            // Execute le python
            exec($command, $output, $exitCode);

            // S'il y a une erreur, la retourne
            if ($exitCode != 0) {
                dd('Erreur pour '.$lang, [
                    'cmd' => $command,
                    'output' => $output,
                    'code' => $exitCode,
                ]);
            }

            $files[] = [
                'file' => storage_path('app/json/skinator/lang/').$lang.'.json',
                'name' => $lang.'.json',
            ];

            $this->stepName = 'Fin '.$lang.'.bin';
            $this->logIcon = '✅';
            $this->stepLog();
        }

        // Envoie le fichier au serveur o2switch
        $this->stepName = 'Envoi les langs au serveur o2switch';
        $this->logIcon = '✈️';
        $this->stepLog();

        // Envoie au serveur o2dwitch
        (new uploadToFtp)($files, '/storage/app/json/skinator/lang/');
    }

    /**
     * Met à jour la base de données grâce aux fichiers exporté
     */
    public function updateDB(): void
    {
        $this->currentStep++;
        $this->stepName = 'Mise à jour base de donnée';
        $this->logIcon = '🌱';
        $this->logTitle = 'DATABASE';
        $this->stepLog();

        $result = (new updateDBFromDofusFiles)();
        $this->newItems = $result['newItems'];
        $this->iconIds = $result['icons'];

        file_put_contents(storage_path('app/json/skinator/iconIds.txt'), implode("\n", $this->iconIds));

        $this->stepName = 'Mise à jour base de donnée côté serveur';
        $this->logIcon = '✈️';
        $this->stepLog();

        Http::withHeaders([
            'X-Secret-Key' => env('DOFUS_UPDATE_SECRET'),
        ])->post('https://barbofus.com/api/run-update-items');

        $this->logIcon = '✅';
        $this->stepLog();
    }

    /**
     * Récupère les icones des items / mounts / visages. Juste après la maj de la database
     *
     * @return void
     */
    public function getIcons()
    {
        $this->currentStep++;
        $this->stepName = 'Export icons';
        $this->logIcon = '🌱';
        $this->logTitle = 'GET ICONS';
        $this->stepLog();

        // EXPORT DES ICONS D'ITEMS
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/icons_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Picto/Items/item_assets_2x.bundle'),
            escapeshellarg(storage_path('app/public/images/icons/items')),
            escapeshellarg(storage_path('app/json/skinator/iconIds.txt')),
        );

        // Execute le python
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les icons d\'items', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        $this->stepName = 'Envoie des icons d\'items au serveur';
        $this->logIcon = '✈️';
        $this->stepLog();

        $files = [];

        foreach (File::allFiles(storage_path('app/public/images/icons/items')) as $file) {
            $fileName = $file->getFilename();

            $files[] = [
                'file' => $file->getPathname(),
                'name' => $fileName,
            ];
        }

        (new uploadToFtp)($files, '/storage/app/public/images/icons/items/');

        $this->stepName = 'Export visage';
        $this->logIcon = '🌱';
        $this->stepLog();

        // EXPORT DES VISAGES
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/bundle_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Picto/UI/cosmetic_assets_2x.bundle'),
            escapeshellarg(storage_path('app/public/images/icons/classes/faces/unity')),
            escapeshellarg('heads'),
        );
        // Execute le python
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les visages', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        $this->stepName = 'Envoie des icons de visage au serveur';
        $this->logIcon = '✈️';
        $this->stepLog();

        $files = [];

        foreach (File::allFiles(storage_path('app/public/images/icons/classes/faces/unity')) as $file) {
            $fileName = $file->getFilename();

            $files[] = [
                'file' => $file->getPathname(),
                'name' => $fileName,
            ];
        }

        (new uploadToFtp)($files, '/storage/app/public/images/icons/classes/faces/unity/');

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }

    /**
     * Récupère les skins/bones connu via les fichiers root, seulement s'ils ont été modifié plus tard que le notre
     */
    public function getRootFilesSkins(): void
    {
        $mountsData = json_decode(Storage::disk('local')->get('json/skinator/MountsRoot.json'), true)['references']['RefIds'];
        $breedsData = json_decode(Storage::disk('local')->get('json/skinator/BreedsRoot.json'), true)['references']['RefIds'];
        $headsData = json_decode(Storage::disk('local')->get('json/skinator/HeadsRoot.json'), true)['references']['RefIds'];

        $this->currentStep++;
        $this->stepName = 'Récupération des fichiers + vérifs dates modif';
        $this->logIcon = '🌱';
        $this->logTitle = 'GET SKINS & BONES';
        $this->stepLog();

        /**
         * @var array<string, array<int, string>> $files
         */
        $files = ['Bones' => [], 'Skins' => []];

        // Récupèration des bones de mount
        foreach ($mountsData as $mount) {
            if ($mount['type']['class'] != 'Mounts') {
                continue;
            }
            $md = $mount['data'];
            $look = $md['look'];

            if (preg_match('/^\{([^}]+)}/', $look, $matches)) {
                $parts = explode('|', $matches[1]);

                $baseId = $parts[0] ?? null;
                $skinId = isset($parts[1]) && ctype_digit($parts[1]) ? $parts[1] : null;

                if ($baseId && ! in_array($baseId, $files['Bones'])) {
                    $files['Bones'][] = $baseId;
                }

                if ($skinId && ! in_array($skinId, $files['Skins'])) {
                    $files['Skins'][] = $skinId;
                }
            }
        }

        // Récupère les noms des fichiers pour les breeds (skins corps, bones anim combat + la static explo)
        $files['Bones'][] = '1-static'; // Bone animation static explo général
        $files['Bones'][] = '2'; // Bone animation monture
        foreach ($breedsData as $breed) {
            if ($breed['type']['class'] != 'Breeds') {
                continue;
            }
            $bd = $breed['data'];
            $looks = [$bd['maleLook'], $bd['femaleLook']];

            // Skin mâle et femelle
            foreach ($looks as $look) {
                if (preg_match('/^\{([^}]+)}/', $look, $matches)) {
                    $parts = explode('|', $matches[1]);
                    $files['Skins'][] = isset($parts[1]) && ctype_digit($parts[1]) ? $parts[1] : null;
                }
            }

            // Bone animation de combat
            $files['Bones'][] = '1-'.$bd['id'].'-static';
        }

        // Récupère les skins de chaque visage
        foreach ($headsData as $head) {
            if ($head['type']['class'] != 'Heads') {
                continue;
            }
            $hd = $head['data'];

            $files['Skins'][] = $hd['skins'];
        }

        // Vérifie s'il faut redl le fichier, et ne conserve que ceux à dl
        foreach ($files as $typeKey => $type) {
            foreach ($type as $key => $file) {
                $localFile = storage_path('app/json/skinator/').strtolower($typeKey).($typeKey === 'Skins' ? '/' : '/Bones_Data/').$file.'.json';
                $dofusFile = $this->dofusContentPath.'Characters/'.$typeKey.'/'.strtolower($typeKey).'_assets_'.rtrim(strtolower($typeKey), 's').'_'.$file.'.bundle';

                $delete = ! $this->checkIfDofusNewer($localFile, $dofusFile);

                if ($delete) {
                    unset($files[$typeKey][$key]);
                }
            }
        }

        // Prépare les noms de fichiers pour python
        file_put_contents(storage_path('app/json/skinator/skinIds.txt'), implode("\n", $files['Skins']));
        file_put_contents(storage_path('app/json/skinator/boneIds.txt'), implode("\n", $files['Bones']));

        $this->stepName = 'Export des bundles BONES';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les bones via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Bones'),
            escapeshellarg(storage_path('app/')),
            escapeshellarg('bones'),
            escapeshellarg(storage_path('app/json/skinator/boneIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les bones', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        $this->stepName = 'Export des bundles SKINS';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les skins via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Skins'),
            escapeshellarg(storage_path('app/')),
            escapeshellarg('skins'),
            escapeshellarg(storage_path('app/json/skinator/skinIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les skins', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        // Envoie les fichiers au serveur
        $this->stepName = 'Envoi les fichiers au serveur ';
        $this->logIcon = '✈️';
        $this->stepLog();

        $ftpFiles = [
            'skins_png' => ['remoteDestination' => '/storage/app/public/images/skinator/skins/'],
            'skins_json' => ['remoteDestination' => '/home/debian/data/skins/'],
            'bones_png' => ['remoteDestination' => '/storage/app/public/images/skinator/bones/'],
            'bones_data' => ['remoteDestination' => '/home/debian/data/bones/Bones_Data/'],
            'bones_asset' => ['remoteDestination' => '/home/debian/data/bones/Bones_AssetData/'],
        ];

        foreach ($files as $typeKey => $type) {
            foreach ($type as $file) {
                if ($typeKey === 'Skins') {
                    $ftpFiles['skins_png']['files'][] = [
                        'file' => storage_path('app/public/images/skinator/skins/').$file.'.png',
                        'name' => $file.'.png',
                    ];
                    $ftpFiles['skins_json']['files'][] = [
                        'file' => storage_path('app/json/skinator/skins/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                } elseif ($typeKey === 'Bones') {
                    $ftpFiles['bones_png']['files'][] = [
                        'file' => storage_path('app/public/images/skinator/bones/').$file.'.png',
                        'name' => $file.'.png',
                    ];
                    $ftpFiles['bones_data']['files'][] = [
                        'file' => storage_path('app/json/skinator/bones/Bones_Data/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                    $ftpFiles['bones_asset']['files'][] = [
                        'file' => storage_path('app/json/skinator/bones/Bones_AssetData/').$file.'.json',
                        'name' => $file.'.json',
                    ];
                }
            }
        }

        $count = 0;
        foreach ($ftpFiles as $key => $ftpFile) {
            $count++;
            $this->stepName = $count.'/'.count($ftpFiles).' Envoi les fichiers au serveur à '.$ftpFile['remoteDestination'];
            $this->stepLog();

            if (! isset($ftpFile['files'])) {
                continue;
            }

            if(in_array($key, ['skins_png', 'bones_png'])) {
                (new uploadToFtp)($ftpFile['files'], $ftpFile['remoteDestination']);
            }
            else {
                (new uploadToSsh)($ftpFile['files'], $ftpFile['remoteDestination']);
            }
        }

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }

    /**
     * Return true si nous n'avons pas le fichier ou si sa date de modification est antérieure à celle de Dofus
     */
    public function checkIfDofusNewer(string $localFile, string $dofusFile): bool
    {
        if (! file_exists($localFile) && file_exists($dofusFile)) {
            return true;
        }

        return filemtime($localFile) < filemtime($dofusFile);
    }

    /**
     * Compare les noms de fichiers entre le json enregistrer et les bundles Dofus, puis exporte les png des nouveaux bundles
     *
     * @return void
     */
    public function exportBundleDifference()
    {
        $this->currentStep++;
        $this->stepName = 'Récupération des nouveaux bundles';
        $this->logIcon = '🌱';
        $this->logTitle = 'GET NEW BUNDLES';
        $this->stepLog();

        // Récupère les différences entre le json et les fichiers Dofus
        $oldBundleNames = json_decode(Storage::disk('local')->get('json/skinator/bundleNames.json'), true);

        $skinsBundles = File::files($this->dofusContentPath.'Characters/Skins');
        $skinsBundlesNames = collect($skinsBundles)->map(function ($file) {
            return $file->getFilename();
        })->toArray();
        $bonesBundles = File::files($this->dofusContentPath.'Characters/Bones');
        $bonesBundlesNames = collect($bonesBundles)->map(function ($file) {
            return $file->getFilename();
        })->toArray();

        // Compare les fichiers Skins et Bones avec ceux dans le JSON
        $missingSkins = array_diff($skinsBundlesNames, $oldBundleNames['skins']);
        $missingBones = array_diff($bonesBundlesNames, $oldBundleNames['bones']);

        // Extraire les IDs des fichiers avec une fonction anonyme dans array_map
        $skinsIds = array_map(function ($filename) {
            if (preg_match('/(?:bones_assets_bone_|skins_assets_skin_)([\w\-]+)(?=\.bundle)/', $filename, $matches)) {
                return $matches[1];
            }

            return null;
        }, $missingSkins);

        $bonesIds = array_map(function ($filename) {
            if (preg_match('/(?:bones_assets_bone_|skins_assets_skin_)([\w\-]+)(?=\.bundle)/', $filename, $matches)) {
                return $matches[1];
            }

            return null;
        }, $missingBones);

        file_put_contents(storage_path('app/json/skinator/skinIds.txt'), implode("\n", $skinsIds));
        file_put_contents(storage_path('app/json/skinator/boneIds.txt'), implode("\n", $bonesIds));

        $this->stepName = 'Export des bundles BONES';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les bones via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Bones'),
            escapeshellarg(storage_path('app/temp/bones/')),
            escapeshellarg('bonestemp'),
            escapeshellarg(storage_path('app/json/skinator/boneIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les bones', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        $this->stepName = 'Export des bundles SKINS';
        $this->logIcon = '🌱';
        $this->stepLog();

        // Exporte tous les skins via python
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/skins_extractor.py')),
            escapeshellarg($this->dofusContentPath.'Characters/Skins'),
            escapeshellarg(storage_path('app/temp/skins/')),
            escapeshellarg('skinstemp'),
            escapeshellarg(storage_path('app/json/skinator/skinIds.txt')),
        );
        // Execute le python
        $command .= ' 2>&1';
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if ($exitCode != 0) {
            dd('Erreur pour exporter les skins', [
                'cmd' => $command,
                'output' => $output,
                'code' => $exitCode,
            ]);
        }

        // Met à jour notre json des noms de bundle croisé
        $bundleNames = [
            'skins' => $skinsBundlesNames,
            'bones' => $bonesBundlesNames,
        ];

        $jsonBundles = json_encode($bundleNames, JSON_PRETTY_PRINT);

        if ($jsonBundles === false) {
            throw new \RuntimeException('Erreur lors de l’encodage JSON des bundles');
        }

        File::put(storage_path('app/json/skinator/bundleNames.json'), $jsonBundles);

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }
}
