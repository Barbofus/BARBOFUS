<div class="h-[200px] w-full flex justify-center">
    <div class="h-full w-1/2 border-b">
        <h1 class="w-full mt-3 font-bold text-center text-8xl text-amber-400">BARBOFUS</h1>
        <h2 class="w-full mt-3 text-2xl italic text-center text-amber-500">Retrouve et partage les meilleurs skins du Monde des Douze !</h2>
    </div>

    {{-- Notifications --}}
    @auth
        <livewire:notifications.notifications-list/>
    @endauth
</div>
