@extends('layouts.basic-views')

@section('content')

    <div class="pb-16">
        <h1 class="text-[min(4rem,12vw)] mt-16 font-normal text-center uppercase">Bienvenue sur Barbofus !</h1>
        <h2 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">L'endroit parfait pour chercher et partager tes skins Dofus</h2>

        {{-- Présentation du site --}}
        <div class="h-[max(20vh,220px)] mx-auto w-[min(90vw,1000px)] mt-16 px-1 rounded-md goldGradient">
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

        <div class="h-48 mt-28 max-w-screen relative flex justify-center items-center">
            <div class="-z-10 bg-[linear-gradient(rgba(0,0,0,0.05)_50%,0,transparent_100%),linear-gradient(-135deg,var(--goldLit),var(--goldDark))] [background-size:.5em_.5em,100%_100%] absolute w-full h-full skew-y-[1.5deg]"></div>

            <div class="flex min-[800px]:flex-row gap-y-4 flex-col w-fit h-fit">
                <div class="w-96 flex justify-center">
                    <a href="{{ route('skins.index') }}" class="top-0 px-8 py-3 h-fit text-xl mx-auto font-normal text-goldText border-4 border-primary bg-primary rounded-lg hover:bg-primary-100 hover:border-primary-100 hover:tracking-widest transition-all uppercase">Explorer les skins</a>
                </div>
                <div class="w-96 flex justify-center">
                    <a href="{{ route('skins.create') }}" class="px-8 py-3 h-fit text-xl mx-auto font-medium text-primary border-4 border-primary rounded-lg hover:border-primary-100 hover:tracking-widest transition-all uppercase">Poster un skin</a>
                </div>
            </div>
        </div>

        {{-- Présentation Barbe --}}
        <h1 class="text-[min(4rem,5vw)] mt-32 font-normal text-center uppercase">Découvre Barbe Douce</h1>
        <h2 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">Le Streameur à l'origine de ce site</h2>

        <div class="w-[min(90vw,1000px)] aspect-video mx-auto mt-16 relative">
            <x-utils.twitch-embed />
        </div>

        <div class="w-[min(90vw,1000px)] mx-auto mt-16 flex min-[800px]:flex-row flex-col justify-between gap-8">
            <div>
                <div class="text-secondary text-xl font-thin flex flex-col gap-y-4">
                    <p class="mb-4 font-normal uppercase">Petite présentation rapide & efficace :</p>

                    <p>• Mathieu - Barbe douce.</p>
                    <p>• Je suis partenaire Twitch & Ankama</p>
                    <p>• En live chaque jour dès 7-8h sur : <a href="https://twitch.tv/barbe___douce" target="_blank" class="text-goldText hover:text-goldTextLit">twitch.tv/barbe___douce</a></p>
                    <p>• Contact Pro : <span class="text-goldText">mathieu.lehr@gmail.com</span></p>
                </div>

                <!-- Réseaux sociaux -->
                <div class="flex gap-x-4  items-center justify-center relative h-24 mx-auto">
                    <a href="https://www.tiktok.com/@barbe___douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_TikTok.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                    <a href="https://www.instagram.com/barbe.douce.twitch/" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Instagram.webp') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                    <a href="https://twitter.com/DouceBarbe" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Twitter.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                    <a href="https://www.youtube.com/channel/UCJIBwLWxtdrVCwuX-F3W9bA?view_as=subscriber" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Youtube.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                    <a href="https://www.twitch.tv/barbe___douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Twitch.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                    <a href="https://discord.gg/YKHc4RD" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Discord.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1"></a>
                </div>
            </div>
            <img class="w-[min(90vw,300px)] max-[799px]:rounded-full max-[799px]:mx-auto" src="{{ asset('storage/images/misc_ui/portrait.webp') }}">
        </div>

        {{-- Remerciements --}}
        <h1 class="text-[min(4rem,5vw)] mt-32 font-normal text-center uppercase">Remerciements</h1>

        <div class="flex min-[800px]:flex-row flex-col gap-x-16 gap-y-8 justify-center items-center">
            <a href="https://dofusdb.fr/fr/" target="_blank" class="flex gap-x-4 items-center hover:bg-primary-100 hover:rounded-md bg-primary transition-all p-2">
                <img src="https://dofusdb.fr/icons/favicon.ico">
                <div class="flex flex-col justify-center items-start">
                    <p class="text-xl text-secondary font-light uppercase">DofusDB</p>
                    <p class="italic font-thin text-inactiveText">API des Items</p>
                </div>
            </a>

            <a href="https://dofusbook.net/fr/" target="_blank" class="flex gap-x-4 items-center hover:bg-primary-100 hover:rounded-md bg-primary transition-all p-2">
                <img src="{{ asset('storage/images/misc_ui/dofusbook.ico') }}">
                <div class="flex flex-col justify-center items-start">
                    <p class="text-xl text-secondary font-light uppercase">DofusBook</p>
                    <p class="italic font-thin text-inactiveText">Le Skinator</p>
                </div>
            </a>
        </div>
    </div>

    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js'])
@endsection
