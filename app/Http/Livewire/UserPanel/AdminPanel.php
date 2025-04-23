<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\ItemsUpdate\updateDBFromDofusFiles;
use App\Actions\ItemsUpdate\uploadToFtp;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class AdminPanel extends Component
{
    // FONCTIONNE AVEC PYTHON 3.12.6

    public array $newItems = [];

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
        $this->updateDB();

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

        foreach ($this->rootToExport as $key => $value) {
            $this->currentStep ++;
            $this->stepName = 'Export '. str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '🌱';
            $this->stepLog();

            // Met à jour la progression en front
            $this->dispatchBrowserEvent('step-progress', [
                'current' => $this->currentStep,
                'stepName' => $this->stepName,
                'maxStep' => $this->maxStep,
            ]);

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

            // Envoie le fichier au serveur
            $this->stepName = 'Envoi au serveur '. str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '✈️';
            $this->stepLog();

            (new uploadToFtp())(storage_path('app/json/skinator/') . $value . '.json', '/storage/app/json/skinator/' . $value . '.json');

            $this->stepName = 'Fin '. str_replace(['data_assets_', '.asset.bundle'], '', $value);
            $this->logIcon = '✅';
            $this->stepLog();
        }
    }

    /**
     * Recupère les fichiers lang.bin puis les transforme en json
     * @return void
     */
    function getLangFiles(): void
    {
        $this->logTitle = 'LOCALIZATION FILES';

        foreach ($this->langs as $lang) {
            $this->currentStep ++;
            $this->stepName = 'Export '. $lang . '.bin';
            $this->logIcon = '🌱';

            $this->stepLog();

            // Met à jour la progression en front
            $this->dispatchBrowserEvent('step-progress', [
                'current' => $this->currentStep,
                'stepName' => $this->stepName,
                'maxStep' => $this->maxStep,
            ]);

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

            // Envoie le fichier au serveur
            $this->stepName = 'Envoi au serveur '. $lang . '.bin';
            $this->logIcon = '✈️';
            $this->stepLog();

            (new uploadToFtp())(storage_path('app/json/skinator/lang/') . $lang . '.json', '/storage/app/json/skinator/lang/' . $lang . '.json');

            $this->stepName = 'Fin '. $lang . '.bin';
            $this->logIcon = '✅';
            $this->stepLog();
        }
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

        $this->newItems = (new updateDBFromDofusFiles())()['newItems'];

        $this->logIcon = '✅';
        $this->stepLog();
    }
}
