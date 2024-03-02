
<x-mail::message>
# Skin refusé

Salut <span class="italic">{{ $user->name }}</span>,<br><br>
<span>Ton skin ***{{ ($skin->name) ?: 'ID#'.$skin->id }}*** en **{{ $skin->race->name }}** a été refusé par un membre du Staff.</span>

<div style="text-align: center;"><img class="refused-img" src="{{ asset('storage/' . $skin->image_path ) }}" alt="Image du skin {{ $skin->id }}"></div>

@if($skin->refused_reason)
<x-mail::panel>
{{ $skin->refused_reason }}
</x-mail::panel>
@endif

<x-mail::button :url="$url" :color="'gold'">
Clique pour le modifier
</x-mail::button>

<br><br>

Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche: <a href="{{ $url }}" class="blue">{{ $url }}</a>

Cordialement,<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
