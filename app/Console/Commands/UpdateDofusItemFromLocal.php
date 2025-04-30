<?php

namespace App\Console\Commands;

use App\Actions\ItemsUpdate\updateDBFromDofusFiles;
use Illuminate\Console\Command;

class UpdateDofusItemFromLocal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dofus-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute le script qui met à jour la base de donnée grâce aux fichiers root de dofus';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Début de la mise à jour');
        (new updateDBFromDofusFiles)();
        $this->info('Base de données mise à jour avec succès');
    }
}
