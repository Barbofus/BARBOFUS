<x-mail::message>
# Pseudo modifié

Salut <span class="italic">{{ $user->name }}</span>,<br><br>
<span>Ton pseudo vient d'être modifié, si tu n'es pas à l'origine de cette modification, clique sur le bouton pour changer ton mot de passe.</span>

<x-mail::button :url="$url" :color="'gold'">
Changer mon mot de passe
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
