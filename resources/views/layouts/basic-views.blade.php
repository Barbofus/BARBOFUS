@extends('layouts.app')

@section('app-meta-image')
    @yield('meta-image', asset('storage/images/misc_ui/Barbofus_Logo_Full.png'))
@endsection

@section('app-content')

    <x-main-header />

    {{-- Notifications --}}
    @auth
        <livewire:notifications.notifications-list/>
    @endauth

    <x-main-navbar />

    @yield('content')

    <x-utils.scroll-to-top />

    <x-footer />
@endsection
