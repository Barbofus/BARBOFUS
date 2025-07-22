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
    }" class="sticky hidden min-[1301px]:flex z-50 goldGradient w-full h-10 top-0 left-0 text-primary font-light justify-center items-center">
        <p x-html="randomMessage"></p>
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
