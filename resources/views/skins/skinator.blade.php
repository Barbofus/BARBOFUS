@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(3rem,10vw)] my-8 font-normal text-center uppercase">Skinator</h1>

    <form autocomplete="off"
          class="w-[min(90vw,120rem)] mx-auto"
          method="POST"
          id="skinator-form"
          action=""
          enctype="multipart/form-data"
          onkeydown="return event.key != 'Enter';"
          x-init="if(getDataFromURL()) { getAlpineDataFromURL(getDataFromURL()) } else { colors = getDefaultColor(gender, breed); editURLParam(getFinalResult()) } "
          x-data="{
            copy: null,
            copyTimeout: null,
            colorsLabel: [
                '{{ __('barbofus.labelSkinColorsSkin') }}',
                '{{ __('barbofus.labelSkinColorsHair') }}',
                '{{ __('barbofus.labelSkinColorsClothes') }} 1',
                '{{ __('barbofus.labelSkinColorsClothes') }} 2',
                '{{ __('barbofus.labelSkinColorsClothes') }} 3',
                '{{ __('barbofus.labelSkinColorsClothes') }} 4',
            ],
            shouldResetColors: false,
            charactersCurrentTab: 'breed',
            oldGender: 0,
            oldBreed: 1,
            gender: 0,
            breed: 1,
            head: updateHead(this.gender, this.breed),
            colors: [],

            getAlpineDataFromURL(json)
            {
                this.breed = json.breed;
                this.gender = json.gender;
                this.head = json.head;
                this.colors = json.colors.map(color => `#${color.toString(16).padStart(6, '0')}`);
            },

            getFinalResult()
            {
                return JSON.stringify(shortenKeys({
                    gender: this.gender,
                    breed: this.breed,
                    head: this.head,
                    colors: this.colors.map(color =>
                        typeof color === 'string' ? parseInt(color.replace('#', ''), 16) : color
                    )
                }));
            },

            getTESTDataFromURL()
            {
                return JSON.stringify(getDataFromURL(), null ,2);
            },

            getTESTResult()
            {
                return JSON.stringify({
                    gender: this.gender,
                    breed: this.breed,
                    head: this.head,
                    colors: this.colors.map(color =>
                        typeof color === 'string' ? parseInt(color.replace('#', ''), 16) : color
                    )
                }, null, 2);
            },

            updateAlpineHead()
            {
                this.head = updateHead(this.gender, this.breed);

                if(this.shouldResetColors) {
                    this.colors = getDefaultColor(this.gender, this.breed);
                    this.shouldResetColors = false;
                }

                editURLParam(this.getFinalResult())
            },

            copyHex(index)
            {
                if(this.copyTimeout) {
                    clearTimeout(this.copyTimeout);
                }

                this.copy = index;
                navigator.clipboard.writeText(this.colors[index]);

                this.copyTimeout = setTimeout(() => {
                    this.copy = null;
                    this.copyTimeout = null;
                }, 1000);
            },
          }">

        {{--    ITEMS ACTUELS    --}}
        <div class="h-24">
            items coché
        </div>

        <div class="flex">

            {{--      REGLAGES PERSONNAGE      --}}
            <div class="w-[25.5rem]">
                <div class="text-xl h-12 font-thin flex justify-evenly">
                    <button type="button"
                            class="w-1/3 uppercase"
                            :class="(charactersCurrentTab === 'breed') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'"
                            @click="charactersCurrentTab = 'breed'; charactersTabTransition = true">{{ __('barbofus.contentBreed') }}</button>
                    <button type="button"
                            class="w-1/3 uppercase"
                            :class="(charactersCurrentTab === 'head') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'"
                            @click="charactersCurrentTab = 'head'; charactersTabTransition = true">{{ __('barbofus.contentFace') }}</button>
                    <button type="button"
                            class="w-1/3 uppercase"
                            :class="(charactersCurrentTab === 'color') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'"
                            @click="charactersCurrentTab = 'color'; charactersTabTransition = true">{{ __('barbofus.contentColor') }}</button>
                </div>

                {{--      Choix sexe      --}}
                <p class="text-xl text-center mt-4 mb-1 font-light">{{ __('barbofus.labelSkinGender') }}</p>
                <div class="flex gap-x-4 w-fit mx-auto">
                    <div>
                        <input id="male"
                               x-model.number="gender"
                               type="radio"
                               value="0"
                               class="hidden peer"
                               :checked="gender === 0"
                               @change="editURLParam(getFinalResult()); updateAlpineHead()">
                        <label
                            for="male"
                            @click="shouldResetColors = checkIfDefaultColors(gender, breed, colors)"
                            class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                            </svg>
                            <p>{{ __('barbofus.inputSkinMale') }}</p>
                        </label>
                    </div>

                    <div>
                        <input id="female"
                               x-model.number="gender"
                               type="radio"
                               value="1"
                               class="hidden peer"
                               :checked="gender === 1"
                               @change="editURLParam(getFinalResult()); updateAlpineHead()">
                        <label for="female"
                               @click="shouldResetColors = checkIfDefaultColors(gender, breed, colors)"
                               class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                            </svg>
                            <p>{{ __('barbofus.inputSkinFemale') }}</p>
                        </label>
                    </div>
                </div>

                <div x-cloak x-show="charactersCurrentTab === 'breed'" class="p-4">

                    {{--      Choix classe      --}}
                    <p class="text-xl text-center mt-4 mb-1 font-light">{{ __('barbofus.labelSkinClass') }}</p>

                    <div class="flex flex-wrap gap-4 justify-center items-center">
                        @foreach($breeds as $breed)
                            <div>
                                <input id="breed_{{ $breed->dofus_id }}"
                                       x-model.number="breed"
                                       type="radio"
                                       value="{{ $breed->dofus_id }}"
                                       class="hidden peer"
                                       :checked="breed === {{ $breed->dofus_id }}"
                                       @change="editURLParam(getFinalResult()); updateAlpineHead()">
                                <label for="breed_{{ $breed->dofus_id }}"
                                       @click="shouldResetColors = checkIfDefaultColors(gender, breed, colors)"
                                       title="{{ $breed->name }}"
                                       class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-20 h-20 flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                    <img x-show="gender === 0" draggable="false" src="{{ asset('storage/images/icons/classes/faces/unity/'. $breed->heads->male->{0}->assetId .'.png') }}" alt="{{ $breed->name }}">
                                    <img x-show="gender === 1" draggable="false" src="{{ asset('storage/images/icons/classes/faces/unity/'. $breed->heads->female->{0}->assetId .'.png') }}" alt="{{ $breed->name }}">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div x-cloak x-show="charactersCurrentTab === 'head'" class="p-4">

                    {{--      Choix visage      --}}
                    <p class="text-xl text-center mt-4 mb-1 font-light">{{ __('barbofus.labelSkinFace') }}</p>

                    <div class="flex flex-wrap gap-4 justify-center items-center">
                        @foreach($breeds as $breed)
                            @foreach($breed->heads as $genderKey => $gender)
                                @foreach($gender as $head)
                                    <div x-show="breed === {{ $breed->dofus_id }} && (gender === 0 ? 'male' : 'female') === '{{ $genderKey }}'">

                                        <input id="head_{{ $head->id }}"
                                               x-model.number="head"
                                               type="radio"
                                               value="{{ $head->id }}"
                                               class="hidden peer"
                                               :checked="head === {{ $head->id }}"
                                               @change="editURLParam(getFinalResult())">
                                        <label for="head_{{ $head->id }}"
                                               title="{{ __('barbofus.contentFace').' '.$breed->name . ' ' . $head->id }}"
                                               class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-20 h-20 flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                            <img draggable="false" src="{{ asset('storage/images/icons/classes/faces/unity/'. $head->assetId .'.png') }}" alt="{{ __('barbofus.contentFace').' '.$breed->name . ' ' . $head->id }}">
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div x-cloak x-show="charactersCurrentTab === 'color'" id="color-tab" class="p-4 relative">

                    {{--      Choix couleur      --}}
                    <div class="flex flex-wrap justify-evenly">
                        <template x-for="(color, index) in colors" :key="index">
                            <div :id="'color-' + index" class="my-3 hover:bg-primary-100 rounded-t-lg overflow-hidden transition-colors">
                                <button type="button"
                                        @click="copyHex(index)"
                                        class="relative flex w-full py-1 px-2 justify-between items-center">
                                    <p x-text="colorsLabel[index] + ' :'" class="font-thin text-lg"></p>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 fill-inactiveText">
                                        <path d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                                        <path d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                                    </svg>

                                    <div x-cloak
                                         :class="copy === index ? 'opacity-100' : 'opacity-0' "
                                         class="absolute flex items-center justify-center bg-secondary transition h-full w-full top-0 left-0">
                                        <p class="text-primary font-medium text-xl uppercase">{{ __('barbofus.contentCopied') }} !</p>
                                    </div>
                                </button>

                                <div class="flex items-center h-10">

                                    <!-- Input de couleur -->
                                    <input type="text"
                                           x-model="colors[index]"
                                           @input="colors[index] = '#' + colors[index].replace(/[^0-9a-fA-F]/g, '').slice(0, 6); editURLParam(getFinalResult())"
                                           class="uppercase order-last h-full peer rounded-r p-1 bg-primary-100 text-center w-28 focus:outline-none border-transparent focus:border-secondary border-y border-r transition-colors">

                                    <!-- Aperçu de la couleur (clic pour ouvrir le picker) -->
                                    <button type="button" @click="$dispatch('show-color-picker', { hex: colors[index], cindex: index, inputPosition: getInputPosition(index) })"
                                         @color-picked.window="if(index === $event.detail.cindex) colors[index] = $event.detail.hex; editURLParam(getFinalResult())"
                                         class="w-10 h-full rounded-l cursor-pointer focus:outline-none border-transparent border-y border-l peer-focus:border-secondary transition-colors"
                                         :style="{ background: colors[index] }"></button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Composant Color Picker -->
                    <x-utils.color-picker />

                    <button type="button" @click="colors = getDefaultColor(gender, breed); editURLParam(getFinalResult())" class="py-2 mt-4 flex items-center space-x-2 px-4 mx-auto rounded-md text-xl bg-primary-100 text-inactiveText uppercase hover:text-red-500 hover:rounded-3xl transition-all duration-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                        <p>Reset</p>
                    </button>
                </div>
            </div>

            {{--      RESULTAT SKIN + ORIENTATION + EXPORT PNG + COPY LINK      --}}
            <div class="w-96 p-4">
                <p>skin + flèches pour tourner, bouton anim combat, copy link, poster sur barbofus</p>
                <div class="flex justify-evenly">
                    <p class="mt-16 whitespace-pre-wrap w-fit" x-text="getTESTResult"/>
                    <p class="mt-16 whitespace-pre-wrap w-fit" x-text="getTESTDataFromURL"/>
                </div>
            </div>

            {{--      TOUS LES ITEMS      --}}
            <div class="flex-1">items, onglets par catégories</div>
        </div>
    </form>

    <script>
        const breedInfo = @js($breeds);
        const colorTab = document.getElementById('color-tab')
        const mapKeys = { gender: "1", breed: "2", head: "3", colors: "4", orientation: "5", skins: "6", bone: "7", battleIdle: "8" };

        function shortenKeys(obj) {
            return Object.fromEntries(Object.entries(obj).map(([key, value]) => [mapKeys[key] || key, value]));
        }

        function expandKeys(obj) {
            const reverseMap = Object.fromEntries(Object.entries(mapKeys).map(([k, v]) => [v, k]));
            return Object.fromEntries(Object.entries(obj).map(([key, value]) => [reverseMap[key] || key, value]));
        }

        const decimalToHex = (decimal) => '#' + decimal.toString(16).padStart(6, '0').toUpperCase();

        function checkIfDefaultColors(gender, breed, colors)
        {
            let count = 0;
            const defaultColors = getDefaultColor(gender, breed)

            colors.forEach((color, index) => {
                if(defaultColors[index].toUpperCase() == color.toUpperCase()) count++
            })

            return count === colors.length
        }

        function updateHead(gender, breed)
        {
            const currentBreed = breedInfo.find(b => b.dofus_id === breed)
            return currentBreed ? currentBreed.heads[gender === 0 ? 'male' : 'female'][0].id : 1
        }

        function getDefaultColor(gender, breed)
        {
            const currentBreed = breedInfo.find(b => b.dofus_id === breed);

            if (currentBreed) {
                // Applique la fonction decimalToHex à chaque couleur de colors[gender]
                return currentBreed.colors[gender === 0 ? 'male' : 'female'].map(decimalToHex);
            }

            return [];
        }

        function getInputPosition(index)
        {
            const input = document.getElementById('color-' + index);

            let x = input.getBoundingClientRect().x - colorTab.getBoundingClientRect().x;
            let y = input.getBoundingClientRect().y + input.getBoundingClientRect().height - colorTab.getBoundingClientRect().y;

            return { x, y }
        }

        function editURLParam(json) {
            const compressed = LZString.compressToEncodedURIComponent(json);
            const params = new URLSearchParams(window.location.search);
            params.set('s', compressed);

            const url = new URL(window.location.href);
            url.search = "";

            const newUrl = url + '?' + params.toString();
            window.history.pushState({ path: newUrl }, '', newUrl);
        }

        function getDataFromURL() {
            const params = new URLSearchParams(window.location.search);
            const compressed = params.get('s');
            if (!compressed) return null;

            return expandKeys(JSON.parse(LZString.decompressFromEncodedURIComponent(compressed)));
        }
    </script>
@endsection
