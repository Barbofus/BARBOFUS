<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['notification',':read'])
<x-notification.skin-posted :notification="$notification" ::read="$read" >

{{ $slot ?? "" }}
</x-notification.skin-posted>