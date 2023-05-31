@extends('layouts.app')

@section('app-content')

    <x-main-header />

    <x-main-navbar />

    @yield('content')

    <x-utils.scroll-to-top />

    <x-footer />
@endsection
