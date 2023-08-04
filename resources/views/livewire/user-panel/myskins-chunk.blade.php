<div class="grid grid-cols-[repeat(auto-fill,14rem)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,93rem)] justify-center">
    @foreach($skins as $key => $skin)
        <div wire:key="skin.{{ $skin->id }}" class="relative opacity-0 animate-skinApparition h-full shadow-sm" style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms">
            <x-skins-presentation.myskins-card :skin="$skin" />
            @if($skin->status == 'Pending')
                <p class="absolute mt-2 text-lg text-yellow-200 italic">En attente ...</p>
            @elseif($skin->status == 'Refused')
                <p class="absolute mt-2 text-lg text-red-400 italic">Skin Refusé</p>
            @else
                <p class="absolute mt-2 text-lg text-inactiveText italic">Posté {{ $skin->updated_at->diffForHumans() }}</p>
            @endif
        </div>
    @endforeach
</div>
