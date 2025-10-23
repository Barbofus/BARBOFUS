@extends('layouts.empty-views')

@section('content')
    <div class="bg-black/10 max-w-screen min-[1301px]:min-h-[calc(100vh-2.5rem)] min-h-screen pt-[calc((100vw-26rem)/2)] min-[500px]:pt-16">
        <div class="w-[min(26rem,100vw)] bg-primary border border-white/10 min-[500px]:rounded-xl mx-auto flex flex-col items-center p-8 px-2 min-[500px]:px-8 shadow-2xl">

            {{-- Logo --}}
            <div class="relative inline-flex items-center justify-center aspect-square rounded-full goldGradient p-1 shadow-xl">
                <div class="absolute inset-0 goldGradient rounded-full blur-xl opacity-40"></div>
                <div class="relative flex items-center justify-center w-full rounded-full bg-primary p-7">
                    <img
                        src="{{ asset('storage/images/misc_ui/logo_barbe_x256.png') }}"
                        alt="Dofus ocre"
                        class="max-w-full h-24"
                    >
                </div>
            </div>

            {{-- Présentation --}}
            <h2 class="text-[2rem] tracking-wider mt-4">BARBE DOUCE</h2>
            <p class="text-[0.75rem] min-[500px]:text-sm text-inactiveText font-light">Streamer chill | Joueur de RPG | Good vibes only</p>

            {{-- Liens --}}
            <div class="mt-12 flex flex-col gap-y-4 w-full">

                <a href="https://barbofus.com/" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo barbofus" class="h-5 min-[500px]:h-8">
                        <p class="flex-1 text-[1.375rem] group-hover:tracking-wider transition-all">Barbofus</p>
                    </div>
                </a>

                <a href="https://www.tiktok.com/@barbe___douce" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                        </svg>
                        <p class="flex-1 text-[1.1rem] min-[500px]:text-[1.25rem] group-hover:tracking-wider transition-all">Tiktok - Q&R et Gameplay</p>
                    </div>
                </a>

                <a href="https://www.twitch.tv/barbe___douce" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-1 rounded-[14px] goldGradient opacity-40 blur-lg"></span>

                    <div class="relative p-3 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142z"/>
                            <path d="M11.857 3.143h-1.143V6.57h1.143zm-3.143 0H7.571V6.57h1.143z"/>
                        </svg>
                        <p class="flex-1 font-bold text-primary text-[1.25rem] group-hover:tracking-wider transition-all">Twitch LIVE!</p>
                    </div>
                </a>

                <a href="https://www.youtube.com/channel/UCJIBwLWxtdrVCwuX-F3W9bA?view_as=subscriber" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
                        </svg>
                        <p class="flex-1 text-[1.15rem] min-[500px]:text-[1.25rem] group-hover:tracking-wider transition-all">YouTube - Tuto & Build</p>
                    </div>
                </a>

                <a href="https://x.com/DouceBarbe" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                        </svg>
                        <p class="flex-1 text-[1rem] min-[500px]:text-[1.125rem] group-hover:tracking-wider transition-all">X (Twitter) - Actu' du Stream</p>
                    </div>
                </a>

                <a href="https://discord.com/invite/YKHc4RD" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M13.545 2.907a13.2 13.2 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.2 12.2 0 0 0-3.658 0 8 8 0 0 0-.412-.833.05.05 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.04.04 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032q.003.022.021.037a13.3 13.3 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019q.463-.63.818-1.329a.05.05 0 0 0-.01-.059l-.018-.011a9 9 0 0 1-1.248-.595.05.05 0 0 1-.02-.066l.015-.019q.127-.095.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.05.05 0 0 1 .053.007q.121.1.248.195a.05.05 0 0 1-.004.085 8 8 0 0 1-1.249.594.05.05 0 0 0-.03.03.05.05 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.2 13.2 0 0 0 4.001-2.02.05.05 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.03.03 0 0 0-.02-.019m-8.198 7.307c-.789 0-1.438-.724-1.438-1.612s.637-1.613 1.438-1.613c.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612m5.316 0c-.788 0-1.438-.724-1.438-1.612s.637-1.613 1.438-1.613c.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612"/>
                        </svg>
                        <p class="flex-1 text-[1.05rem] min-[500px]:text-[1.125rem] group-hover:tracking-wider transition-all">Discord - Rejoins la Taverne</p>
                    </div>
                </a>

                <div class="h-0 my-4 border-b border-inactiveText w-3/4 mx-auto"></div>

                <a href="https://store.ankama.com/fr/729-dofus" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-1 rounded-[14px] goldGradient opacity-40 blur-lg"></span>

                    <div class="relative p-3 flex items-center rounded-xl space-x-3 transition-all">
                        <img src="{{ asset('storage/images/misc_ui/logo-ankama.png') }}" alt="Logo Ankama" class="h-5 min-[500px]:w-8">
                        <p class="flex-1 font-bold text-primary text-[1.25rem] group-hover:tracking-wider transition-all"><span class="font-light text-[1rem] tracking-normal group-hover:tracking-normal">Code créateur:</span> BARBEDOUCE</p>
                    </div>
                </a>

                <a href="https://www.topachat.com/setup/BARBE__DOUCE?mtm_campaign=mkstrm" class="goldGradient relative p-[2px] rounded-[14px] group">

                    <span class="absolute inset-2 rounded-[14px] goldGradient opacity-0 blur-lg transition-opacity duration-300 group-hover:opacity-40"></span>

                    <div class="relative p-3 bg-primary-100 flex items-center rounded-xl space-x-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[500px]:h-8 text-secondary" viewBox="0 0 16 16">
                            <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                        </svg>
                        <p class="flex-1 text-[1rem] min-[500px]:text-[1.25rem] group-hover:tracking-wider transition-all">TopAchat - Partenaire</p>
                    </div>
                </a>
            </div>

            {{-- Footer --}}
            <p class="text-sm text-inactiveText font-light mt-6">barbofus.com/socials</p>
        </div>
    </div>

@endsection
