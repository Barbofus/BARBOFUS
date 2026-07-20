@extends('layouts.basic-views')

@section('content')
    <div class="pb-16">
        <h1 class="text-[min(4rem,8vw)] mt-16 font-normal text-center uppercase">{{ __('barbofus.titleHome') }}</h1>
        <h2 class="mt-2 mb-8 text-2xl font-thin text-center uppercase">{{ __('barbofus.descriptionHome') }}</h2>

        {{-- Présentation des skins --}}
        <div class="h-[max(20vh,13.75rem)] mx-auto w-[min(90vw,62.5rem)] mt-16 px-1 rounded-md goldGradient">
            <div class="w-full h-full bg-primary overflow-x-clip">
                <div class="flex h-full pl-4 translate-x-0 slider hover:animate-none gap-x-4 w-fit">
                    @foreach ($skins as $skin)
                        <x-skins-presentation.home-skin-card :skin="$skin" />
                    @endforeach
                    @foreach ($skins as $skin)
                        <x-skins-presentation.home-skin-card :skin="$skin" />
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bouton call to action --}}
        <div class="h-[20rem] min-[800px]:h-48 mt-28 max-w-screen relative flex justify-center items-center">
            <div
                class="-z-10 bg-[linear-gradient(rgba(0,0,0,0.05)_50%,0,transparent_100%),linear-gradient(-135deg,var(--goldLit),var(--goldDark))] [background-size:.5em_.5em,100%_100%] absolute w-full h-full skew-y-[1.5deg]">
            </div>

            <div class="flex min-[800px]:flex-row gap-y-4 flex-col w-fit h-fit">
                <div class="flex justify-center w-96">
                    <a href="{{ route('unity-skins.index') }}" title="Galerie de skins dofus"
                        class="top-0 px-8 py-3 mx-auto text-xl font-normal uppercase transition-all border-4 rounded-lg h-fit text-goldText border-primary bg-primary hover:bg-primary-100 hover:border-primary-100 hover:tracking-widest">
                        {{ __('barbofus.buttonSkinExplore') }}</a>
                </div>
                <div class="flex justify-center w-96">
                    <a href="{{ route('skinator.create') }}" title="Créer ton skin dofus"
                        class="px-8 py-3 mx-auto text-xl font-medium uppercase transition-all border-4 rounded-lg h-fit text-primary border-primary hover:border-primary-100 hover:tracking-widest">Skinator</a>
                </div>
            </div>
        </div>

        {{-- Présentation Barbe --}}
        <h2 class="text-[min(4rem,7vw)] mt-32 font-normal text-center uppercase">{{ __('barbofus.titleBarbe') }}</h2>
        <h3 class="mb-8 -mt-2 text-2xl font-thin text-center uppercase">{{ __('barbofus.descriptionBarbe') }}</h3>

        <div class="w-[min(90vw,50rem)] aspect-video mx-auto mt-16 relative">
            <x-utils.twitch-embed />
        </div>

        <div class="w-[min(90vw,62.5rem)] mx-auto mt-16 flex min-[800px]:flex-row flex-col justify-between gap-8">
            <div>
                <div
                    class="text-secondary text-xl font-thin flex flex-col gap-y-4 [&>p>a]:inline-block [&>p>a]:h-12 [&>p>a]:text-goldText [&>p>a:hover]:text-goldTextLit [&>p>a]:transition-all [&>p>a:hover]:-skew-x-12">
                    <p class="mb-4 font-normal uppercase">{{ __('barbofus.titleBarbeDetails') }}</p>

                    <p>• Mathieu - Barbe Douce</p>
                    <p>• {{ __('barbofus.descriptionBarbeDetails1') }} <a href="https://www.twitch.tv/barbe___douce"
                            title="Page Twitch de Barbe Douce" target="_blank">Twitch</a>, <a
                            href="https://www.ankama.com/fr" title="Site web d'Ankama" target="_blank">Ankama</a> & <a
                            href="https://www.topachat.com/accueil/index.php?mtm_campaign=mkstrm"
                            title="Partenaire TopAchat" target="_blank">TopAchat</a></p>
                    <p>• {{ __('barbofus.descriptionBarbeDetails2') }} <a href="https://twitch.tv/barbe___douce"
                            title="Page Twitch de Barbe Douce" target="_blank">twitch.tv/barbe___douce</a></p>
                    <p>• {{ __('barbofus.descriptionBarbeDetails3') }} <a
                            href="mailto:mathieu.lehr@gmail.com?subject=Contact a partir du site {{ config('app.name') }}"
                            title="Envoyer un mail">mathieu.lehr@gmail.com</a></p>
                </div>

                <!-- Réseaux sociaux -->
                <x-utils.socials />
            </div>
            <img class="h-[22rem] max-[799px]:rounded-full max-[799px]:mx-auto"
                src="{{ asset('storage/images/misc_ui/portrait.avif') }}" height="352" width="300"
                alt="Portrait de Barbe Douce">
        </div>

        {{--  Présentation textuel --}}
        <div class="relative items-center justify-center py-20 my-28 max-w-screen text-primary">
            <div
                class="-z-10 bg-[linear-gradient(rgba(0,0,0,0.05)_50%,0,transparent_100%),linear-gradient(-135deg,var(--goldLit),var(--goldDark))] [background-size:.5em_.5em,100%_100%] top-0 absolute w-full h-full skew-y-[1.5deg]">
            </div>

            <div
                class="max-w-screen-xl px-2 mx-auto [&>p]:text-[min(1.25rem,4vw)] [&>p]:indent-12 [&>p]:font-light [&>p]:mt-2">
                <h2 class="text-[min(4rem,8vw)] font-normal text-center uppercase">{{ __('barbofus.titleUnity') }}</h2>
                <p>{!! __('barbofus.descriptionUnity1', ['skinCount' => $skinCount, 'userCount' => $userCount]) !!}</p>
                <p>{{ __('barbofus.descriptionUnity2') }}</p>
                <p>{{ __('barbofus.descriptionUnity3') }}</p>
                <p>{{ __('barbofus.descriptionUnity4') }}</p>
                <p>{{ __('barbofus.descriptionUnity5') }}</p>
            </div>
        </div>

        {{-- Remerciements --}}
        <h2 class="text-[min(4rem,7vw)] mt-32 font-normal text-center uppercase">{{ __('barbofus.titleThanks') }}</h2>

        <div class="flex min-[800px]:flex-row flex-col gap-x-16 gap-y-8 justify-center items-center">
            <a href="https://dofusdb.fr/fr/" title="DofusDB" target="_blank"
                class="flex items-center p-2 transition-all gap-x-4 hover:bg-primary-100 hover:rounded-md bg-primary">
                <img src="{{ asset('storage/images/misc_ui/logo-dofus-db.ico') }}" height="48" width="48"
                    alt="Logo DofusDB">
                <div class="flex flex-col items-start justify-center">
                    <p class="text-xl font-light uppercase text-secondary">DofusDB</p>
                    <p class="italic font-thin text-secondary">API des Items</p>
                </div>
            </a>

            <a href="https://www.dofusroom.com/" title="DofusRoom" target="_blank"
                class="flex items-center p-2 transition-all gap-x-4 hover:bg-primary-100 hover:rounded-md bg-primary">
                <img src="{{ asset('storage/images/misc_ui/dofusroom.png') }}" height="48" width="48"
                    alt="Logo DofusRoom">
                <div class="flex flex-col items-start justify-center">
                    <p class="text-xl font-light uppercase text-secondary">DofusRoom</p>
                    <p class="italic font-thin text-secondary">Builder & outils</p>
                </div>
            </a>

            <a href="https://dofusbook.net/fr/" title="DofusBook" target="_blank"
                class="flex items-center p-2 transition-all gap-x-4 hover:bg-primary-100 hover:rounded-md bg-primary">
                <img src="{{ asset('storage/images/misc_ui/dofusbook.ico') }}" height="48" width="48"
                    alt="Logo DofusBook">
                <div class="flex flex-col items-start justify-center">
                    <p class="text-xl font-light uppercase text-secondary">DofusBook</p>
                    <p class="italic font-thin text-secondary">Le père Skinator</p>
                </div>
            </a>
        </div>

        <h3 class="mt-8 mb-2 text-3xl font-normal text-center uppercase">{{ __('barbofus.titleTranslation') }}</h3>

        <div class="flex min-[800px]:flex-row flex-col gap-x-16 gap-y-8 justify-center items-center">
            <div class="flex items-center p-2 transition-all gap-x-4 hover:bg-primary-100 hover:rounded-md bg-primary">
                <img src="{{ asset('https://static.barbofus.com/images/icons/locale/es.png') }}" height="48" width="48"
                    alt="Logo DofusDB">
                <div class="flex flex-col items-start justify-center">
                    <p class="text-xl font-light uppercase text-secondary">Max Medina</p>
                    <p class="italic font-thin text-secondary">Traductions es</p>
                </div>
            </div>

            <div class="flex items-center p-2 transition-all gap-x-4 hover:bg-primary-100 hover:rounded-md bg-primary">
                <img src="{{ asset('https://static.barbofus.com/images/icons/locale/pt.png') }}" height="48" width="48"
                    alt="Logo DofusBook">
                <div class="flex flex-col items-start justify-center">
                    <p class="text-xl font-light uppercase text-secondary">Amalik</p>
                    <p class="italic font-thin text-secondary">Traduction pt/br</p>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js', 'resources/js/skins/InfiniteDragSlide.js'])
@endsection
