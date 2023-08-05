@extends('layouts.mail')

@section('mail-subject')
    Skin refusé
@endsection

@section('mail-sentence')
    Ton skin <span class="font-normal italic">ID#{{ $skin->id }}</span> en <span class="font-normal">{{ $skin->race->name }}</span> a été refusé par un membre du Staff.
@endsection

@section('mail-body')
    @if($skin->refused_reason)
        <div class="py-4 px-6 bg-[rgba(255,50,50,0.3)] text-red-500 border-l-[3px] border-red-500 rounded-r-md mb-6">{{ $skin->refused_reason }}</div>
    @endif
    <div class="flex justify-center"><img class="p-4 bg-[rgba(255,50,50,0.3)] border-[3px] border-red-500 rounded-md" src="{{ asset('storage/' . $skin->image_path ) }}" alt="Image du skin {{ $skin->id }}"></div>
@endsection

@section('mail-button')
    <a href="{{ $url }}">Clique pour le modifier</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
