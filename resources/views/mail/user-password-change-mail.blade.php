<x-mail::message>
# Mot de passe modifié

Salut <span class="italic">{{ $user->name }}</span>,<br><br>
<span>Ton mot de passe vient d'être changé, si tu n'es pas à l'origine de ce changement, réinitialise-le avec ce bouton.</span>

<x-mail::button :url="$url" :color="'gold'">
Réinitialiser mon mot de passe
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
