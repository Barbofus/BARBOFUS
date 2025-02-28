<x-mail::message>
# {{ __('barbofus.emailTitlePasswordChanged') }}

{{ __('barbofus.emailContentHello') }} <span class="italic">{{ $user->name }}</span>,<br><br>
<span>{{ __('barbofus.emailContentPasswordChange') }}</span>

<x-mail::button :url="$url" :color="'gold'">
{{ __('barbofus.emailButtonResetPassword') }}
</x-mail::button>

<br><br>

{{ __('barbofus.emailFooterLink') }} <a href="{{ $url }}" class="blue">{{ $url }}</a>

{{ __('barbofus.emailFooterCheers') }}<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
