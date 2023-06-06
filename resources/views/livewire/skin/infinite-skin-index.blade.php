<div class="w-full grid grid-flow-dense grid-rows-[theme(spacing.12),85px,1fr]
          [@media(max-height:500px)_and_(max-width:900px)]:grid-rows-[0px,0px,1fr]
          min-[501px]:grid-rows-[theme(spacing.36),85px,1fr]
          min-[801px]:grid-rows-[theme(spacing.20),85px,1fr]
          min-[1501px]:grid-cols-[430px,1fr] min-[1501px]:grid-rows-[theme(spacing.20),1fr]">

    <!-- Header skin section -->
    <div class="bg-primary sticky z-30 flex flex-col gap-y-4 items-center justify-between w-full h-full pl-4 pr-12 py-8 top-12
            [@media(max-height:500px)_and_(max-width:900px)]:invisible
            [@media(max-height:700px)_and_(max-width:900px)]:top-0
            min-[801px]:flex-row min-[801px]:py-4 min-[801px]:gap-y-0
            min-[1500px]:col-start-2 min-[1500px]:px-[calc(calc(100%-calc(calc(clamp(140px,calc(100%/6)-theme(spacing.8),200px)*6)+calc(theme(spacing.8)*5)))/2)]
            min-[1800px]:pl-[calc(calc(calc(100%-400px)-calc(calc(clamp(140px,calc(calc(100%-400px)/6)-theme(spacing.8),200px)*6)+calc(theme(spacing.8)*5)))/2)] min-[1800px]:pr-[calc(calc(calc(calc(100%-400px)-calc(calc(clamp(140px,calc(calc(100%-400px)/6)-theme(spacing.8),200px)*6)+calc(theme(spacing.8)*5)))/2)+400px)]">


        <!-- Tuto poste -->
        <div class="invisible flex items-center justify-around cursor-pointer gap-x-2
            [@media(min-height:501px)_and_(min-width:501px)]:visible
            min-[901px]:visible">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 fill-secondary">
                <path d="M11.812,0C5.289,0,0,5.289,0,11.812s5.289,11.813,11.812,11.813s11.813-5.29,11.813-11.813
                S18.335,0,11.812,0z M14.271,18.307c-0.608,0.24-1.092,0.422-1.455,0.548c-0.362,0.126-0.783,0.189-1.262,0.189
                c-0.736,0-1.309-0.18-1.717-0.539s-0.611-0.814-0.611-1.367c0-0.215,0.015-0.435,0.045-0.659c0.031-0.224,0.08-0.476,0.147-0.759
                l0.761-2.688c0.067-0.258,0.125-0.503,0.171-0.731c0.046-0.23,0.068-0.441,0.068-0.633c0-0.342-0.071-0.582-0.212-0.717
                c-0.143-0.135-0.412-0.201-0.813-0.201c-0.196,0-0.398,0.029-0.605,0.09c-0.205,0.063-0.383,0.12-0.529,0.176l0.201-0.828
                c0.498-0.203,0.975-0.377,1.43-0.521c0.455-0.146,0.885-0.218,1.29-0.218c0.731,0,1.295,0.178,1.692,0.53
                c0.395,0.353,0.594,0.812,0.594,1.376c0,0.117-0.014,0.323-0.041,0.617c-0.027,0.295-0.078,0.564-0.152,0.811l-0.757,2.68
                c-0.062,0.215-0.117,0.461-0.167,0.736c-0.049,0.275-0.073,0.485-0.073,0.626c0,0.356,0.079,0.599,0.239,0.728
                c0.158,0.129,0.435,0.194,0.827,0.194c0.185,0,0.392-0.033,0.626-0.097c0.232-0.064,0.4-0.121,0.506-0.17L14.271,18.307z
                M14.137,7.429c-0.353,0.328-0.778,0.492-1.275,0.492c-0.496,0-0.924-0.164-1.28-0.492c-0.354-0.328-0.533-0.727-0.533-1.193
                c0-0.465,0.18-0.865,0.533-1.196c0.356-0.332,0.784-0.497,1.28-0.497c0.497,0,0.923,0.165,1.275,0.497
                c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z"/>
            </svg>
            <p class="font-display text-secondary text-[1rem]">Comment créer et poster un skin sur le site ?</p>
        </div>

        {{-- Menu de trie --}}
        <x-skins.sorter />
    </div>


    <x-skins.main-filter :races="$races" />

    {{-- La grille des skins --}}
    <div class="flex flex-col bg-primary pt-0
            [@media(min-height:501px)_and_(max-width:900px)]:pt-0
            [@media(min-height:701px)_and_(max-width:900px)]:pt-16
            min-[1800px]:flex-row ">

        {{-- Derniers vainqueurs et date du prochain tirage Barbe' Hebdo --}}
        <livewire:skin.last-winners :wire:key="'winners-{{ rand() }}'"/>

        <div class="flex-1 flex flex-col items-center min-[1800px]:max-w-[calc(100%-400px)]">
            @if(count($postIdChunks) > 0)
                @for($i = 0; $i < $page && $i < $maxPage; $i++)
                    <livewire:skin.skin-index-chunk :skinIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$queryCount.'-'.$i"/>
                @endfor
            @else
                <img class="mt-8 h-[256px]" src="{{ asset('storage/images/misc_ui/Barbe_pleure.png') }}">
                <p class="text-3xl font-thin"><span class="font-normal italic text-4xl">Aïe ! </span>Aucun résultat pour ces filtres</p>
            @endif
        </div>
    </div>

    {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
    @if($this->HasMorePage())
        <x-utils.load-more/>
    @endif

    {{-- Scroll horizontalement les pseudos trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/ResizeIndexComponent.js', 'resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js'])
</div>
