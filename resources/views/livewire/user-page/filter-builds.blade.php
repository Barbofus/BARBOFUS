<div x-data="{ deleteVerify: false  }">
    <div class="top-0 mb-4 pb-2 border-b">
        <div class="mt-[32px] border-t pt-[16px]">

            {{-- Affichage des classes --}}
            <div>
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
            </div>
            
            <div class="flex justify-center mt-2">
                <button wire:click="UnselectAllRaces()" class="text-sm bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Afficher toutes les classes</button>
            </div>
        </div>

        {{-- Affichage des elements --}}
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

    {{-- Affichage des builds --}}
    @if($builds->count() < 1)
        <h1 class=" text-5xl font-bold text-center mt-[50px]">Aucun résultat pour les filtres choisis</h1>
    @else
        <div class="ml-[150px] mr-[150px] grid grid-cols-1 2xl:grid-cols-3 gap-y-8 mb-[128px] pt-[16px]">
            @foreach ($builds as $build)
                <div class=" w-[400px] relative rounded-xl overflow-hidden">

                    @include('builds.buildPresentation')
                        
                    <div class="absolute top-0 left-0 h-full w-full opacity-0 hover:opacity-100">

                        <div class="absolute top-0 left-0 h-full w-full bg-black bg-opacity-75 flex justify-center items-center">
                            <div>
                                <button class="block mb-[50px] h-[50px] w-[150px] bg-blue-600 text-2xl text-blue-100 border-r-[16px] border-blue-700 hover:bg-blue-700 hover:border-blue-800 hover:font-bold">Modifier</button>
                                
                                <button x-on:click="deleteVerify = '{{ $build->title }}'" class="block h-[50px] w-[150px] bg-red-600 text-2xl text-red-100 border-r-[16px] border-red-700 hover:bg-red-700 hover:border-red-800 hover:font-bold">Supprimer</button>
                            </div>  
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

    
    @include('layouts.deleteVerify')
</div>

