
<x-mail::message>
# {{ __('barbofus.emailTitleSkinPosted', ['name' => ($skin->name) ?: 'ID#'.$skin->id]) }}

{{ __('barbofus.emailContentHello') }} <span class="italic">{{ $user->name }}</span>,<br><br>
<span>{{ __('barbofus.emailContentSkinPosted', ['name' => ($skin->name) ?: 'ID#'.$skin->id, 'class' => $skin->race->name]) }}</span>

<div style="text-align: center;"><img src="{{ asset('storage/' . $skin->image_path ) }}" alt="Image du skin {{ $skin->id }}"></div>

<x-mail::button :url="$url" :color="'gold'">
{{ __('barbofus.emailButtonSkinPosted') }}
</x-mail::button>

<br><br>

{{ __('barbofus.emailFooterLink') }} <a href="{{ $url }}" class="blue">{{ $url }}</a>

{{ __('barbofus.emailFooterCheers') }}<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
