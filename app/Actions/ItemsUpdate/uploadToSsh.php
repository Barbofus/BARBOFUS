<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

use phpseclib3\Net\SFTP;
use phpseclib3\Crypt\PublicKeyLoader;

final class uploadToSsh
{
    /**
     * @param  array<int, mixed>  $localFiles
     * @return void
     */
    public function __invoke(array $localFiles, string $remoteDestination)
    {
        // Détails de la connexion SSH
        $ssh_host = '54.38.92.136';
        $ssh_port = 12587;
        $ssh_user = 'debian';
        $ssh_key_path = 'C:/Users/thefl/.ssh/id_rsa_barbofus_renderer';
        $ssh_passphrase = 'Ei6VEk283qq3cY';

        // Vérification de la clé
        if (! file_exists($ssh_key_path)) {
            $this->stepLog('❌ Clé SSH non trouvée à ' . $ssh_key_path);
            exit("Clé SSH non trouvée à $ssh_key_path");
        }

        $key = PublicKeyLoader::load(file_get_contents($ssh_key_path), $ssh_passphrase);

        $sftp = new SFTP($ssh_host, $ssh_port);
        if (! $sftp->login($ssh_user, $key)) {
            $this->stepLog('❌ Échec de la connexion SFTP avec clé privée');
            exit('❌ Échec de la connexion SFTP avec clé privée');
        }

        foreach ($localFiles as $key => $fileInfos) {
            $this->stepLog('OVH 🌱' . ($key + 1) . '/' . count($localFiles) . ' ' . $fileInfos['name']);

            if (! file_exists($fileInfos['file'])) {
                $this->stepLog('✖️ Fichier manquant : ' . $fileInfos['file']);
                continue;
            }

            $remoteFile = rtrim($remoteDestination, '/') . '/' . $fileInfos['name'];
            $success = $sftp->put($remoteFile, $fileInfos['file'], SFTP::SOURCE_LOCAL_FILE);

            if ($success) {
                $this->stepLog('✅ Fichier transféré : ' . $remoteFile);
            } else {
                $this->stepLog('❌ Erreur lors de l\'upload de : ' . $remoteFile);
            }
        }
    }

    /**
     * Ajoute une ligne dans les logs du php artisan serve
     */
    public function stepLog(string $message): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput;
        $output->writeln($message);
    }
}
