@extends('layouts.mail')

@section('content')
    Hey, your skin ID#{{ $skin->id }} en {{ $skin->race->name }} à  été refusé par un membre du Staff
    @if($skin->refused_reason)
        car {{ $skin->refused_reason }}
    @else
        .
    @endif
@endsection
