@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(3rem,10vw)] my-8 font-normal text-center uppercase">Skinator</h1>

    <form autocomplete="off"
          class="w-[min(90vw,120rem)] mx-auto mb-16"
          method="POST"
          id="skinator-form"
          action=""
          enctype="multipart/form-data"
          onkeydown="return event.key != 'Enter';"
          x-init="if(getDataFromURL()) { getAlpineDataFromURL(getDataFromURL()) } else { colors = getDefaultColor(gender, breed); editURLParam(getURLObject()) } "
          x-data="{
            copy: null,
            copyTimeout: null,
            possibleOrientation: {
                'Static': [1,2,3,4,5,6,7,0],
                'Combat': [1,3,5,7],
                'Monture': [1,2,3,4,5,6,7,0],
            },
            orientationKey: 0,
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
            animation: 'Static',

            getAlpineDataFromURL(json)
            {
                this.breed = json.breed;
                this.gender = json.gender;
                this.head = json.head;
                this.colors = json.colors.map(color => `#${color.toString(16).padStart(6, '0')}`);
            },

            getURLObject()
            {
                return JSON.stringify(shortenKeys({
                    gender: this.gender,
                    breed: this.breed,
                    head: this.head,
                    colors: this.colors.map(color =>
                        typeof color === 'string' ? parseInt(color.replace('#', ''), 16) : color
                    ),
                }));
            },

            getRendererObject()
            {
                return JSON.stringify({
                    gender: this.gender,
                    breed: this.breed,
                    head: this.head,
                    colors: this.colors.map(color =>
                        typeof color === 'string' ? parseInt(color.replace('#', ''), 16) : color
                    ),
                    orientation: this.possibleOrientation[this.animation][this.orientationKey],
                    animation: this.animation,
                }, null, 2);
            },

            getTESTDataFromURL()
            {
                return JSON.stringify(getDataFromURL(), null ,2);
            },

            updateAlpineHead()
            {
                this.head = updateHead(this.gender, this.breed);

                if(this.shouldResetColors) {
                    this.colors = getDefaultColor(this.gender, this.breed);
                    this.shouldResetColors = false;
                }

                editURLParam(this.getURLObject())
            },

            copyToClipboard(toCopy, name)
            {
                if(this.copyTimeout) {
                    clearTimeout(this.copyTimeout);
                }

                this.copy = name;
                navigator.clipboard.writeText(toCopy);

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
                               @change="editURLParam(getURLObject()); updateAlpineHead()">
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
                               @change="editURLParam(getURLObject()); updateAlpineHead()">
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
                                       @change="editURLParam(getURLObject()); updateAlpineHead()">
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
                                               @change="editURLParam(getURLObject())">
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
                                        @click="copyToClipboard(colors[index], 'hex'+index)"
                                        class="relative flex w-full py-1 px-2 justify-between items-center">
                                    <p x-text="colorsLabel[index] + ' :'" class="font-thin text-lg"></p>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 fill-inactiveText">
                                        <path d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                                        <path d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                                    </svg>

                                    <div x-cloak
                                         :class="copy === 'hex'+index ? 'opacity-100' : 'opacity-0' "
                                         class="absolute flex items-center justify-center bg-secondary transition h-full w-full top-0 left-0">
                                        <p class="text-primary font-medium text-xl uppercase">{{ __('barbofus.contentCopied') }} !</p>
                                    </div>
                                </button>

                                <div class="flex items-center h-10">

                                    <!-- Input de couleur -->
                                    <input type="text"
                                           x-model="colors[index]"
                                           @input="colors[index] = '#' + colors[index].replace(/[^0-9a-fA-F]/g, '').slice(0, 6); editURLParam(getURLObject())"
                                           class="uppercase order-last h-full peer rounded-r p-1 bg-primary-100 text-center w-28 focus:outline-none border-transparent focus:border-secondary border-y border-r transition-colors">

                                    <!-- Aperçu de la couleur (clic pour ouvrir le picker) -->
                                    <button type="button" @click="$dispatch('show-color-picker', { hex: colors[index], cindex: index, inputPosition: getInputPosition(index) })"
                                         @color-picked.window="if(index === $event.detail.cindex) colors[index] = $event.detail.hex; editURLParam(getURLObject())"
                                         class="w-10 h-full rounded-l cursor-pointer focus:outline-none border-transparent border-y border-l peer-focus:border-secondary transition-colors"
                                         :style="{ background: colors[index] }"></button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Composant Color Picker -->
                    <x-utils.color-picker />

                    <button type="button"
                            @click="colors = getDefaultColor(gender, breed); editURLParam(getURLObject())"
                            class="py-2 mt-4 flex items-center space-x-2 px-4 mx-auto rounded-md text-xl bg-primary-100 text-inactiveText uppercase hover:text-red-500 hover:rounded-3xl transition-all duration-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                        <p>Reset</p>
                    </button>
                </div>
            </div>

            {{--      RESULTAT SKIN + ORIENTATION + EXPORT PNG + COPY LINK      --}}
            <div class="w-96 p-4 space-y-4 h-fit mt-16">
                <div class="flex justify-evenly">
                    <p class="mt-16 whitespace-pre-wrap w-fit" x-text="getRendererObject"/>
                    <p class="mt-16 whitespace-pre-wrap w-fit" x-text="getTESTDataFromURL"/>
                </div>

                {{-- Skin + bouton d'export --}}
                <div class="relative w-fit mx-auto">
                    <img x-ref="finalSkin" src="{{ asset('storage/images/skins/1741861810.png') }}" alt="Skin result">

                    {{-- Bouton DL --}}
                    <button type="button"
                            @click="let a = document.createElement('a'); a.href = $refs.finalSkin.src; a.download = 'image.png'; a.click();"
                            class="absolute bottom-0 left-0 p-2 bg-primary-100 rounded-lg border-2 border-transparent hover:bg-primary hover:border-secondary transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </button>

                    {{-- Bouton Copier --}}
                    <button type="button"
                            @click="copyToClipboard('', 'finalSkin'); fetch($refs.finalSkin.src).then(res => res.blob()).then(blob => navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })])).catch(err => console.error(err))"
                            :class="copy === 'finalSkin' ? 'bg-secondary text-primary' : 'bg-primary-100 hover:bg-primary hover:border-secondary'"
                            class="absolute bottom-0 right-0 p-2 rounded-lg border-2 border-transparent transition-all">
                        <svg x-show="copy != 'finalSkin'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <p x-show="copy === 'finalSkin'">{{ __('barbofus.contentCopied') }}</p>
                    </button>
                </div>

                {{-- Zone sous skins / Orientation / Animation --}}
                <div class="flex justify-evenly space-x-8 w-fit mx-auto">
                    <button type="button" class="group" @click="orientationKey--; if(orientationKey < 0) orientationKey = possibleOrientation[animation].length - 1">
                        <img src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 -scale-x-100 group-active:translate-y-0 group-active:scale-y-90 group-active:-scale-x-90 transition-all">
                    </button>

                    <button type="button"
                            :disabled="animation === 'Monture'"
                            class="group relative h-8 w-16 rounded-full bg-primary-100 p-2 disabled:cursor-not-allowed"
                            @click="orientationKey = 0; (animation === 'Static' ? animation = 'Combat' : (animation === 'Combat' ? animation = 'Static' : animation = 'Monture'))">
                        <div class="h-5 w-5 p-1 left-1.5 absolute top-1.5 bg-secondary text-primary rounded-full transition-all group-disabled:bg-inactiveText"
                             :class="(animation === 'Static' || animation === 'Monture') ? 'translate-x-0' : 'translate-x-8'">
                            <svg x-cloak x-show="animation === 'Static'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                            </svg>

                            <svg x-cloak x-show="animation === 'Combat'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M8.5 1a.75.75 0 0 0-.75.75V6.5a.5.5 0 0 1-1 0V2.75a.75.75 0 0 0-1.5 0V7.5a.5.5 0 0 1-1 0V4.75a.75.75 0 0 0-1.5 0v4.5a5.75 5.75 0 0 0 11.5 0v-2.5a.75.75 0 0 0-1.5 0V9.5a.5.5 0 0 1-1 0V2.75a.75.75 0 0 0-1.5 0V6.5a.5.5 0 0 1-1 0V1.75A.75.75 0 0 0 8.5 1Z" />
                            </svg>
                        </div>
                    </button>

                    <button type="button" class="group" @click="orientationKey++; if(orientationKey >= possibleOrientation[animation].length) orientationKey = 0">
                        <img src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 group-active:translate-y-0 group-active:scale-90 transition-all">
                    </button>
                </div>

                {{-- Boutons copy link + Export PNG --}}
                <div class="flex justify-evenly space-x-8">

                    {{-- Bouton Copy link --}}
                    <div class="w-full flex justify-end">
                        <button type="button"
                                @click="copyToClipboard(window.location.href, 'url')"
                                x-text="copy === 'url' ? '{{ __('barbofus.contentCopied') }}' : '{{ __('barbofus.contentCopy') }} URL'"
                                :class="copy === 'url' ? 'bg-secondary text-primary' : 'bg-primary-100 hover:bg-primary hover:border-secondary'"
                                class="px-4 w-32 py-2 rounded-lg border-2 border-transparent transition-all">
                        </button>
                    </div>

                    {{-- Bouton Partager --}}
                    <div class="w-full flex justify-start">
                        <button class="g-recaptcha px-8 py-3 text-lg font-normal text-primary goldGradient rounded-lg hover:brightness-110 hover:tracking-widest transition-all focus:brightness-75 uppercase"
                                data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                data-callback='onSubmit'
                                data-action='store'>
                            {{ __('barbofus.buttonShare') }}
                        </button>

                        @error('g-recaptcha-response')
                        <x-forms.requirements-error :message="$message"/>
                        @enderror
                    </div>
                </div>

                <script data-type="lazy" data-src="https://www.google.com/recaptcha/api.js"></script>

                <script>
                    function onSubmit(token) {
                        document.getElementById("skinator-form").submit();
                    }
                </script>
            </div>

            {{--      TOUS LES ITEMS      --}}
            <div class="flex-1">items, onglets par catégories</div>
        </div>
    </form>

    <script>
        const breedInfo = @js($breeds);
        const colorTab = document.getElementById('color-tab')
        const mapKeys = { gender: "1", breed: "2", head: "3", colors: "4", skins: "5", bone: "6" };

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
