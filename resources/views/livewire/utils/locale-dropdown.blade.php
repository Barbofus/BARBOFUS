<div
    class="fixed w-12 min-[901px]:absolute top-3 min-[1301px]:top-12 right-14 z-50"
    x-data="{
                open: false
            }"
    x-on:click.away="open = false">

    {{-- Langue actuel --}}
    <button class="hover:opacity-75 w-full transition-all active:scale-90" x-on:click="open = !open">
        <img draggable="false" src="{{ asset('storage/images/icons/locale/'. $locale .'.png') }}" alt="Drapeau langue" height="48" class="h-8 mx-auto">
    </button>

    {{-- Dropdown --}}
    <div class="bg-primary-100 absolute rounded-md p-2 shadow-xl" x-on:click="open = false"
         :class="open ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'" x-cloak>

        <button wire:click="setLocale('en')" class="block hover:brightness-50 active:scale-90 transition-all">
            <img draggable="false" src="{{ asset('storage/images/icons/locale/en.png') }}" title="English" alt="English flag" height="48" class="h-8">
        </button>
        <button wire:click="setLocale('fr')" class="block hover:brightness-50 active:scale-90 transition-all">
            <img draggable="false" src="{{ asset('storage/images/icons/locale/fr.png') }}" title="Français" alt="Drapeau français" height="48" class="h-8">
        </button>
        <button wire:click="setLocale('es')" class="block hover:brightness-50 active:scale-90 transition-all">
            <img draggable="false" src="{{ asset('storage/images/icons/locale/es.png') }}" title="Española" alt="Bandera española" height="48" class="h-8">
        </button>
        <button wire:click="setLocale('pt')" class="block hover:brightness-50 active:scale-90 transition-all">
            <img draggable="false" src="{{ asset('storage/images/icons/locale/pt.png') }}" title="Português" alt="Bandeira portuguesa" height="48" class="h-8">
        </button>
    </div>
</div>
