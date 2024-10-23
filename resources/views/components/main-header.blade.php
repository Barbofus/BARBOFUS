<!-- En-tête -->
<div id="header"
     class="w-full h-0 bg-secondary relative z-20 hidden
          [@media(min-height:950px)_and_(min-width:901px)]:block [@media(min-height:950px)_and_(min-width:901px)]:h-[15vh] [@media(min-height:950px)_and_(min-width:901px)]:min-h-[150px] overflow-hidden">

    {{-- Arrière plan --}}
    <div class="absolute w-full h-full flex items-center justify-center bg-primary">
        <div class="w-[min(100vw,1500px)] relative h-full">

            {{-- Image arrière plan --}}
            <img src="{{ asset('storage/images/misc_ui/header-background.avif') }}" alt="Barbofus Background" loading="lazy" width="1500" height="783" class="animate-slideY [--custom-translate-y:-35px] [--custom-animation-time:20s] absolute left-0 bottom-[-200px]">

            {{-- Fondu avec le fond de couleur unis --}}
            <div class="bg-gradient-to-r from-primary to-transparent h-full w-[300px] absolute left-0 top-0 z-10"></div>
            <div class="bg-gradient-to-l from-primary to-transparent h-full w-[300px] absolute right-0 top-0 z-10"></div>
        </div>
    </div>

    {{-- Section logo --}}
    <div class="flex h-full justify-center z-10 relative">
        <div class="max-w-1/2 h-full flex justify-center relative overflow-hidden">

            {{-- Degradé derrière logo --}}
            <div class="bg-[linear-gradient(90deg,transparent_0%,rgba(0,0,0,0.65)_25%,rgba(0,0,0,.65)_75%,transparent_100%)] via-primary h-full w-full absolute -z-10"></div>

            {{-- Logo --}}
            <a href="{{ route('home') }}" title="Accueil Barbofus"><img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.webp') }}" loading="lazy" height="15vh" alt="Logo Barbofus" class="h-full" draggable="false" /></a>
        </div>
    </div>

    {{-- Décoration gauche --}}
    <div class="h-[min(2vw,30%)] w-1/2 absolute bottom-[-1px] left-0 z-10">

        {{-- Pente --}}
        <div class="h-full w-full bg-secondary [clip-path:polygon(0%_0%,100%_80%,100%_100%,0%_100%)] js-slope"></div>

        {{-- Dofus / créatures --}}
        <img src="{{ asset('storage/images/misc_ui/dofus_ocre.webp') }}" alt="Dofus Ocre" draggable="false" width="65" height="80" loading="lazy" class="js-subject absolute h-20 right-[min(calc(65%+71px),35.6875rem)] bottom-0 translate-y-[2px] rotate-45 opacity-0">
        <img src="{{ asset('storage/images/misc_ui/dofus_emeraude.webp') }}" alt="Dofus Emeraude" draggable="false" width="65" height="80" loading="lazy" class="js-subject absolute h-20 right-[min(65%,31.25rem)] bottom-0 translate-y-[11px] rotate-[115deg] opacity-0">

        {{-- Tofu --}}
        <img src="{{ asset('storage/images/misc_ui/tofu.webp') }}" alt="Tofu" loading="lazy" draggable="false" width="64" height="64" class="js-subject absolute right-[46.875rem] bottom-0 -translate-y-[40px] opacity-0">
    </div>

    {{-- Décoration droite --}}
    <div class="h-[min(2vw,30%)] w-[calc(50%+1px)] absolute bottom-[-1px] right-0 z-10">

        {{-- Pente --}}
        <div class="h-full w-full bg-secondary [clip-path:polygon(0%_80%,100%_0%,100%_100%,0%_100%)]"></div>

        {{-- Dofus / créatures --}}
        <img src="{{ asset('storage/images/misc_ui/dofus_cawotte.webp') }}" alt="Dofus Cawotte" draggable="false" width="65" height="80" loading="lazy" class="js-subject-r absolute h-20 left-[40.625rem] bottom-0 translate-y-[1px] -rotate-[25deg] opacity-0">

        {{-- Champ champ --}}
        <img src="{{ asset('storage/images/misc_ui/champchamp.webp') }}" alt="Champ Champ" draggable="false" width="64" height="64" loading="lazy" class="js-subject-r absolute left-[min(70%,25rem)] bottom-0 scale-x-[-1] translate-y-[14px] opacity-0">

        {{-- Wabbit --}}
        <img src="{{ asset('storage/images/misc_ui/wabbit.webp') }}" alt="Wabbit" loading="lazy" draggable="false" width="51" height="64" class="js-subject-r absolute left-[37.5rem] bottom-0 translate-y-[19px] opacity-0">
    </div>

    {{-- Live partout--}}
    <div class="opacity-0">
        @if(Route::currentRouteName() != 'skins.index' && Route::currentRouteName() != 'home' && Route::currentRouteName() != 'unity-skins.index')
            <x-utils.twitch-embed />
        @endif
    </div>

    @vite('resources/js/header/OnSlope.js')
</div>
