<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

final class uploadToFtp
{
    /**
     * @param  array<int, mixed>  $localFiles
     * @return void
     */
    public function __invoke(array $localFiles, string $remoteDestination)
    {
        // Détails de la connexion FTP
        $ftp_server = 'ftp.lema1810.odns.fr';  // Adresse du serveur FTP
        $ftp_user_name = 'lema1810@barbofus.com';      // Nom d'utilisateur FTP
        $ftp_user_pass = '6Tcn-meGp-mLb@';      // Mot de passe FTP

        // Connexion au serveur FTP
        $ftp_conn = ftp_connect($ftp_server) or exit('Impossible de se connecter au serveur FTP');

        // Se connecter avec les identifiants
        $login = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);

        // Vérifier la connexion
        if (! $login) {
            exit('Échec de la connexion FTP avec ces identifiants');
        }

        // Passer en mode passif si nécessaire
        ftp_pasv($ftp_conn, true);

        foreach ($localFiles as $key => $fileInfos) {
            $this->stepLog('🌱'.($key + 1).'/'.count($localFiles).' '.$fileInfos['name']);

            if (! file_exists($fileInfos['file'])) {
                $this->stepLog('✖️'.($key + 1).'/'.count($localFiles).' Aucun fichier trouvé '.$fileInfos['name']);

                continue;
            }

            // Transfert du fichier local vers le serveur FTP
            $upload = ftp_put($ftp_conn, $remoteDestination.$fileInfos['name'], $fileInfos['file'], FTP_BINARY);

            // Vérifier si l'upload a réussi
            if (! $upload) {
                $this->stepLog('❌'.($key + 1).'/'.count($localFiles).' Erreur lors de l\'upload du fichier '.$fileInfos['name']);
            } else {
                $this->stepLog('✅'.($key + 1).'/'.count($localFiles).' Le fichier a été téléchargé avec succès à '.$remoteDestination.$fileInfos['name']);
            }
        }

        // Fermer la connexion FTP
        ftp_close($ftp_conn);
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
