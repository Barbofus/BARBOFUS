@extends('layouts.basic-views')

@section('content')

    <livewire:unity-skin.infinite-unity-skin-index wire:key="skin-index{{ rand() }}"/>

@endsection
