@extends('layouts.basic-views')

@section('content')

    <livewire:haven-bag.infinite-havenbag-index wire:key="haven-bag-index{{ rand() }}"/>

@endsection
