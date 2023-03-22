@extends('layouts.app')

@section('app-content')

    <x-main-header />

    <x-main-navbar />

    @yield('content')
@endsection
