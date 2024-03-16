{{-- La grille des skins --}}
<div class="flex flex-col items-center min-[1501px]:col-start-2 min-[1501px]:row-start-3 min-[1801px]:row-start-2 w-full mb-10 bg-primary"
    x-data="{
        showHavenBag: {{ request()->has('show') ? 'true' : 'false' }},
        havenBagImagePath: '{{ request()->has('show') ? asset('storage/'). '/'. $initHavenBag[0]->image_path : '' }}',
        popocketIconPath: '{{ request()->has('show') ? asset('storage/'). '/'. $initHavenBag[0]->popocket_icon_path : '' }}',
        username: '{{ request()->has('show') ? $initHavenBag[0]->user_name : '' }}',
        havenBagName: '{{ request()->has('show') ? $initHavenBag[0]->name : '' }}',
        havenBagThemeName: '{{ request()->has('show') ? $initHavenBag[0]->haven_bag_theme_name : '' }}',

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
                <livewire:haven-bag.havenbag-index-chunk :havenBagIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$i"/>
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
                    <img :src="popocketIconPath" class="h-full aspect-square invisible min-[400px]:visible" alt="Popoche du havre sac">

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

    {{-- Scroll horizontalement les noms trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js'])
</div>
