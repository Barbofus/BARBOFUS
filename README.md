## BARBOFUS

Projet Git pour le site de BARBE\_\_\_DOUCE

## TECHNO

Tall Stack:

-   Tailwind CSS
-   AlpinJS
-   Laravel
-   Livewire

## INSTALLATION

Pour installer le projet, commencez par le cloner, pensez aussi à créer une Database nommé 'barbofus' avec le logiciel de votre choix, ensuite executez les commandes suivantes dans une console \:

```
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev
```

Si vous n'utilisez pas Laragon ou un autre soft dans le genre, tapez la commande 'php artisan serve' pour ouvrir le site dans le localhost:8000.

N'oubliez pas de modifier votre fichier .env pour y mettre votre connexion Database.

A chaque pull depuis le git, pensez à refaire la commande 'php artisan migrate:fresh --seed' pour reset le contenu de la Database et l'avoir à jour.
