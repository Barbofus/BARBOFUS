@extends('layouts.basic-views')

@section('content')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur l'accueil du site !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="grid grid-cols-10">
        @foreach($skins as $skin)

            <x-skins-presentation.home-skin-card :skin="$skin" />

        @endforeach
    </div>
@endsection
