
<x-mail::message>
# Skin refusé

Salut <span class="italic">{{ $user->name }}</span>,<br>
<span>Ton skin ***ID#{{ $skin->id }}*** en **{{ $skin->race->name }}** à été refusé par un membre du Staff.</span>

<div style="text-align: center;"><img class="refused-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $skin->image_path ))) }}" alt="Image du skin {{ $skin->id }}"></div>

@if($skin->refused_reason)
<x-mail::panel>
{{ $skin->refused_reason }}
</x-mail::panel>
@endif

<x-mail::button :url="$url" :color="'gold'">
Clique pour le modifier
</x-mail::button>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>