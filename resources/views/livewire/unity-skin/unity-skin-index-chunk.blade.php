<div class="grid grid-cols-[repeat(auto-fill,13.125rem)] pt-[4.5rem] px-4 gap-x-8 gap-y-16 w-[min(100%,93rem)] mx-auto justify-center">
    @foreach($skins as $key => $skin)
        <div wire:key="skin.{{ $skin->id }}" class="relative opacity-0 animate-skinApparition h-full shadow-sm" style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms">
            <x-skins-presentation.skin-card :skin="$skin" />
        </div>
    @endforeach
</div>
