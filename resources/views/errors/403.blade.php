@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">{{ __('barbofus.contentError') }}</h1>
    <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">403 - {{ __('http-statuses.403') }}</h2>
@endsection
