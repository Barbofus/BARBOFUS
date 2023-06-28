@extends('layouts.user-page-views')

@section('content')
    <div x-data="{
        loading: false
    }">
        <h1 class="text-[min(3.5rem,max(5vw,1.5rem))] font-normal text-center uppercase">Panel Administrateur</h1>
        <h2 class="text-2xl font-thin text-center mb-8 uppercase">Gestion de l'API DofusDB</h2>

        <div class="flex justify-center w-full mt-16">

            @if($needDofusDBUpdate)
            <a  href="{{ route('dofusDBApi') }}"
                class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110"
                x-on:click="loading = true">Récupérer les items</a>
            @else
            <div class="w-48 p-4 text-2xl text-primary text-center font-light rounded-md bg-inactiveText">API DofusDB à jour</div>
            @endif

        </div>

        <div class="flex flex-col gap-y-2 items-center mt-10"
            x-show="loading"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-full"
            x-transition:enter-end="opacity-100">
            <img class="animate-pulseFast h-32 w-32 opacity-25" src="{{ asset('storage/images/misc_ui/logo_barbe_x256.png') }}" draggable="false">
            <p class="text-2xl text-secondary animate-pulseFast opacity-25 font-light">Récupération des items</p>
        </div>
    </div>
@endsection
