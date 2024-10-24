<div class="w-full grid grid-flow-dense grid-rows-[theme(spacing.12),5.5rem,70rem,1fr]
          [@media(max-height:500px)_and_(max-width:900px)]:grid-rows-[0rem,0rem,70rem,1fr]
          min-[851px]:grid-rows-[theme(spacing.20),5.5rem,27rem,1fr]
          min-[1501px]:grid-cols-[27rem,1fr] min-[1501px]:grid-rows-[theme(spacing.20),27rem,1fr]
          min-[1801px]:grid-cols-[27rem,1fr,25rem] min-[1801px]:grid-rows-[theme(spacing.20),1fr]">

    <!-- Header skin section -->
    <div class="bg-primary sticky flex flex-col gap-y-4 items-center justify-center w-full h-full px-4 top-12 pt-8 z-30
            [@media(max-height:500px)_and_(max-width:900px)]:invisible
            min-[851px]:flex-row min-[851px]:gap-y-0 min-[851px]:justify-between
            min-[1501px]:col-start-2 min-[1501px]:px-8 min-[1501px]:z-20">


        <!-- Tuto poste -->
        <div class="invisible [@media(min-height:501px)_and_(min-width:851px)]:visible
                min-[851px]:visible h-full w-fit py-2 flex flex-col items-start min-[975px]:items-center justify-between">
            <a class="flex items-center justify-around cursor-pointer gap-x-2"
                href="https://www.youtube.com/watch?v=teuDOhkgIaM" title="Tutoriel pour poster un skin" target="_blank">
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
            </a>

            <a href="https://www.dofusbook.net/fr/outils/skinator/draft" target="_blank" class="w-fit mt-2 font-display text-primary text-[1rem] bg-inactiveText hover:bg-secondary transition-all rounded-md px-4">Accès au skinator Dofusbook</a>
        </div>

        {{-- Menu de trie --}}
        <x-skins.sorter :$orderByID :$orderDirection />
    </div>

    <x-skins.main-filter :races="$races" :winnersOnly="$winnersOnly" :barbOnly="$barbeOnly" :filterColor="$filterColor" :petTypeContent="$skinPetTypeWhere" :skinContent="$skinContentWhere" :gender="$genderWhere" :raceSelection="$raceWhere" :searchFilterInput="$searchFilterInput" :$raceWhere :canWinnersOnly="true" />

    {{-- La grille des skins --}}
    <div class="flex flex-col items-center min-[1501px]:col-start-2 min-[1501px]:row-start-3 min-[1801px]:row-start-2 w-full mb-10 bg-primary">
        @if(count($postIdChunks) > 0)
            @for($i = 0; $i < $page && $i < $maxPage; $i++)
                <div class="w-full">
                    <livewire:skin.skin-index-chunk :skinIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$queryCount.'-'.$i"/>
                </div>
            @endfor
        @else
            <img class="mt-8 h-[16rem]" height="256" alt="Barbe en pleure" src="{{ asset('storage/images/misc_ui/Barbe_pleure.webp') }}">
            <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Aucun résultat pour ces filtres</span></p>
        @endif

        {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
        @if($this->HasMorePage())
            <x-utils.load-more/>
        @endif
    </div>

    {{-- Derniers vainqueurs et date du prochain tirage Miss'Skin --}}
    <livewire:skin.last-winners :wire:key="'winners-{{ rand() }}'"/>



    <script>
        function AddParamToUrl(name, value)
        {
            // Récupère les paramètres
            const params = new URLSearchParams(window.location.search);

            // On supprime l'ancien pour le remplacer par le nouveau
            params.delete(name);
            params.set(name, value);

            // On prend l'url de la page vierge, sans paramètre
            const url = new URL(window.location.href);
            url.search = "";

            // Puis, on affiche le nouvel URL avec tous les paramètres
            const newUrl = url + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);
        }

        function ToggleArrayParamToUrl(name, value)
        {
            // Récupère les paramètres
            const params = new URLSearchParams(window.location.search);

            let finalArray = [];


            // Check si le paramètre du tableau est déjà dans celui-ci
            if(params.get(name))
            {
                // Transforme le paramètre en réel tableau
                finalArray = params.get(name).split(',').map(decodeURIComponent);

                let index = finalArray.indexOf(value.toString());
                // Si oui, on la retire
                if(index != -1)
                {
                    finalArray.splice(index, 1);

                    // Si le tableau est vide, on supprime le paramètre
                    if(finalArray.length == 0) {

                        RemoveParamUrl(name);
                        return;
                    }
                }
                else// Si la valeur n'y était pas, on l'ajoute
                {
                    finalArray.push(value);
                }
            }
            else // Si le paramètre n'existe pas, on l'ajoute
            {
                finalArray.push(value);
            }

            // Encodage du tableau + ajout de virgule entre chaque valeur
            const encodedValue = finalArray.map(encodeURIComponent);
            const valueString = finalArray.join(',');
            params.set(name, valueString);

            // On prend l'url de la page vierge, sans paramètre
            const url = new URL(window.location.href);
            url.search = "";

            // Puis, on affiche le nouvel URL avec tous les paramètres
            const newUrl = url + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);
        }

        function RemoveParamUrl(name)
        {
            const url = new URL(window.location.href);
            url.search = "";
            const params = new URLSearchParams(window.location.search);
            params.delete(name);

            const newUrl = url + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);
        }
    </script>


    {{-- Scroll horizontalement les pseudos trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/ResizeIndexComponent.js', 'resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js', 'resources/js/skins/AnimationsManager.js'])
</div>
