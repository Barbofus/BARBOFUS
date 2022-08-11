<div>
    <div class=" sticky top-0 z-50 bg-white mb-4 pb-2 border-b">
        <div class="mt-[32px] border-t pt-[16px] flex justify-center items-center space-x-4">
            @foreach ($races as $race)
                <button wire:click="SelectRaces({{ $race->id }})">
                    <img src="{{ asset('/storage/images/icons/classes/' .$race->icon_path) }}" alt="{{ $race->name }}" width="75" height="75" 
                    @if (array_keys($selectedRaces, $race->id))
                        class="grayscale-0 brightness-100 transition ease-in duration-[50ms] hover:brightness-110 hover:-translate-y-2 active:scale-90"
                    @else
                        class="grayscale brightness-75 transition ease-in duration-[50ms] hover:brightness-100 hover:-translate-y-2 active:scale-90"
                    @endif>
                </button>
            @endforeach

            <div class="flex justify-center mt-2">
                <button wire:click="UnselectAllRaces()" class="text-sm bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Afficher toutes les classes</button>
            </div>
        </div>

        <div class="mt-2 border-t flex justify-center items-center space-x-4">
            @foreach ($elements as $element)
                <button wire:click="SelectElements({{ $element->id }})">
                    <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="75" height="75" 
                    @if (array_keys($selectedElements, $element->id))
                    class="grayscale-0 brightness-100 transition ease-in duration-[50ms] hover:brightness-110 hover:-translate-y-2 active:scale-90"
                @else
                    class="grayscale brightness-75 transition ease-in duration-[50ms] hover:brightness-100 hover:-translate-y-2 active:scale-90"
                @endif>
                </button>
            @endforeach

            <div class="flex justify-center mt-2">
                <button wire:click="UnselectAllElements()" class="text-sm bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Afficher tous les élements</button>
            </div>
        </div>
    </div>

    @if($builds->count() < 1)
        <h1 class=" text-5xl font-bold text-center mt-[50px]">Aucun résultat pour les filtres choisis</h1>
    @else
        <div class="ml-[150px] mr-[150px] grid grid-cols-5 gap-y-8 mb-[128px] pt-[16px]">
            @foreach ($builds as $build)
                <a href="{{ $build->build_link }}" target="_blank" class="group">
                    <div class="border rounded-xl w-[400px] overflow-hidden">
                        <div class="relative">
                            <img src="{{ asset('/storage/images/banner/classes/' .$build->Race->banner_path) }}" alt="{{ $build->Race->name }}" class="brightness-[45%] contrast-[120%] group-hover:brightness-[100%] group-hover:contrast-[100%] transition duration-150">
                            <div class=" absolute text-white top-0 w-full h-full">
                                <div class=" h-[40%] w-full flex items-center justify-center">
                                    <span class=" text-3xl font-bold">{{ $build->title }}</span>
                                </div>

                                <div class=" h-[60%] w-full flex">
                                    <div class=" h-full w-[50%]">
                                        <div class="flex justify-center h-full p-4">
                                            <div class="relative w-[50%] h-full flex items-center justify-center">
                                                <img src="{{ asset('/storage/images/misc_ui/icon_pa.png') }}" alt="Icone PA" width="70">
                                                <span class="absolute text-xl font-bold">{{ $build->ap_nbr }}</span>
                                            </div>
                                            
                                            <div class="relative w-[50%] h-full flex items-center justify-center">
                                                <img src="{{ asset('/storage/images/misc_ui/icon_pm.png') }}" alt="Icone PM" width="70">
                                                <span class="absolute text-xl font-bold">{{ $build->mp_nbr }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" h-full w-[50%] backdrop-blur-sm">
                                        <div class=" w-full h-[50%] flex items-center justify-end">
                                            @foreach ($build->Element as $element)
                                                @if ($element->is_elemental == 1)
                                                    <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="50" height="50">
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class=" w-full h-[50%] border-t flex items-center justify-end">
                                            @foreach ($build->Element as $element)
                                                @if ($element->is_elemental == 0)
                                                    <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="50" height="50">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('/storage/images/' .$build->image_path) }}" alt="{{ $build->title }}" width="400" height="400" class="group-hover:grayscale group-hover:brightness-110 transition ease-in duration-150">
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
