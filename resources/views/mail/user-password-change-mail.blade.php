@extends('layouts.mail')

@section('mail-subject')
    Mot de passe modifié
@endsection

@section('mail-sentence')
    Ton mot de passe vient d'être changé, si tu n'es pas à l'origine de ce changement, réinitialise-le avec ce bouton.
@endsection

@section('mail-button')
    <a href="{{ $url }}">Réinitialiser mon mot de passe</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
