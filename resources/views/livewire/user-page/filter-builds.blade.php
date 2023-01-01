<div x-data="{
    deleteVerify: false,
    deleteVerifyMessage: ''  }">

    {{-- Affichage de tous les builds enregistrés sur le site --}}
    <p class="text-lg text-center text-gray-500">Vous avez posté <span class="font-bold">{{ count($allBuilds) }}</span> builds</p>

    <div class="top-0 pb-2 mb-4 border-b">
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
            <div>
                <div class="flex justify-center mt-2 ml-8">
                    <input wire:click="ToggleSecondaryElementFilter()" type="checkbox" class="mr-2 scale-150 accent-green-600">
                        <span class="text-lg text-gray-700 ">Montrer les variantes DO CRI / DO POU</span>
                </div>
                <div class="flex justify-center mt-2 ml-8">
                    <input wire:click="TogglePrimaryElementFilter()" type="checkbox" class="mr-2 scale-150 accent-green-600">
                        <span class="text-lg text-gray-700 ">Montrer les variantes élementaires</span>
                </div>
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
        <div class="ml-[150px] mr-[150px] grid grid-cols-1 2xl:grid-cols-3 gap-y-8 mb-[128px] pt-[16px]">

            {{-- Première case, au clique lance la route pour créer des builds --}}
            <div class=" w-[400px] relative rounded-xl overflow-hidden bg-gray-200 border border-gray-300 hover:bg-gray-300 hover:border-gray-400">
                <a href="{{ route('builds.create') }}" class="flex items-center justify-center w-full h-full text-gray-300 hover:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-60 w-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>

            {{-- Parcours tous les builds puis les affichent --}}
            @foreach ($builds as $build)
                <div class=" w-[400px] relative rounded-xl overflow-hidden">

                    {{-- Vue qui contient tous le module de présentation des builds --}}
                    @include('builds.buildPresentation')


                    {{-- A l'hover, noirçit le build et donne accés aux boutons de modification / suppression --}}
                    <div class="absolute top-0 left-0 w-full h-full opacity-0 hover:opacity-100">

                        <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-75">
                            <div>
                                {{-- Ouvre la route de modification du build en question --}}
                                <a href="{{ route('builds.edit', ['build'=> $build['build']['id']]) }}" class="block mb-[50px] h-[50px] w-[150px] bg-blue-600 text-2xl text-blue-100 border-r-[16px] border-blue-700 hover:bg-blue-700 hover:border-blue-800 hover:font-bold">Modifier</a>

                                {{-- Avec AlpineJS, stock le nom du build dans une variable, ce qui activera le 'layouts.deleteVerify' --}}
                                <button x-on:click="deleteVerify = '{{ $build['build']['id'] }}', deleteVerifyMessage = '{{ $build['build']['title'] }}'" class="block h-[50px] w-[150px] bg-red-600 text-2xl text-red-100 border-r-[16px] border-red-700 hover:bg-red-700 hover:border-red-800 hover:font-bold">Supprimer</button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif


    {{-- S'affiche en appuyant sur le bouton de suppression d'un build --}}
    @include('layouts.deleteVerify')


    {{-- S'affiche lorsque qu'on a une notification de succé --}}
    @if (session()->Has('success'))
        @section('alertMessage')
            {{session('success')}}
        @endsection

        @include('layouts.success-alert')
    @endif

</div>

