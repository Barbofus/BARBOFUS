<div class="grid grid-cols-[repeat(auto-fill,225px)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,1500px)] justify-center">
    @foreach($skins as $key => $skin)
        <div wire:key="skin.{{ $skin->id }}" class="relative opacity-0 animate-skinApparition h-full shadow-sm" style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms">
            <x-skins-presentation.myskins-card :skin="$skin" />
            <p class="absolute mt-2 text-lg text-inactiveText italic">Posté {{ $skin->created_at->diffForHumans() }}</p>
        </div>
    @endforeach
</div>
