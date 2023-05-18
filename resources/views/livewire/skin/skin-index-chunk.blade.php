<div class="grid grid-cols-[repeat(auto-fill,200px)] pt-4 px-4 gap-4 max-w-[1400px] justify-center">
    @foreach($skins as $key => $skin)
        <div wire:key="skin.{{ $skin->id }}" class="relative opacity-0 animate-skinApparition h-full shadow-sm" style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms">
            <x-skins-presentation.skin-card :skin="$skin" />
        </div>
    @endforeach
</div>
