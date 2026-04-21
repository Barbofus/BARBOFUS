<div class="grid grid-cols-[repeat(auto-fill,14rem)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,93rem)] justify-center">
    @foreach ($skins as $key => $skin)
        <div wire:key="skin.{{ $skin->id }}" class="relative h-full shadow-sm opacity-0 animate-skinApparition"
            style="animation-delay: {{ ($key - $itemsPerPage * ($page - 1)) * 35 }}ms">
            <x-skins-presentation.myunityskins-card :skin="$skin" />
            @if($skin->status == 'MissSkin')
                <p class="absolute mt-2 text-lg italic text-blue-400">{{ "Miss'Skin en cours" }}</p>
            @else
            <p class="absolute mt-2 text-lg italic text-inactiveText">{{ __('barbofus.contentPosted') }}
                {{ $skin->created_at->diffForHumans() }}</p>
            @endif
        </div>
    @endforeach
</div>
