<div>
    <div class="grid grid-cols-1 grid-rows-[34.375rem,37.5rem,32.5rem] gap-4
            md:grid-cols-[18.75rem,18.75rem] md:grid-rows-[35rem,18rem]
            lg:grid-cols-[18.75rem,40.625rem] lg:grid-rows-[repeat(2,23rem)]">
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
