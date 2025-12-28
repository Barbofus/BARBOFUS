<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">

        @if ($showUpdateButtons)
            <div class="flex flex-col items-center justify-center w-full mt-8 space-y-8">
                <button wire:click="InitiateItemsUpdate()" wire:loading.attr="disabled"
                    class="p-4 text-2xl font-light text-center rounded-md text-primary goldGradient disabled:grayscale hover:enabled:brightness-110">
                    Récup les nouveaux items
                </button>

                <button wire:click="InitiateSkinsUpdate()" wire:loading.attr="disabled"
                    class="p-4 text-2xl font-light text-center rounded-md text-primary goldGradient disabled:grayscale hover:enabled:brightness-110">
                    Exporter les nouveaux skins
                </button>

                <div class="hidden gap-4 pointer-events-none" wire:loading.class.remove="hidden"
                    wire:loading.class="flex">
                    <div
                        class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:0ms]">
                    </div>
                    <div
                        class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:100ms]">
                    </div>
                    <div
                        class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:200ms]">
                    </div>
                </div>
            </div>
        @endif


        @if (count($newItems) > 0)
            <div class="p-16 mx-auto mt-16 text-center border-2 rounded-xl border-goldText w-fit">
                <h2 class="mb-8 text-2xl font-thin uppercase">Derniers Ajouts</h2>
                <div class="grid grid-cols-3 gap-4 text-left">
                    @foreach ($newItems as $newItem)
                        <div>
                            <div class="flex items-center justify-start gap-x-2">
                                <img src="{{ asset('storage/images/icons/items/subcategories/' . $newItem['subcategory'] . '.png') }}"
                                    class="h-7">
                                <p class="font-light text-inactiveText text-md">
                                    {{ __('barbofus.labelSkinItem' . $newItem['subcategory']) }}</p>
                                <p class="font-light text-inactiveText text-md">Lv. {{ $newItem['level'] }}</p>
                            </div>
                            <div class="flex items-center pr-4 space-x-2 rounded-md bg-primary-100">
                                <img class="w-14" draggable="false"
                                    src="{{ asset('storage/' . $newItem['icon_path']) }}">
                                <p class="font-light italic text-secondary text-md min-[750px]:text-lg">
                                    {{ $newItem['name'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
