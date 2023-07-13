
<x-mail::message>
# Skin posté

Salut <span class="italic">{{ $user->name }}</span>,<br><br>
<span>Ton skin ***ID#{{ $skin->id }}*** en **{{ $skin->race->name }}** à été validé par un membre du Staff.</span>

<div style="text-align: center;"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $skin->image_path ))) }}" alt="Image du skin {{ $skin->id }}"></div>

<x-mail::button :url="$url" :color="'gold'">
Clique pour le voir en action !
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
