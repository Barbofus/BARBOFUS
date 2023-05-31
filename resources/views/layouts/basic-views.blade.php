@extends('layouts.app')

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
