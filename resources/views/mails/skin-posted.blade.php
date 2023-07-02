
<x-mail::message>
# Skin posté

Salut <span class="italic">{{ $user->name }}</span>,<br>
<span>Ton skin ***ID#{{ $skin->id }}*** en **{{ $skin->race->name }}** à été validé par un membre du Staff.</span>

<div style="text-align: center;"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $skin->image_path ))) }}" alt="Image du skin {{ $skin->id }}"></div>

<x-mail::button :url="$url" :color="'gold'">
    Clique pour le voir en action !
</x-mail::button>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
