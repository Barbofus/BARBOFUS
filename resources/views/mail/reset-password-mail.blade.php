@extends('layouts.mail')

@section('mail-subject')
    Réinitialisation de mot passe
@endsection

@section('mail-sentence')
    Nous avons reçu une requête de réinitialisation de mot de passe.<br>
    Si tu n'es pas à l'origine de cette demande, ne prend pas en compte la suite de ce mail.<br>
    Sinon, pour réinitialiser ton mot de passe, clique sur le bouton plus bas.
@endsection

@section('mail-button')
    <a href="{{ $url }}">Réinitialiser mon mot de passe</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
