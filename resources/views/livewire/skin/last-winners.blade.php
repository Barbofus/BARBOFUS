<div wire:poll.visible.60s class="w-[300px] max-h-screen">
    <p class="my-4">Vainqueurs</p>

    <div class="flex flex-col gap-y-4 items-center relative w-full">
        @foreach($skins as $skin)
            <div wire:key="skinwinner.{{ $skin->id }}" class="w-full max-w-[250px]">
                <x-skins-presentation.skin-card :skin="$skin"/>
            </div>
        @endforeach
    </div>
</div>
