<?php

declare(strict_types=1);

namespace App\Actions\ItemsUpdate;

use App\Models\Like;
use App\Models\UnityLike;
use Illuminate\Support\Facades\Auth;

final class uploadToFtp
{
    /**
     * @return void
     */
    public function __invoke($localFilePath, $remoteFilePath)
    {
        // Détails de la connexion FTP
        $ftp_server = "ftp.lema1810.odns.fr";  // Adresse du serveur FTP
        $ftp_user_name = "lema1810@barbofus.com";      // Nom d'utilisateur FTP
        $ftp_user_pass = "6Tcn-meGp-mLb@";      // Mot de passe FTP

        // Connexion au serveur FTP
        $ftp_conn = ftp_connect($ftp_server) or die("Impossible de se connecter au serveur FTP");

        // Se connecter avec les identifiants
        $login = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);

        // Vérifier la connexion
        if (!$login) {
            die("Échec de la connexion FTP avec ces identifiants");
        }

        // Passer en mode passif si nécessaire
        ftp_pasv($ftp_conn, true);

        // Transfert du fichier local vers le serveur FTP
        $upload = ftp_put($ftp_conn, $remoteFilePath, $localFilePath, FTP_BINARY);

        // Vérifier si l'upload a réussi
        if (!$upload) {
            echo "Erreur lors de l'upload du fichier $localFilePath.";
        } else {
            echo "Le fichier a été téléchargé avec succès à $remoteFilePath.";
        }

        // Fermer la connexion FTP
        ftp_close($ftp_conn);
    }
}
