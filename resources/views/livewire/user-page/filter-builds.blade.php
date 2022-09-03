<div x-data="{ 
    deleteVerify: false, 
    deleteVerifyMessage: ''  }">    
    
    {{-- Affichage de tous les builds enregistrés sur le site --}}
    <p class="text-lg text-gray-500 text-center">Vous avez posté <span class="font-bold">{{ App\Models\Build::All()->count() }}</span> builds</p>

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
        <div class="ml-[150px] mr-[150px] grid grid-cols-1 2xl:grid-cols-3 gap-y-8 mb-[128px] pt-[16px]">
            
            {{-- Première case, au clique lance la route pour créer des builds --}}
            <div class=" w-[400px] relative rounded-xl overflow-hidden bg-gray-200 border border-gray-300 hover:bg-gray-300 hover:border-gray-400">
                <a href="{{ route('builds.create') }}" class="h-full w-full  flex justify-center items-center text-gray-300 hover:text-gray-400">
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
                    <div class="absolute top-0 left-0 h-full w-full opacity-0 hover:opacity-100">

                        <div class="absolute top-0 left-0 h-full w-full bg-black bg-opacity-75 flex justify-center items-center">
                            <div>
                                {{-- Ouvre la route de modification du build en question --}}
                                <a href="{{ route('builds.edit', ['build'=> $build->id]) }}" class="block mb-[50px] h-[50px] w-[150px] bg-blue-600 text-2xl text-blue-100 border-r-[16px] border-blue-700 hover:bg-blue-700 hover:border-blue-800 hover:font-bold">Modifier</a>
                                
                                {{-- Avec AlpineJS, stock le nom du build dans une variable, ce qui activera le 'layouts.deleteVerify' --}}
                                <button x-on:click="deleteVerify = '{{ $build->id }}', deleteVerifyMessage = '{{ $build->title }}'" class="block h-[50px] w-[150px] bg-red-600 text-2xl text-red-100 border-r-[16px] border-red-700 hover:bg-red-700 hover:border-red-800 hover:font-bold">Supprimer</button>
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

