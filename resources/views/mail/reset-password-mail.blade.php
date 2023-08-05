<x-mail::message>
# Réinitialisation de mot passe

Salut <span class="italic">{{ $user->name }}</span>,<br><br>
<span>Nous avons reçu une requête de réinitialisation de mot de passe.</span><br>
Si tu n'es pas à l'origine de cette demande, ne prend pas en compte la suite de ce mail.<br>
Sinon, pour réinitialiser ton mot de passe, clique sur le bouton plus bas

<x-mail::button :url="$url" :color="'gold'">
Réinitialiser mon mot de passe
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
