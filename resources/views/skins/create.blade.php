@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">Création</h1>
    <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">Présente nous tes skins !</h2>

    <a href="{{ route('unity-skins.create') }}" class="w-fit mx-auto flex flex-col items-center">
        <p class="text-2xl font-medium">NOUVEAU !</p>
        <div class="px-8 py-3 text-lg font-normal text-primary goldGradient rounded-lg hover:brightness-110 hover:tracking-widest transition-all focus:brightness-75 uppercase">
            Poster un skin Unity
        </div>
    </a>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" id="skin-form" action="{{ route('skins.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf

            <x-forms.skin-form :$races :action="'store'"/>

        </form>
    </div>
@endsection
