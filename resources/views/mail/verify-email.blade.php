<x-mail::message>
#  {{ __('barbofus.emailTitleVerifyEmail') }}

{{ __('barbofus.emailContentHello') }} <span class="italic">{{ $notifiable->name }}</span>,<br><br>
<span>{{ __('barbofus.emailContentVerifyEmail') }}</span>

<x-mail::button :url="$url" :color="'gold'">
{{ __('barbofus.emailButtonVerifyEmail') }}
</x-mail::button>

<br><br>

{{ __('barbofus.emailFooterLink') }} <a href="{{ $url }}" class="blue">{{ $url }}</a>

{{ __('barbofus.emailFooterCheers') }}<br>
<span class="font-bold">{{ config('app.name') }}</span>
</x-mail::message>
