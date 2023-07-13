<x-mail::message>
# Vérification d'E-mail

Salut <span class="italic">{{ $notifiable->name }}</span>,<br><br>
<span>Merci de cliquer sur ce lien pour valider ton adresse e-mail et te connecter à Barbofus.</span>

<x-mail::button :url="$url" :color="'gold'">
Valider l'E-mail
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
