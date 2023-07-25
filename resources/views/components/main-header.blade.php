<!-- En-tête -->
<div id="header"
     class="w-full h-0 bg-secondary relative z-20 invisible [@media(min-height:950px)_and_(min-width:901px)]
          [@media(min-height:950px)_and_(min-width:901px)]:visible [@media(min-height:950px)_and_(min-width:901px)]:h-[15vh] [@media(min-height:950px)_and_(min-width:901px)]:min-h-[150px] ">

    {{-- Arrière plan --}}
    <div class="absolute w-full h-full flex items-center justify-center bg-primary">
        <div class="w-[min(100vw,1500px)] relative">

            {{-- Image arrière plan --}}
            <img src="{{ asset('storage/images/misc_ui/Barbofus_Logo_Background.jpg') }}" class="animate-slideY [--custom-translate-y:-35px] [--custom-animation-time:20s]">

            {{-- Fondu avec le fond de couleur unis --}}
            <div class="bg-gradient-to-r from-primary via-primary to-transparent h-full w-[300px] absolute left-0 top-0 z-10"></div>
            <div class="bg-gradient-to-l from-primary via-primary to-transparent h-full w-[300px] absolute right-0 top-0 z-10"></div>
        </div>
    </div>

    {{-- Section logo --}}
    <div class="flex h-full justify-center z-10 relative">
        <div class="max-w-1/2 h-full flex justify-center relative overflow-hidden">

            {{-- Degradé derrière logo --}}
            <div class="bg-[linear-gradient(90deg,transparent_0%,rgba(0,0,0,0.65)_25%,rgba(0,0,0,.65)_75%,transparent_100%)] via-primary h-full w-full absolute -z-10"></div>

            {{-- Logo --}}
            <a href="{{ route('home') }}" target="_blank"><img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.png') }}" class="h-full" draggable="false" /></a>
        </div>
    </div>

    {{-- Décoration gauche --}}
    <div class="h-[2vw] w-1/2 absolute bottom-[-1px] left-0 z-10">

        {{-- Pente --}}
        <div class="h-full w-full bg-secondary [clip-path:polygon(0%_0%,100%_80%,100%_100%,0%_100%)] js-slope"></div>

        {{-- Dofus / créatures --}}
        <img src="{{ asset('storage/images/misc_ui/dofus_ocre.png') }}" class="js-subject absolute h-20 [--custom-right:min(calc(65%+71px),571px)] right-[var(--custom-right)] bottom-0 translate-y-[2px] rotate-45">
        <img src="{{ asset('storage/images/misc_ui/dofus_emeraude.png') }}" class="js-subject absolute h-20 [--custom-right:min(65%,500px)] right-[var(--custom-right)] bottom-0 translate-y-[11px] rotate-[115deg]">
    </div>

    <div class="h-[2vw] w-[calc(50%+1px)] absolute bottom-[-1px] right-0 bg-secondary z-10 [clip-path:polygon(0%_80%,100%_0%,100%_100%,0%_100%)]"></div>

    {{-- Décorations (monstres / dofus) --}}
    <div class="relative z-10">
    </div>

    @vite('resources/js/header/OnSlope.js')
</div>
