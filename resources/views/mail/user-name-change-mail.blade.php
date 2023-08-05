
@extends('layouts.mail')

@section('mail-subject')
    Pseudo modifié
@endsection

@section('mail-sentence')
    Ton pseudo vient d'être modifié, si tu n'es pas à l'origine de cette modification, clique sur le bouton pour changer ton mot de passe.
@endsection

@section('mail-button')
    <a href="{{ $url }}">Changer mon mot de passe</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
