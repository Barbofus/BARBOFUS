<div>
    <div class="grid grid-cols-1 grid-rows-[34.375rem,37.5rem,32.5rem] gap-4
            md:grid-cols-[18.75rem,18.75rem] md:grid-rows-[35rem,18rem]
            lg:grid-cols-[18.75rem,40.625rem] lg:grid-rows-[23rem,18rem]">
        {{-- Image + raison du refus--}}
        <div class="lg:row-span-2 flex items-center gap-4 flex-col p-2">

            {{-- Choix de l'image --}}
            <div x-data="{
                finaleUrl: '{{ isset($skin) ? asset('storage/' . $skin['image_path']) : '' }}',

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

                <!-- Tuto poste -->
                <a class="invisible flex items-center justify-left mb-4 cursor-pointer gap-x-2
                    [@media(min-height:501px)_and_(min-width:501px)]:visible
                    min-[901px]:visible"
                   href="https://www.youtube.com/watch?v=teuDOhkgIaM" target="_blank">
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
                    <p class="font-display text-secondary text-[1rem]">Tuto pour l'export PNG</p>
                </a>
                <p class="ml-10 text-xl font-light">Image du skin</p>
                <div class="mt-2 @error('image_path') err-border @enderror">
                    <input x-on:input.change="ChangeFile" class="w-[min(18.75rem,90vw)] text-inactiveText rounded-md cursor-pointer bg-primary-100 focus:outline-none file:goldGradient file:text-primary file:h-10 file:border-0 hover:file:brightness-110 file:cursor-pointer" type="file" name="image_path" accept="image/png">
                    <p class="mt-1 ml-8 text-sm text-inactiveText" id="file_input_help">Export PNG de DofusBook<br> (MAX. 350x450px, 100ko).</p>
                </div>

                <div class="flex justify-center"><img x-show="finaleUrl" x-cloak x-transition class="mt-4" width="200" height="260" :src="finaleUrl" draggable="false"/></div>

                @error('image_path')
                    <x-forms.requirements-error :$message />
                @enderror
            </div>

            {{-- Raison du refus --}}
            @if(isset($skin) && $skin['status'] == 'Refused')
                <div class="bg-red-300 border border-red-500 h-[clamp(6rem,8rem)] p-4 rounded-md text-red-900 max-w-[18.75rem] flex flex-col items-center justify-center order-first md:order-2">
                    <p class="font-light">Ton skin a été refusé <span>{{ $skin['refused_reason'] ? ' car' : '!' }}</span></p>
                    <p class="font-normal italic break-words max-w-full">{{ $skin['refused_reason'] }}</p>
                </div>
            @endif
        </div>

        {{-- Sexe / Visage / Couleurs --}}
        <div class="p-2">
            <div class="flex flex-col items-start lg:flex-row gap-4">

                {{-- Choix du sexe --}}
                <div>
                    <p class="text-xl ml-10 font-light">Choix du sexe</p>
                    <div class="flex gap-x-4">

                        <div>
                            <input id="male" name="gender" type="radio" value="Homme" class="hidden peer" checked>
                            <label for="male" class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                                </svg>
                                <p>Homme</p>
                            </label>
                        </div>

                        <div>
                            <input id="female" name="gender" type="radio" value="Femme" class="hidden peer"
                                {{ (old('gender')) ? ((old('gender') == 'Femme') ? 'checked' : '') : (isset($skin) ? (($skin['gender'] == 'Femme') ? 'checked' : '') : '') }}>
                            <label for="female" class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                </svg>
                                <p>Femme</p>
                            </label>
                        </div>
                    </div>
                    @error('gender')
                    <x-forms.requirements-error :$message />
                    @enderror


                    {{-- Choix de la classe --}}
                    <div class="mt-5">
                        <p class="ml-10 text-xl font-light">Choix de la classe</p>
                        <div class="relative"
                             x-data="{
                                  races: {{ json_encode(array_values($races)) }},
                                  showSort: false,
                                  selection: {{ (old('race_id')) ? old('race_id') : (isset($skin) ? $skin['race_id'] : 1) }},
                                }" x-init="console.log(races)">
                            <div x-on:mousedown.outside="if(showSort) showSort = false">

                                <!-- Resultat -->
                                <div x-on:mousedown="showSort = !showSort"
                                     class="flex transition-all rounded-md w-[15rem] items-center justify-left gap-x-2 border-2 text-secondary border-goldText hover:border-secondary cursor-pointer h-12 bg-primary-100 p-2">
                                    <img :src="races[selection-1]['ghost_icon_path']" class="h-11">
                                    <p x-text="races[selection-1]['name']"></p>
                                </div>

                                <!-- Menu déroulant -->
                                <div class="left-0 top-12 w-[15rem] max-h-[18.75rem] overflow-auto rounded-b-md z-50 absolute bg-primary-100 text-[1rem] font-light transition-all duration-200 cursor-pointer "
                                     x-show="showSort" x-transition.opacity x-cloak >
                                    @foreach ($races as $race)
                                        <div>
                                            <input type="radio" value="{{ $race->id }}" class="hidden peer" name="race_id" id="race_id_{{ $race->id }}"
                                                {{ (old('race_id')) ? ((old('race_id') == $race->id) ? 'checked' : '') : (isset($skin) ? (($skin['race_id'] == $race->id) ? 'checked' : '') : (($race->id == 1) ? 'checked' : '')) }}>
                                            <label for="race_id_{{ $race->id }}"
                                                   @click="selection = {{ $race->id }}, showSort = false"
                                                   class="flex rounded-md items-center transition-all justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-secondary hover:border-inactiveText cursor-pointer h-12 bg-primary-100 p-2">
                                                <img src="{{ $race->ghost_icon_path }}" class="h-11">
                                                <p>{{ $race->name }}</p>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('race_id')
                        <x-forms.requirements-error :$message />
                        @enderror
                    </div>

                    {{-- Choix du visage --}}
                    <p class="mt-5 ml-10 text-xl font-light">Choix du visage</p>
                    <div class="grid grid-cols-4 gap-4 mt-4 w-fit">
                        @for ($i = 1; $i <= 8; $i++)
                            <label class="w-12 h-12">
                                <input type="radio" name="face" value="{{ $i }}" class="absolute opacity-0 peer"
                                    {{ (old('face')) ? ((old('face') == $i) ? 'checked' : '') : (isset($skin) ? ($skin['face'] == $i ? 'checked' : '') : (($i == 1) ? 'checked' : '')) }}>
                                <div class="flex rounded-md items-center justify-center w-full h-full text-3xl bg-primary-100 border-2 border-inactiveText cursor-pointer hover:border-secondary peer-checked:border-goldText">{{ $i }}</div>
                            </label>
                        @endfor
                    </div>
                    @error('face')
                    <x-forms.requirements-error :$message />
                    @enderror
                </div>

                {{-- Choix des couleurs --}}
                <div class="lg:ml-10">
                    <p class="text-xl ml-10 font-light">Choix des couleurs</p>

                    <div class="grid grid-flow-row grid-cols-2 gap-4
                        lg:grid-cols-1">
                        <x-forms.color-input title="Peau:" name="color_skin"
                                       value="{{ (old('color_skin')) ? (old('color_skin')) : (isset($skin) ? $skin['color_skin'] : '') }}" />

                        <x-forms.color-input title="Cheveux:" name="color_hair"
                                       value="{{ (old('color_hair')) ? (old('color_hair')) : (isset($skin) ? $skin['color_hair'] : '') }}" />

                        <x-forms.color-input title="Habits 1:" name="color_cloth_1"
                                       value="{{ (old('color_cloth_1')) ? (old('color_cloth_1')) : (isset($skin) ? $skin['color_cloth_1'] : '') }}" />

                        <x-forms.color-input title="Habits 2:" name="color_cloth_2"
                                       value="{{ (old('color_cloth_2')) ? (old('color_cloth_2')) : (isset($skin) ? $skin['color_cloth_2'] : '') }}" />

                        <x-forms.color-input title="Habits 3:" name="color_cloth_3"
                                       value="{{ (old('color_cloth_3')) ? (old('color_cloth_3')) : (isset($skin) ? $skin['color_cloth_3'] : '') }}" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Choix des items --}}
        <div class="p-2
                    md:col-span-2 md:row-start-2
                    lg:col-start-2">
            <p class="text-xl ml-10 font-light">Choix des items</p>
            <div class="grid grid-flow-row grid-cols-1 gap-4
                        md:grid-cols-2">
                <livewire:forms.searchbar-items-autocomplete :relatedModel="'dofus_item_hats'" :name="'dofus_item_hat_id'" :placeholder="'Choisis une coiffe...'"
                                                             :value="(old('dofus_item_hat_id')) ? old('dofus_item_hat_id') : (isset($skin) ? $skin['dofus_item_hat_id']: '')"  />

                <livewire:forms.searchbar-items-autocomplete :relatedModel="'dofus_item_cloaks'" :name="'dofus_item_cloak_id'" :placeholder="'Choisis une cape...'"
                                                             :value="(old('dofus_item_cloak_id')) ? old('dofus_item_cloak_id') : (isset($skin) ? $skin['dofus_item_cloak_id']: '')" />

                <livewire:forms.searchbar-items-autocomplete :relatedModel="'dofus_item_shields'" :name="'dofus_item_shield_id'" :placeholder="'Choisis un bouclier...'"
                                                             :value="(old('dofus_item_shield_id')) ? old('dofus_item_shield_id') : (isset($skin) ? $skin['dofus_item_shield_id']: '')" />

                <livewire:forms.searchbar-items-autocomplete :relatedModel="'dofus_item_pets'" :name="'dofus_item_pet_id'" :placeholder="'Choisis un familier...'"
                                                             :value="(old('dofus_item_pet_id')) ? old('dofus_item_pet_id') : (isset($skin) ? $skin['dofus_item_pet_id']: '')" />

                <livewire:forms.searchbar-items-autocomplete :relatedModel="'dofus_item_costumes'" :name="'dofus_item_costume_id'" :placeholder="'Choisis un costume...'"
                                                             :value="(old('dofus_item_costume_id')) ? old('dofus_item_costume_id') : (isset($skin) ? $skin['dofus_item_costume_id']: '')" />
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <div class="mt-8">
        <x-forms.submit>Valider</x-forms.submit>
    </div>
</div>
