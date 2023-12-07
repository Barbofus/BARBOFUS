

<div class="relative w-fit mt-2" @click.away="showSort = false"
     x-data="{
        showSort: false,
        selection: 0,
        searchResetTime: 500, // in ms
        searchResult: null,

        setSelection(newSelection)
        {
            this.selection = newSelection;
            this.showSort = false;

            Livewire.emit('ToggleRace', this.selection);

            ToggleArrayParamToUrl('classe', this.selection);
        },

        keyPressed(e)
        {
            let key;

            // Si on est dans le menu du choix de classe, on récupère la touche
            if(e.key.length == 1)
                key = e.key.toLowerCase();

            if (key >= 'a' && key <= 'z'){ // Si on a une lettre
                this.pushedLetter(key);
            }
            else if (e.code == 'Enter') {
                this.setSelection(this.searchResult);
            }
        },

        pushedLetter(key)
        {
            // Ajoute la lettre au tableau de la recherche
            searchedLetters.push(key);

            // Reset le timeout
            if(to) clearTimeout(to);

            // Lance un timeout qui vide le tableau après un delai
            to = setTimeout(function (){
                searchedLetters = [];
            }, this.searchResetTime);

            // Va prendre la première classe qu'il trouve avec cette recherche
            this.searchForResult();
        },

        searchForResult()
        {
            if(searchedLetters.length < 2) return;

            const search = searchedLetters.join('');
            let result = null;

            for (let i=0; i<races.length; i++)
            {
                if(races[i]['name'].normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().startsWith(search)){
                    result = i;
                    break;
                }
            }

            if(result == null) return;

            this.searchResult = result + 1;

            // Enlève la classe active à toutes les classes
            for (let i=0; i<races.length; i++)
            {
                document.getElementById('label_race_id_' + (i+1)).classList.remove('active');
            }

            // Puis l'ajoute et scroll sur la classe choisie
            const race = document.getElementById('label_race_id_' + this.searchResult);
            goScrollTo(race);
        },
    }">

    <!-- Resultat -->
    <button type="button"
            @click="showSort = !showSort"
            @keydown="if(showSort) keyPressed($event), window.scrollTo({top: 0, behavior: 'smooth'})"
            class="flex transition-all rounded-md w-[15rem] text-inactiveText hover:text-secondary font-light items-center justify-left gap-x-2 border-2 border-inactiveText hover:border-secondary cursor-pointer h-12 bg-primary-100 p-2">
        <p>Choisis une classe ...</p>
    </button>

    <!-- Menu déroulant -->
    <div x-show="showSort" x-cloak class="left-0 top-12 w-[15rem] max-h-[18.75rem] overflow-auto rounded-b-md z-50 absolute bg-primary-100 text-[1rem] font-light transition-all duration-200 cursor-pointer" id="race-dropdown">
        @foreach ($races as $race)
            <button id="label_race_id_{{ $race->id }}"
                    aria-label="Filtre {{ $race->name }}"
                    @click="setSelection( {{ $race->id }}), window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="flex rounded-md items-center transition-all w-full justify-left gap-x-2 text-inactiveText border-2 border-primary-100 hover:border-inactiveText cursor-pointer h-12 bg-primary-100 p-2 [&.active]:border-inactiveText [&.active]:text-secondary">
                <img src="{{ asset('storage/' . $race->ghost_icon_path) }}" class="h-11">
                <p>{{ $race->name }}</p>
            </button>
        @endforeach
    </div>

    {{-- Affichage des classes actuels --}}
    <div class="flex flex-wrap justify-start w-full max-h-[3.5rem] overflow-auto items-center gap-2 mt-2">
        @foreach($raceWhere as $race)
            <button wire:click="$emit('ToggleRace', {{ $race[2] }})"
                    @click="window.scrollTo({top: 0, behavior: 'smooth'}), ToggleArrayParamToUrl('classe', {{ $race[2] }})"
                    class="flex justify-between items-center px-2 py-1 bg-black bg-opacity-[0.2] rounded-[2.25px] group hover:bg-opacity-100 hover:bg-primary-100 transition-colors">
                <p class="font-light text-[1rem] text-inactiveText">{{ $races[$race[2]-1]->name  }}</p>

                <!-- Croix -->
                <svg class="w-4 text-red-500 group-hover:text-red-400 ml-2"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endforeach
    </div>

    <script>
        const races = @json($races);
        let to;
        let searchedLetters = [];

        function goScrollTo(el)
        {
            if(!el) return;

            el.classList.add('active');

            el.parentElement.scrollTo({ behavior: 'smooth', top: el.offsetTop});
        }
    </script>
</div>
