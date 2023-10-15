@extends('layouts.basic-views')

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">Perdu !</h1>
        <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">RIP ! Tu t'es retrouvé sur une page qui n'existe pas :/</h2>

        <img src="{{ asset('storage/images/misc_ui/Barbe_pleure.webp') }}" alt="Barbe en pleure" class="w-[min(80vw,20rem)]">
    </div>
@endsection
