<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\ItemsUpdate\updateDBFromDofusFiles;
use App\Actions\ItemsUpdate\uploadToFtp;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AdminPanel extends Component
{
    // FONCTIONNE AVEC PYTHON 3.12.6

    public array $newItems = [];
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
        $this->showUpdateButtons = !Str::startsWith(Request::url(), 'https://barbofus.com');
    }

    public function render(): View
    {
        return view('livewire.user-panel.admin-panel');
    }

    /**
     * Ajoute une ligne dans les logs du php artisan serve
     * @return void
     */
    function stepLog(): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("$this->logTitle $this->logIcon $this->currentStep/$this->maxStep - $this->stepName");
    }

    /**
     * Première étape de la mise à jour, centralise toutes les fonctions nécessaires
     * @return void
     */
    public function InitiateItemsUpdate(): void
    {
        $this->maxStep = 5 + count($this->rootToExport) + count($this->langs);
        $this->currentStep = 0;

        // Export des fichiers data en json
        //$this->getDataRootFiles();

        // Export des fichiers lang.bin en json
        //$this->getLangFiles();

        // Met à jour avec les fichiers fraichement dl. Return la liste des nouveautés ainsi que les icons à récupèrer
        //$this->updateDB();

        // Récupèrer les icones des items/mounts/visage
        $this->getIcons();

        $this->currentStep = $this->maxStep;
        $this->stepName = 'Mise à jour terminé';
        $this->logIcon = '✅';
        $this->logTitle = 'FIN';
        $this->stepLog();
    }

    /**
     * Récupère les fichiers root dans Data puis les envois au serveur via ftp
     * @return void
     */
    function getDataRootFiles(): void
    {
        $this->logTitle = 'ROOT FILES';
        $files = [];

        foreach ($this->rootToExport as $key => $value) {
            $this->currentStep ++;
            $this->stepName = 'Export '. str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '🌱';
            $this->stepLog();

            // Prépare la commande python
            $command = sprintf(
                'python %s %s %s %s',
                escapeshellarg(base_path('app/Actions/ItemsUpdate/bundle_extractor.py')),
                escapeshellarg($this->dofusContentPath . 'Data/' . $key),
                escapeshellarg(storage_path('app')),
                escapeshellarg('data'),
            );

            // Execute le python
            exec($command, $output, $exitCode);

            // S'il y a une erreur, la retourne
            if($exitCode != 0) {
                dd('Erreur pour ' . $value, [
                    'cmd' => $command,
                    'output' => $output,
                    'code' => $exitCode,
                ]);
            }

            $files[] = [
                'file' => storage_path('app/json/skinator/'). $value . '.json',
                'name' => $value . '.json',
            ];

            $this->stepName = 'Fin '. str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '✅';
            $this->stepLog();
        }

        // Envoie les fichiers au serveur
        $this->stepName = 'Envoi les fichiers au serveur ';
        $this->logIcon = '✈️';
        $this->stepLog();

        (new uploadToFtp())($files, '/storage/app/json/skinator/');
    }

    /**
     * Recupère les fichiers lang.bin puis les transforme en json
     * @return void
     */
    function getLangFiles(): void
    {
        $this->logTitle = 'LOCALIZATION FILES';
        $files = [];

        foreach ($this->langs as $lang) {
            $this->currentStep ++;
            $this->stepName = 'Export '. $lang . '.bin';
            $this->logIcon = '🌱';
            $this->stepLog();

            // Prépare la commande python
            $command = sprintf(
                'python %s %s %s',
                escapeshellarg(base_path('app/Actions/ItemsUpdate/bin_to_json.py')),
                escapeshellarg($this->dofusContentPath . 'I18n/' . $lang . '.bin'),
                escapeshellarg(storage_path('app/json/skinator/lang')),
            );

            // Execute le python
            exec($command, $output, $exitCode);

            // S'il y a une erreur, la retourne
            if($exitCode != 0) {
                dd('Erreur pour ' . $lang, [
                    'cmd' => $command,
                    'output' => $output,
                    'code' => $exitCode,
                ]);
            }

            $files[] = [
                'file' => storage_path('app/json/skinator/lang/'). $lang . '.json',
                'name' => $lang . '.json',
            ];

            $this->stepName = 'Fin '. $lang . '.bin';
            $this->logIcon = '✅';
            $this->stepLog();
        }

        // Envoie le fichier au serveur
        $this->stepName = 'Envoi les langs au serveur ';
        $this->logIcon = '✈️';
        $this->stepLog();

        (new uploadToFtp())($files, '/storage/app/json/skinator/lang/');
    }

    /**
     * Met à jour la base de données grâce aux fichiers exporté
     * @return void
     */
    function updateDB(): void
    {
        $this->currentStep++;
        $this->stepName = 'Mise à jour base de donnée';
        $this->logIcon = '🌱';
        $this->logTitle = 'DATABASE';
        $this->stepLog();

        $result = (new updateDBFromDofusFiles())();
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
     * Lancé depuis le site en ligne, sert à imiter la fonction updateDB() mais sur le site en ligne
     * @return void
     */
    public function UpdateDBFromServer(): void
    {
        $result = (new updateDBFromDofusFiles())();
        $this->newItems = $result['newItems'];
        $this->iconIds = $result['icons'];
    }

    /**
     * Récupère les icones des items / mounts / visages. Juste après la maj de la database
     * @return void
     */
    function getIcons()
    {
        $this->currentStep ++;
        $this->stepName = 'Export icons';
        $this->logIcon = '🌱';
        $this->logTitle = 'GET ICONS';
        $this->stepLog();

        // EXPORT DES ICONS D'ITEMS
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/icons_extractor.py')),
            escapeshellarg($this->dofusContentPath . 'Picto/Items/item_assets_2x.bundle'),
            escapeshellarg(storage_path('app/public/images/icons/items')),
            escapeshellarg(storage_path('app/json/skinator/iconIds.txt')),
        );

        // Execute le python
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if($exitCode != 0) {
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
                'name' => $fileName
            ];
        }

        (new uploadToFtp())($files, '/storage/app/public/images/icons/items/');

        $this->stepName = 'Export visage';
        $this->logIcon = '🌱';
        $this->stepLog();



        // EXPORT DES VISAGES
        // Prépare la commande python
        $command = sprintf(
            'python %s %s %s %s',
            escapeshellarg(base_path('app/Actions/ItemsUpdate/bundle_extractor.py')),
            escapeshellarg($this->dofusContentPath . 'Picto/UI/cosmetic_assets_2x.bundle'),
            escapeshellarg(storage_path('app/public/images/icons/classes/faces/unity')),
            escapeshellarg('heads'),
        );
        // Execute le python
        exec($command, $output, $exitCode);

        // S'il y a une erreur, la retourne
        if($exitCode != 0) {
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
                'name' => $fileName
            ];
        }

        (new uploadToFtp())($files, '/storage/app/public/images/icons/classes/faces/unity/');

        $this->stepName = 'Fin';
        $this->logIcon = '✅';
        $this->stepLog();
    }
}
