<div>
    <div class="sticky top-0 z-50 pb-2 mb-4 bg-white border-b ">
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
                <button wire:click="UnselectAllRaces()" class="px-4 py-2 text-sm font-bold text-white bg-red-500 border-b-4 border-red-700 rounded hover:bg-red-400 hover:border-red-500">Afficher toutes les classes</button>
            </div>
        </div>

        {{-- Affichage des elements --}}
        <div class="flex items-center justify-center">
            <div class="flex items-center justify-center mt-2 space-x-4 border-t">
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
                <button wire:click="UnselectAllElements()" class="px-4 py-2 text-sm font-bold text-white bg-red-500 border-b-4 border-red-700 rounded hover:bg-red-400 hover:border-red-500">Afficher tous les élements</button>
            </div>

            {{-- Boutou pour activer la recherche stricte --}}
            <div class="flex justify-center mt-2 ml-8">
                <input wire:click="ToggleStrictFilter()" type="checkbox" class="mr-2 scale-150 accent-green-600">
                    <span class="text-lg text-gray-700 ">Montrer les variantes DO CRI / DO POU</span>
            </div>

            {{-- Boutou pour choisir les PVP et/ou PVM --}}
            <div
                class="flex justify-center mt-2 ml-8 space-x-4"
                x-data="{
                    is_PvpSelected: false,
                    is_PvmSelected: false,
                    activeCSS: 'text-lg font-bold h-[35px] w-[75px] bg-yellow-500 rounded-xl hover:border-none hover:bg-yellow-300 active:bg-yellow-200  active:border-none',
                    inactiveCSS: 'text-lg h-[35px] w-[75px] bg-white border-2 border-yellow-500 rounded-xl hover:bg-yellow-100 active:bg-yellow-200 active:border-none',
                }">
                <button x-on:click="is_PvpSelected = !is_PvpSelected, $wire.TogglePvp()" :class="is_PvpSelected ? activeCSS : inactiveCSS">PVP</button>
                <button x-on:click="is_PvmSelected = !is_PvmSelected, $wire.TogglePvm()" :class="is_PvmSelected ? activeCSS : inactiveCSS">PVM</button>
            </div>
        </div>
    </div>

    {{-- Affichage du nombre de builds visiblent avec les filtres actifs --}}
    <p class="text-lg text-center text-gray-500">Vos filtres affichent <span class="font-bold">{{ count($builds) }}</span> builds</p>

    {{-- Si les filtres montrent des builds, les affichent, sinon indique qu'il n'y en a pas --}}
    @if(count($builds) < 1)
        <h1 class=" text-5xl font-bold text-center mt-[50px]">Aucun résultat pour les filtres choisis</h1>
    @else
        <div class="ml-[150px] mr-[150px] grid grid-cols-1 2xl:grid-cols-5 gap-y-8 mb-[128px] pt-[16px]">
            @foreach ($builds as $build)
                <div class=" w-[400px]">

                    {{-- Liens qui mène à la page (sûrement DofusRoom) du build --}}
                    <a href="{{ $build['build']['build_link'] }}" target="_blank" class="group">

                        {{-- Vue qui contient tous le module de présentation des builds --}}
                        @include('builds.buildPresentation')
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
