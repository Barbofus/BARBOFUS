@extends('layouts.mail')

@section('mail-subject')
    Skin posté
@endsection

@section('mail-sentence')
    Ton skin <span class="font-normal italic">ID#{{ $skin->id }}</span> en <span class="font-normal">{{ $skin->race->name }}</span> a été validé par un membre du Staff.
@endsection

@section('mail-body')
    <div class="flex justify-center"><img class="p-4" src="{{ asset('storage/' . $skin->image_path ) }}" alt="Image du skin {{ $skin->id }}"></div>
@endsection

@section('mail-button')
    <a href="{{ $url }}">Clique pour le voir en action !</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
