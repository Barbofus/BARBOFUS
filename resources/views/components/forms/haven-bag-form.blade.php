<div class="flex flex-col items-center" x-data="{
        finaleUrl: '{{ isset($havenBag) ? asset('storage/' . $havenBag['image_path']) : '' }}',

        ChangeFile(event) {
            this.FileToDataUrl(event, src => this.finaleUrl = src)
        },

        FileToDataUrl(event, callback) {
            if (! event.target.files.length) return

            let file = event.target.files[0],
            reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = e => callback(e.target.result)
        }
    }">

    {{-- Début form --}}
    <div class="flex items-center gap-10 flex-col p-2 w-[min(24rem,90vw)]">

        {{-- Raison du refus --}}
        @if(isset($havenBag) && $havenBag['status'] == 'Refused')
            <div class="bg-red-300 border border-red-500 h-[clamp(6rem,8rem)] p-4 rounded-md text-red-900 w-full flex flex-col items-center justify-center">
                <p class="font-light">Ton havre-sac a été refusé <span>{{ $havenBag['refused_reason'] ? ' car' : '!' }}</span></p>
                <p class="font-normal italic break-words max-w-full">{{ $havenBag['refused_reason'] }}</p>
            </div>
        @endif

        <!-- Tuto poste -->
        <a class="w-full hidden -mt-6 items-center justify-left cursor-pointer gap-x-2
            [@media(min-height:501px)_and_(min-width:501px)]:flex
            min-[901px]:flex"
           href="" target="_blank">
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
            <p class="font-display text-secondary text-[1rem]">Tuto pour un meilleur screenshot !</p>
        </a>

        {{-- Nom du havre-sac--}}
        <div class="w-full">
            <p class="ml-10 text-xl text-secondary font-light">Nom du havre-sac (optionnel)</p>
            <input x-ref="input"
                   maxlength="30" name="name" id="name" type="text" placeholder="Nom"
                   class="w-full mt-2 h-10 rounded-md pl-14 focus:outline-none placeholder-inactiveText bg-primary-100 @error('name') err-border @enderror"
                   value="{{ (old('name')) ? (old('name')) : (isset($havenBag) ? $havenBag['name'] : '') }}"/>
        </div>

        {{-- Choix du thème --}}
        <div class="w-full mt-5">
            <p class="ml-10 text-xl font-light">Choix du thème</p>
            <div class="relative w-full">

                <!-- Resultat -->
                <button type="button" onclick="toggle()" id="themes_result"
                        class="flex transition-all rounded-md w-full items-center justify-left gap-x-2 border-2 text-secondary border-goldText hover:border-secondary cursor-pointer h-12 bg-primary-100 p-2">
                    <img id="tr_img" class="h-11">
                    <p id="tr_name"></p>
                </button>

                <!-- Menu déroulant -->
                <div class="left-0 top-12 w-full max-h-[18.75rem] overflow-auto rounded-b-md z-50 absolute bg-primary-100 text-[1rem] font-light transition-all duration-200 cursor-pointer" id="themes_dropdown">
                    @foreach ($hbThemes as $hbTheme)
                        <div>
                            <input type="radio" value="{{ $hbTheme->id }}" class="hidden peer" name="haven_bag_theme_id" id="haven_bag_theme_id_{{ $hbTheme->id }}"
                                {{ (old('haven_bag_theme_id')) ? ((old('haven_bag_theme_id') == $hbTheme->id) ? 'checked' : '') : (isset($havenBag) ? (($havenBag['haven_bag_theme_id'] == $hbTheme->id) ? 'checked' : '') : (($hbTheme->id == 1) ? 'checked' : '')) }}>
                            <label for="haven_bag_theme_id_{{ $hbTheme->id }}" id="label_haven_bag_theme_id_{{ $hbTheme->id }}"
                                   onclick="setSelection({{ $hbTheme->id }})"
                                   @keydown.enter="selection = {{ $hbTheme->id }}, showSort = false"
                                   class="flex rounded-md items-center transition-all justify-left gap-x-2 text-inactiveText border-2 border-primary-100 hover:border-inactiveText cursor-pointer h-12 bg-primary-100 p-2 [&.active]:border-inactiveText [&.active]:text-secondary">
                                <img src="{{ $hbTheme->popocket_icon_path }}" class="h-11 aspect-square">
                                <p>{{ $hbTheme->name }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                const themes_result = document.getElementById('themes_result');
                const themes_dropdown = document.getElementById('themes_dropdown');
                const rr_img = document.getElementById('tr_img');
                const rr_name = document.getElementById('tr_name');
                const themes = @json($hbThemes);
                const searchResetTime = 500; // in ms
                let to;
                let searchResult;
                let searchedLetters = [];
                let showSort = true;
                let selection = {{ (old('haven_bag_theme_id')) ? old('haven_bag_theme_id') : (isset($havenBag) ? $havenBag['haven_bag_theme_id'] : 1) }};

                init();

                // Affiche la bonne classe de base et masque le menu
                function init()
                {
                    selection -= 1; // id partent de 1 en php, 0 en js
                    refreshResult();
                    toggle();
                }

                // Set l'image et le texte de la classe selectionné
                function refreshResult()
                {
                    tr_img.src = themes[selection]['popocket_icon_path']
                    tr_name.textContent = themes[selection]['name']
                }

                // Toggle la variable showSort
                function toggle()
                {
                    showSort = !showSort;
                    themes_dropdown.hidden = !showSort;
                }

                // Change la classe selectionné
                function setSelection(newSelection)
                {
                    selection = newSelection-1;
                    showSort = false;
                    themes_dropdown.hidden = !showSort;
                    document.getElementById('haven_bag_theme_id_' + newSelection).checked = true;
                    refreshResult();
                }

                function pushedLetter(key)
                {
                    // Ajoute la lettre au tableau de la recherche
                    searchedLetters.push(key);

                    // Reset le timeout
                    if(to) clearTimeout(to);

                    // Lance un timeout qui vide le tableau après un delai
                    to = setTimeout(function (){
                        searchedLetters = [];
                        //setSelection(searchResult);
                    }, searchResetTime);

                    // Va prendre la première classe qu'il trouve avec cette recherche
                    searchForResult();
                }

                function searchForResult()
                {
                    if(searchedLetters.length < 2) return;

                    const search = searchedLetters.join("");
                    let result = null;

                    for (let i=0; i<themes.length; i++)
                    {
                        if(themes[i]['name'].normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().startsWith(search)){
                            result = i;
                            break;
                        }
                    }

                    if(result == null) return;

                    searchResult = result + 1;

                    // Enlève la classe active à toutes les classes
                    for (let i=0; i<themes.length; i++)
                    {
                        document.getElementById('label_haven_bag_theme_id_' + (i+1)).classList.remove('active');
                    }

                    // Puis l'ajoute et scroll sur la classe choisie
                    const theme = document.getElementById('label_haven_bag_theme_id_' + searchResult);
                    theme.classList.add('active');
                    theme.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                }

                // Detecte si on clique hors du choix de classe
                document.addEventListener('click', event => {
                    const isClickInside = themes_result.parentElement.contains(event.target)

                    // Si on clique bien dehors, on ferme tout
                    if (!isClickInside) {
                        showSort = false;
                        themes_dropdown.hidden = !showSort;
                    }
                })

                // On check chaque touche du clavier
                window.addEventListener('keydown', function (e) {

                    let key;

                    // Si on est dans le menu du choix de classe, on récupère la touche
                    if(showSort){

                        if(e.key.length == 1)
                            key = e.key.toLowerCase();

                        if (key >= 'a' && key <= 'z'){ // Si on a une lettre
                            pushedLetter(key);
                        }
                        else if (e.code == 'Enter') {
                            setSelection(searchResult);
                        }
                    }
                }, false);
            </script>

            @error('haven_bag_theme_id')
                <x-forms.requirements-error :$message />
            @enderror
        </div>

        {{-- Image du havre-sac--}}
        <div class="w-full">
            <p class="ml-10 text-xl font-light">Image du havre-sac</p>
            <div class="mt-2 @error('image_path') err-border @enderror">
                <input x-on:input.change="ChangeFile" class="w-full text-inactiveText rounded-md cursor-pointer bg-primary-100 focus:outline-none file:goldGradient file:text-primary file:h-10 file:border-0 hover:file:brightness-110 file:cursor-pointer" type="file" name="image_path" accept="image/png">
                <p class="mt-1 ml-8 text-sm text-inactiveText" id="file_input_help">Minimum 1200x650</p>
            </div>

            @error('image_path')
                <x-forms.requirements-error :$message />
            @enderror
        </div>
    </div>

    <div class="flex justify-center"><img x-show="finaleUrl" x-cloak x-transition class="mt-4 max-w-[75rem]" :src="finaleUrl" draggable="false"/></div>


    {{-- Bouton valider, avec google recaptcha--}}
    <div class="mt-8 mb-16">
        <button class="g-recaptcha block px-8 py-3 text-lg mx-auto font-normal text-primary goldGradient rounded-lg hover:brightness-110 hover:tracking-widest transition-all focus:brightness-75 uppercase"
                data-sitekey="{{ config('services.recaptcha.site_key') }}"
                data-callback='onSubmit'
                data-action='{{ $action }}'>
            Valider
        </button>

        @error('g-recaptcha-response')
            <x-forms.requirements-error :message="$message"/>
        @enderror
    </div>

    <script data-type="lazy" data-src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        function onSubmit(token) {
            document.getElementById("havenbag-form").submit();
        }
    </script>
</div>
