@extends('layouts.basic-views')

@section('content')

    <div class="pb-16">
        <h1 class="text-[min(4rem,12vw)] mt-16 font-normal text-center uppercase">Découvre et partage les skins dofus</h1>
        <h2 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">Bienvenue sur le site, explore la gallerie de skin, ou poste les tiens et deviens la miss'skin de Dofus !</h2>

        {{-- Présentation du site --}}
        <div class="h-[max(20vh,13.75rem)] mx-auto w-[min(90vw,62.5rem)] mt-16 px-1 rounded-md goldGradient">
            <div class="h-full w-full bg-primary overflow-hidden">
                <div class="slider flex pl-4 gap-x-4 h-full w-fit translate-x-0">
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
                    <a href="{{ route('skins.index') }}" title="Galerie de skins dofus" class="top-0 px-8 py-3 h-fit text-xl mx-auto font-normal text-goldText border-4 border-primary bg-primary rounded-lg hover:bg-primary-100 hover:border-primary-100 hover:tracking-widest transition-all uppercase">Explorer les skins</a>
                </div>
                <div class="w-96 flex justify-center">
                    <a href="{{ route('skins.create') }}" title="Partage ton skin dofus" class="px-8 py-3 h-fit text-xl mx-auto font-medium text-primary border-4 border-primary rounded-lg hover:border-primary-100 hover:tracking-widest transition-all uppercase">Poster un skin</a>
                </div>
            </div>
        </div>

        {{-- Présentation Barbe --}}
        <h2 class="text-[min(4rem,5vw)] mt-32 font-normal text-center uppercase">Découvre Barbe Douce</h2>
        <h3 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">Le Streameur à l'origine de ce site</h3>

        <div class="w-[min(90vw,62.5rem)] aspect-video mx-auto mt-16 relative">
            <x-utils.twitch-embed />
        </div>

        <div class="w-[min(90vw,62.5rem)] mx-auto mt-16 flex min-[800px]:flex-row flex-col justify-between gap-8">
            <div>
                <div class="text-secondary text-xl font-thin flex flex-col gap-y-4 [&>p>a]:inline-block [&>p>a]:h-12 [&>p>a]:text-goldText [&>p>a:hover]:text-goldTextLit [&>p>a]:transition-all [&>p>a:hover]:-skew-x-12">
                    <p class="mb-4 font-normal uppercase">Petite présentation rapide & efficace :</p>

                    <p>• Mathieu - Barbe Douce</p>
                    <p>• Je suis partenaire <a href="https://www.twitch.tv/barbe___douce" title="Page Twitch de Barbe Douce" target="_blank">Twitch</a>, <a href="https://www.ankama.com/fr" title="Site web d'Ankama" target="_blank">Ankama</a> & <a href="https://www.topachat.com/accueil/index.php?mtm_campaign=mkstrm" title="Partenaire TopAchat" target="_blank">TopAchat</a></p>
                    <p>• En live chaque jour dès 7-8h sur : <a href="https://twitch.tv/barbe___douce" title="Page Twitch de Barbe Douce" target="_blank">twitch.tv/barbe___douce</a></p>
                    <p>• Contact Pro : <a href="mailto:mathieu.lehr@gmail.com?subject=Contact a partir du site {{ config('app.name') }}" title="Envoyer un mail">mathieu.lehr@gmail.com</a></p>
                </div>

                <!-- Réseaux sociaux -->
                <div class="flex flex-wrap gap-x-4 items-center justify-center relative h-24 mx-auto">
                    <a href="https://www.tiktok.com/@barbe___douce" title="Page TikTok de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_TikTok.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo TikTok"></a>
                    <a href="https://www.instagram.com/barbe.douce.twitch/" title="Page Instagram de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Instagram.webp') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo Instagram"></a>
                    <a href="https://twitter.com/DouceBarbe" title="Page Twitter de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Twitter.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo Twitter"></a>
                    <a href="https://www.youtube.com/channel/UCJIBwLWxtdrVCwuX-F3W9bA?view_as=subscriber" title="Page Youtube de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Youtube.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo Youtube"></a>
                    <a href="https://www.twitch.tv/barbe___douce" title="Page Twitch de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Twitch.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo Twitch"></a>
                    <a href="https://discord.gg/YKHc4RD" title="Serveur Discord de Barbe Douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Discord.png') }}" class="h-12 transition-all duration-100 hover:-translate-y-1" height="48" alt="Logo Discord"></a>
                </div>
            </div>
            <img class="h-[22rem] max-[799px]:rounded-full max-[799px]:mx-auto" src="{{ asset('storage/images/misc_ui/portrait.avif') }}" height="352" alt="Portrait de Barbe Douce">
        </div>

        {{-- Remerciements --}}
        <h2 class="text-[min(4rem,5vw)] mt-32 font-normal text-center uppercase">Remerciements</h2>

        <div class="flex min-[800px]:flex-row flex-col gap-x-16 gap-y-8 justify-center items-center">
            <a href="https://dofusdb.fr/fr/" title="DofusDB" target="_blank" class="flex gap-x-4 items-center hover:bg-primary-100 hover:rounded-md bg-primary transition-all p-2">
                <img src="https://dofusdb.fr/icons/favicon.ico" height="48" width="48" alt="Logo DofusDB">
                <div class="flex flex-col justify-center items-start">
                    <p class="text-xl text-secondary font-light uppercase">DofusDB</p>
                    <p class="italic font-thin text-secondary">API des Items</p>
                </div>
            </a>

            <a href="https://dofusbook.net/fr/" title="DofusBook" target="_blank" class="flex gap-x-4 items-center hover:bg-primary-100 hover:rounded-md bg-primary transition-all p-2">
                <img src="{{ asset('storage/images/misc_ui/dofusbook.ico') }}" height="48" width="48" alt="Logo DofusBook">
                <div class="flex flex-col justify-center items-start">
                    <p class="text-xl text-secondary font-light uppercase">DofusBook</p>
                    <p class="italic font-thin text-secondary">Le Skinator</p>
                </div>
            </a>
        </div>
    </div>

    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js', 'resources/js/skins/InfiniteDragSlide.js'])
@endsection
