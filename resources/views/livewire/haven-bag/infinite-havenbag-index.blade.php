{{-- Global container --}}
<div class="flex">

    {{-- Aside section--}}
    <div class="w-96 h-[calc(100vh-15vh-4rem)] sticky top-16 overflow-y-scroll p-2 no-scrollbar border-r-2 border-secondary hidden min-[600px]:block">
        <div class="flex justify-center items-center">
            <div class="relative w-10 h-10">
                <svg class="absolute top-0 left-0 w-10 fill-secondary"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M17 2.75a.75.75 0 00-1.5 0v5.5a.75.75 0 001.5 0v-5.5zM17 15.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM3.75 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zM4.5 2.75a.75.75 0 00-1.5 0v5.5a.75.75 0 001.5 0v-5.5zM10 11a.75.75 0 01.75.75v5.5a.75.75 0 01-1.5 0v-5.5A.75.75 0 0110 11zM10.75 2.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10 6a2 2 0 100 4 2 2 0 000-4zM3.75 10a2 2 0 100 4 2 2 0 000-4zM16.25 10a2 2 0 100 4 2 2 0 000-4z" />
                </svg>

            </div>
            <p class="ml-2 text-[1.35rem] text-secondary font-medium tracking-wide">Affine ta recherche</p>
        </div>

        @if(count($selectedThemes) > 0)
            <div class="mt-8">
                <p class="text-ivory font-thin text-[1.25rem]">Actifs :</p>

                <div class="grid grid-cols-2 gap-x-2 gap-y-4 mt-4">
                    @foreach($selectedThemes as $sTheme)
                        <button class="relative group overflow-hidden h-fit rounded-lg bg-primary-100" wire:click="ToggleTheme({{ $sTheme->id }})" @click="window.scrollTo({top: 0, behavior: 'smooth'})">
                            <p class="text-left font-thin text-[0.9rem] px-2 py-0.5"><span class="hidden min-[900px]:inline-block">Thème</span> {{ ' ' . $sTheme->name }}</p>
                            <div class="relative aspect-video overflow-hidden">
                                <img src="{{ asset('storage/'. $sTheme->image_path) }}" draggable="false"
                                     alt="Image du havre sac"
                                     class="absolute top-[-25%] h-[150%] w-full object-cover group-hover:top-[-30%] group-hover:h-[160%] transition-all">
                            </div>
                            <div class="absolute h-full w-full top-0 left-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all text-red-500">
                                <div class="mx-auto h-full w-fit relative top-0 group-hover:top-1/4 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[75%] rotate-180 bottom-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-8">
            <p class="text-ivory font-thin text-[1.25rem]">Inactifs :</p>

            <div class="grid grid-cols-2 gap-x-2 gap-y-4 mt-4">
                @foreach($unselectedThemes as $uTheme)
                    <button class="relative group overflow-hidden h-fit rounded-lg bg-primary-100" wire:click="ToggleTheme({{ $uTheme->id }})" @click="window.scrollTo({top: 0, behavior: 'smooth'})">
                        <p class="text-left font-thin text-[0.9rem] px-2 py-0.5"><span class="hidden min-[900px]:inline-block">Thème</span>{{ ' ' . $uTheme->name }}</p>
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ asset('storage/'. $uTheme->image_path) }}" draggable="false"
                                 alt="Image du havre sac"
                                 class="absolute top-[-25%] h-[150%] w-full object-cover group-hover:top-[-30%] group-hover:h-[160%] transition-all">
                        </div>
                        <div class="absolute h-full w-full top-0 left-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all text-blue-500">
                            <div class="mx-auto h-full w-fit relative top-1/4 group-hover:top-0 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[75%] bottom-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                </svg>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main section --}}
    <div class="flex flex-col items-center w-full mb-10" wire:key="{{ 'main'.rand() }}"
        x-data="{
            showHavenBag: {{ isset($initHavenBag[0]) ? 'true' : 'false' }},
            havenBagImagePath: '{{ isset($initHavenBag[0]) ? asset('storage/'). '/'. $initHavenBag[0]->image_path : '' }}',
            popocketIconPath: '{{ isset($initHavenBag[0]) ? asset('storage/'). '/'. $initHavenBag[0]->popocket_icon_path : '' }}',
            username: '{{ isset($initHavenBag[0]) ? $initHavenBag[0]->user_name : '' }}',
            havenBagName: '{{ isset($initHavenBag[0]) ? $initHavenBag[0]->name : '' }}',
            havenBagThemeName: '{{ isset($initHavenBag[0]) ? $initHavenBag[0]->haven_bag_theme_name : '' }}',

            AddToUrl(name, value) {
                // Récupère les paramètres
                const params = new URLSearchParams(window.location.search);

                // On supprime l'ancien pour le remplacer par le nouveau
                params.delete(name);
                params.set(name, value);

                // On prend l'url de la page vierge, sans paramètre
                const url = new URL(window.location.href);
                url.search = '';

                // Puis, on affiche le nouvel URL avec tous les paramètres
                const newUrl = url + '?' + params.toString();
                window.history.pushState({ path: newUrl }, '', newUrl);
            },

            EmptyUrl() {
                const url = new URL(window.location.href);
                url.search = '';
                const params = new URLSearchParams(window.location.search);
                params.delete('show');

                const newUrl = url + '?' + params.toString();
                window.history.pushState({ path: newUrl }, '', newUrl);
            }
        }">
        @if(count($postIdChunks) > 0)
            @for($i = 0; $i < $page && $i < $maxPage; $i++)
                <div class="w-full">
                    <livewire:haven-bag.havenbag-index-chunk :havenBagIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$i.rand()"/>
                </div>
            @endfor
        @else
            <img class="mt-8 h-[16rem]" height="256" alt="Barbe en pleure" src="{{ asset('storage/images/misc_ui/Barbe_pleure.webp') }}">
            <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Aucun résultat pour ces filtres</span></p>
        @endif

        <template x-if="true">
            <button class="z-50 bg-black/50 h-screen w-screen fixed top-0 left-0 flex justify-center items-center"
                    x-show="showHavenBag"
                    @click="
                        showHavenBag = false,
                        EmptyUrl()"
                    x-transition>
                <div class="group relative shadow-sm bg-primary-100 rounded-xl overflow-hidden transition-all">
                    <div class="flex justify-left items-center relative p-2 h-[clamp(3rem,8vw,6rem)]">
                        <img :src="popocketIconPath" draggable="false" class="h-full aspect-square invisible min-[400px]:visible" alt="Popoche du havre sac">

                        <div class="text-[calc(clamp(3rem,8vw,6rem)/100*20)] text-center w-full h-full">
                            <div class="absolute top-0 h-full px-1 pb-[2px] left-0 w-full flex flex-col justify-between
                            min-[400px]:left-[calc(0.5rem+clamp(3rem,8vw,6rem))] min-[400px]:w-[calc(100%-clamp(6rem,16vw,12rem))]">
                                <div class="w-full h-full">
                                    <div x-show="havenBagName" class="flex w-full h-fit items-end overflow-hidden text-[calc(clamp(3rem,8vw,6rem)/100*27)] whitespace-nowrap">
                                        <p class="slidableTextCenter" x-text="havenBagName">&nbsp</p>
                                    </div>

                                    <div class="flex w-full h-fit items-end overflow-hidden font-thin whitespace-nowrap">
                                        <p class="slidableTextCenter">par <span class="font-normal text-[calc(clamp(3rem,8vw,6rem)/100*22)]" x-text="username" />&nbsp</p>
                                    </div>
                                </div>

                                <div class="font-thin text-left flex w-full h-fit pt-1 items-end overflow-hidden whitespace-nowrap">
                                    <p class="slidableText">Thème : <span class="italic font-light" x-text="'Havre-sac ' + havenBagThemeName" />&nbsp</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <img :src="havenBagImagePath" alt="Image du havre sac" class="max-w-[90vw]">
                </div>
            </button>
        </template>

        {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
        @if($this->HasMorePage())
            <x-utils.load-more/>
        @endif
</div>

    {{-- Scroll horizontalement les noms trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js'])
</div>
