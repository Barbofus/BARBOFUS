@extends('layouts.app')

@section('app-meta-image')
    @yield('meta-image', asset('storage/images/misc_ui/Barbofus_Meta_image.jpg'))
@endsection

@section('app-content')


    <div x-data="{
            messages: [
                'Code Créateur : <span class=\'font-medium\'>BARBEDOUCE</span> — merci du soutien 🙏',
                '✂️ Customise ton perso avec le code créateur <span class=\'font-medium\'>BARBEDOUCE</span> dans la boutique DOFUS 💛',
                '🎨 Tu kiffes les skins ? Soutiens le site avec le code créateur : <span class=\'font-medium\'>BARBEDOUCE</span> 💖',
                '🎨 Soutiens BARBOFUS avec le code créateur : <span class=\'font-medium\'>BARBEDOUCE</span> sur la boutique Ankama ! ❤️',
            ],
            get randomMessage() {
                return this.messages[Math.floor(Math.random() * this.messages.length)];
            }
        }"
        class="sticky hidden min-[1301px]:relative min-[1301px]:flex z-50 goldGradient w-full h-10 top-0 left-0 text-primary font-light justify-center group items-center">
        <div class="absolute top-0 left-1/2 h-full w-full -translate-x-1/2 emeraldGradient group-hover:scale-x-100 group-hover:opacity-100 opacity-0 scale-x-0 transition-all duration-700"></div>
        <a href="https://youtu.be/42wbG24vJQ4" target="_blank" class="relative z-10 h-full w-full flex items-center justify-center">
            <p x-html="randomMessage"></p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 group-hover:scale-150 origin-bottom-left transition-all">
                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>



    <x-main-header />

    {{-- Notifications --}}
    @auth
        <livewire:notifications.notifications-list />
    @endauth

    <livewire:utils.locale-dropdown />

    <x-main-navbar />

    @yield('content')

    <x-utils.scroll-to-top />

    <x-footer />
@endsection
