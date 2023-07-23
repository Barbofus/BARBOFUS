@extends('layouts.basic-views')

@section('content')

    <h1 class="text-[min(4rem,5vw)] mt-6 font-normal text-center uppercase">Bienvenue sur Barbofus !</h1>
    <h2 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">L'endroit parfait pour chercher et partager tes skins Dofus</h2>

    <div class="h-[max(20vh,150px)] mx-auto w-[min(90vw,1000px)] mt-16 px-1 rounded-md goldGradient">
        <div class="h-full w-full bg-primary overflow-hidden">
            <div class="flex pl-4 gap-x-4 h-full w-fit animate-skinSlide [--custom-animation-time:20s] hover:[animation-play-state:paused]">
                @foreach($skins as $skin)

                    <x-skins-presentation.home-skin-card :skin="$skin" />

                @endforeach
                @foreach($skins as $skin)

                    <x-skins-presentation.home-skin-card :skin="$skin" />

                @endforeach
            </div>
        </div>
    </div>

    <div class="h-48 mt-28 w-screen relative flex justify-center items-center">
        <div class="-z-10 bg-[linear-gradient(rgba(0,0,0,0.05)_50%,0,transparent_100%),linear-gradient(-135deg,var(--goldLit),var(--goldDark))] [background-size:.5em_.5em,100%_100%] absolute w-full h-full skew-y-[1.5deg]"></div>

        <div class="flex w-fit h-fit">
            <div class="w-96 flex justify-center">
                <a href="{{ route('skins.index') }}" target="_blank" class="top-0 px-8 py-3 h-fit text-xl mx-auto font-normal text-goldText border-4 border-primary bg-primary rounded-lg hover:bg-primary-100 hover:border-primary-100 hover:tracking-widest transition-all uppercase">Explorer les skins</a>
            </div>
            <div class="w-96 flex justify-center">
                <a href="{{ route('skins.create') }}" target="_blank" class="px-8 py-3 h-fit text-xl mx-auto font-medium text-primary border-4 border-primary rounded-lg hover:border-primary-100 hover:tracking-widest transition-all uppercase">Poster un skin</a>
            </div>
        </div>
    </div>
@endsection
