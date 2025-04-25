<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">

        @if($showUpdateButtons)
            <div class="flex flex-col items-center space-y-8 justify-center w-full mt-8">
                <button  wire:click="InitiateItemsUpdate()" wire:loading.attr="disabled"
                         class="p-4 text-2xl text-primary text-center font-light goldGradient rounded-md disabled:grayscale hover:enabled:brightness-110">
                    Récup les nouveaux items
                </button>

                <button  wire:click="InitiateSkinsUpdate()" wire:loading.attr="disabled"
                         class="p-4 text-2xl text-primary text-center font-light goldGradient rounded-md disabled:grayscale hover:enabled:brightness-110">
                    Exporter les nouveaux skins
                </button>

                <div class="gap-4 pointer-events-none hidden" wire:loading.class.remove="hidden" wire:loading.class="flex">
                    <div class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:0ms]"></div>
                    <div class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:100ms]"></div>
                    <div class="w-5 h-5 bg-secondary rounded-full transition-all duration-100 opacity-100 visible animate-bounce [animation-delay:200ms]"></div>
                </div>
            </div>
        @endif

        <h2 class="text-2xl font-thin text-center mt-16 mb-8 uppercase">Gestion du miss'skin</h2>

        <div class="w-full flex justify-center">
            @if(session('miss-skin'))
                <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600">{{ session('miss-skin') }}</p>
            @endif
        </div>

        <div class="flex justify-center w-full mt-8">
            <a  href="{{ route('miss-skin') }}"
                class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110">Lancer le concours</a>
        </div>


        @if(count($newItems) > 0)
            <div class="rounded-xl mt-16 mx-auto border-2 border-goldText p-16 text-center w-fit">
                <h2 class="text-2xl font-thin mb-8 uppercase">Derniers Ajouts</h2>
                <div class="grid grid-cols-3 gap-4 text-left">
                    @foreach($newItems as $newItem)
                        <div>
                            <div class="flex gap-x-2 items-center justify-start">
                                <img src="{{ asset('storage/images/icons/items/subcategories/'.$newItem['subcategory'].'.png') }}" class="h-7">
                                <p class="text-inactiveText text-md font-light">{{ __('barbofus.labelSkinItem'.$newItem['subcategory']) }}</p>
                                <p class="text-inactiveText text-md font-light">Lv. {{ $newItem['level'] }}</p>
                            </div>
                            <div class="flex space-x-2 items-center bg-primary-100 rounded-md pr-4">
                                <img class="w-14" draggable="false" src="{{ asset('storage/' . $newItem['icon_path'] )}}">
                                <p class="font-light italic text-secondary text-md min-[750px]:text-lg">{{ $newItem['name'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
