<div>
    <div class=" sticky top-0 z-50 bg-white mb-4 pb-2 border-b">
        <div class="mt-[32px] border-t pt-[16px] flex justify-center items-center space-x-4 ">

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
            
            {{-- Reset des classes --}}
            <div class="flex justify-center mt-2">
                <button wire:click="UnselectAllRaces()" class="text-sm bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Afficher toutes les classes</button>
            </div>
        </div>

        {{-- Affichage des elements --}}
        <div class="flex justify-center items-center">
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
            </div>  

            {{-- Reset des élements --}}
            <div class="flex justify-center mt-2 ml-8">
                <button wire:click="UnselectAllElements()" class="text-sm bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Afficher tous les élements</button>
            </div>

            {{-- Boutou pour activer la recherche stricte --}}
            <div class="flex justify-center mt-2 ml-8">
                <input wire:click="ToggleElementsOnly()" checked type="checkbox" class="mr-2 scale-150 accent-green-600">
                    <span class=" text-lg text-gray-700">Elements selectionnés UNIQUEMENT</span>
            </div>
        </div>
    </div>

    {{-- Affichage du nombre de builds visiblent avec les filtres actifs --}}
    <p class="text-lg text-gray-500 text-center">Vos filtres affichent <span class="font-bold">{{ $builds->count() }}</span> builds</p>

    {{-- Si les filtres montrent des builds, les affichent, sinon indique qu'il n'y en a pas --}}
    @if($builds->count() < 1)
        <h1 class=" text-5xl font-bold text-center mt-[50px]">Aucun résultat pour les filtres choisis</h1>
    @else
        <div class="ml-[150px] mr-[150px] grid grid-cols-1 2xl:grid-cols-5 gap-y-8 mb-[128px] pt-[16px]">
            @foreach ($builds as $build)
                <div class=" w-[400px]">
                    
                    {{-- Liens qui mène à la page (sûrement DofusRoom) du build --}}
                    <a href="{{ $build->build_link }}" target="_blank" class="group">
                        
                        {{-- Vue qui contient tous le module de présentation des builds --}}
                        @include('builds.buildPresentation')
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
