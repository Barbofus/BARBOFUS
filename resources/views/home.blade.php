@extends('layouts.basic-views')

@section('content')

    <div class="pb-16">
        <h1 class="text-[min(4rem,8vw)] mt-16 font-normal text-center uppercase">Barbofus, la galerie de skins dofus</h1>
        <h2 class="text-2xl font-thin text-center mt-2 mb-8 uppercase">Bienvenue sur le site, explore la gallerie de skin, ou poste les tiens et deviens la miss'skin de Dofus !</h2>

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

        {{-- Bouton call to action --}}
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
        <h2 class="text-[min(4rem,7vw)] mt-32 font-normal text-center uppercase">Découvre Barbe Douce</h2>
        <h3 class="text-2xl font-thin text-center -mt-2 mb-8 uppercase">Le Streameur à l'origine de ce site</h3>

        <div class="w-[min(90vw,50rem)] aspect-video mx-auto mt-16 relative">
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
                <x-utils.socials />
            </div>
            <img class="h-[22rem] max-[799px]:rounded-full max-[799px]:mx-auto" src="{{ asset('storage/images/misc_ui/portrait.avif') }}" height="352" width="300" alt="Portrait de Barbe Douce">
        </div>

        {{--  Présentation textuel --}}
        <div class="py-20 my-28 max-w-screen relative justify-center items-center text-primary">
            <div class="-z-10 bg-[linear-gradient(rgba(0,0,0,0.05)_50%,0,transparent_100%),linear-gradient(-135deg,var(--goldLit),var(--goldDark))] [background-size:.5em_.5em,100%_100%] top-0 absolute w-full h-full skew-y-[1.5deg]"></div>

            <div class="max-w-screen-xl px-2 mx-auto [&>p]:text-[min(1.25rem,4vw)] [&>p]:indent-12 [&>p]:font-light [&>p]:mt-2">
                <h2 class="text-[min(4rem,8vw)] font-normal text-center uppercase">Des skins en veux-tu, en voilà !</h2>
                <p>Avec une galerie de plus de <strong>{{ $skinCount }} skins</strong> postés par <strong>{{ $userCount }} joueurs</strong>, Barbofus te permet de trouver le meilleur skin Dofus pour ton personnage en jeu, ou de montrer à tout le monde tes propres créations !</p>
                <p>Découvre toute la variété du monde des douzes, peu importe le sexe, la classe, les couleurs ou le choix d'items, tous les skins sont présentés pour le plus grand plaisir des joueurs.</p>
                <p>Tu veux montrer à la commu' de Barbe que c'est toi le plus fashion ? Tous les mardis, le <strong>concours Miss'Skin</strong> choisira les 3 skins ayant reçu le plus de like dans la semaine, alors prépare ton meilleur outfit et impressionne le monde des douzes !</p>
                <p>@foreach($racesName as $race) {{ $race->name }}, @endforeach vous êtes tous bienvenu !</p>
            </div>
        </div>

        {{-- Remerciements --}}
        <h2 class="text-[min(4rem,7vw)] mt-32 font-normal text-center uppercase">Remerciements</h2>

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
