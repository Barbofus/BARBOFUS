
<x-mail::message>
# {{ __('barbofus.contentSkinRefused', ['name' => ($skin->name) ?: 'ID#'.$skin->id]) }}

{{ __('barbofus.emailContentHello') }} <span class="italic">{{ $user->name }}</span>,<br><br>
<span>{{ __('barbofus.emailContentSkinRefused', ['name' => ($skin->name) ?: 'ID#'.$skin->id, 'class' => $skin->race->name]) }}</span>

<div style="text-align: center;"><img class="refused-img" src="{{ asset('storage/' . $skin->image_path ) }}" alt="Image du skin {{ $skin->id }}"></div>

@if($skin->refused_reason)
<x-mail::panel>
{{ $skin->refused_reason }}
</x-mail::panel>
@endif

<x-mail::button :url="$url" :color="'gold'">
{{ __('barbofus.emailButtonSkinRefused') }}
</x-mail::button>

<br><br>

{{ __('barbofus.emailFooterLink') }} <a href="{{ $url }}" class="blue">{{ $url }}</a>

{{ __('barbofus.emailFooterCheers') }}<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
