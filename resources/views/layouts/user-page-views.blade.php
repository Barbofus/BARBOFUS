@extends('layouts.app')

@section('app-content')

    <x-main-header />

    {{-- Notifications --}}
    @auth
        <livewire:notifications.notifications-list/>
    @endauth

    <x-main-navbar />

    <x-user-page-navbar>
        @yield('content')
    </x-user-page-navbar>

    <x-footer />

@endsection
