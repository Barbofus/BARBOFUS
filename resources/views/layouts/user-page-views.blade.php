@extends('layouts.app')

@section('app-content')

    <x-main-header />

    <x-main-navbar />

    <x-user-page-navbar>
        @yield('content')
    </x-user-page-navbar>

@endsection
