@extends('layouts.mail')

@section('content')
    Hey, your skin ID#{{ $skin->id }} en {{ $skin->race->name }} à  été validé par un membre du Staff. GG {{ $notifiable->name }}
@endsection
