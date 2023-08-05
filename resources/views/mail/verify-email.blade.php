@extends('layouts.mail')

@section('mail-subject')
    Vérification d'E-mail
@endsection

@section('mail-sentence')
    Merci de cliquer sur ce lien pour valider ton adresse e-mail et te connecter à Barbofus.
@endsection

@section('mail-button')
    <a href="{{ $url }}">Valider l'E-mail</a>
@endsection

@section('mail-url')
    <a href="{{ $url }}">{{ $url }}</a>
@endsection
