@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(3rem,10vw)] mt-8 font-normal text-center uppercase">Skinator</h1>

    <form autocomplete="off"
          class="w-[min(90vw,120rem)] mx-auto mb-16"
          method="POST"
          id="skinator-form"
          action=""
          enctype="multipart/form-data"
          onkeydown="return event.key != 'Enter';"
          x-data="skinator"
          x-init="initWatcher">
        {{--    ITEMS ACTUELS    --}}
        <div class="flex space-x-4 my-2 h-24"
             @click="if(event.target.closest('button[data-key]')) {
                const key = event.target.closest('button[data-key]').dataset.key;
                const id = items[key];
                const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                if (radio) radio.checked = false;

                items[key] = null;
                editURLParam(getURLObject());
             }">
            <template x-for="(item, key) in Object.fromEntries(Object.entries(items).filter(([key, value]) => value !== null))" :key="item">
                <button type="button"
                        :title="allItems.find(i => i.dofus_id === item).name"
                        :data-key="key"
                        class="bg-primary-100 h-full group relative rounded-lg py-1 px-2 min-w-[11rem] overflow-hidden">

                    <div class="flex items-start">
                        <img loading="lazy" draggable="false" class="h-16" :src="'/storage/' + allItems.find(i => i.dofus_id === item).icon_path"
                             :alt="allItems.find(i => i.dofus_id === item).name">
                        <div class="flex items-end space-x-1 pt-4">
                            <img loading="lazy" draggable="false" width="24" height="24"
                                 class="h-6 w-6"
                                 :src="'/storage/images/icons/items/subcategories/' + allItems.find(i => i.dofus_id === item).subcategory + '.png'"
                                 :alt="allItems.find(i => i.dofus_id === item).subcategory">
                            <p x-text="'Lv.' + allItems.find(i => i.dofus_id === item).level" class="text-inactiveText whitespace-nowrap"></p>
                        </div>
                    </div>

                    <p x-text="allItems.find(i => i.dofus_id === item).name" class="text-left truncate"></p>

                    <div class="bg-black w-full h-full absolute top-0 left-0 opacity-0 group-hover:opacity-70 transition-all"></div>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                         class="h-6 w-6 text-red-500 absolute top-1 right-1 group-hover:h-20 group-hover:w-20 transition-all">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </template>
        </div>

        <div class="flex h-[40rem]">

            {{--      REGLAGES PERSONNAGE      --}}
            <div class="w-[25.5rem]">

                {{-- CHOIX ONGLET --}}
                <div class="text-xl h-12 font-thin flex justify-evenly"
                     @click="if(event.target.closest('button[data-tab]')) { charactersCurrentTab = event.target.closest('button[data-tab]').dataset.tab; }">
                    <button type="button"
                            class="w-1/3 uppercase"
                            data-tab="breed"
                            :class="(charactersCurrentTab === 'breed') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'">{{ __('barbofus.contentBreed') }}</button>
                    <button type="button"
                            class="w-1/3 uppercase"
                            data-tab="head"
                            :class="(charactersCurrentTab === 'head') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'">{{ __('barbofus.contentFace') }}</button>
                    <button type="button"
                            class="w-1/3 uppercase"
                            data-tab="color"
                            :class="(charactersCurrentTab === 'color') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'">{{ __('barbofus.contentColor') }}</button>
                </div>

                {{--      Choix sexe      --}}
                <p class="text-xl text-center mt-4 mb-1 font-light">{{ __('barbofus.labelSkinGender') }}</p>
                <div class="flex gap-x-4 w-fit mx-auto"
                     @change="if (event.target.matches('input[type=radio]')) { shouldResetColors = checkIfDefaultColors(gender, breed, colors); gender = Number(event.target.value); editURLParam(getURLObject()); updateAlpineHead(); }">
                    <div>
                        <input id="male"
                               type="radio"
                               name="gender"
                               value="0"
                               class="hidden peer"
                               :checked="gender === 0">
                        <label
                            for="male"
                            class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                            </svg>
                            <p>{{ __('barbofus.inputSkinMale') }}</p>
                        </label>
                    </div>

                    <div>
                        <input id="female"
                               type="radio"
                               name="gender"
                               value="1"
                               class="hidden peer"
                               :checked="gender === 1">
                        <label for="female"
                               class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                            </svg>
                            <p>{{ __('barbofus.inputSkinFemale') }}</p>
                        </label>
                    </div>
                </div>

                <div x-cloak class="p-4"
                     x-show="charactersCurrentTab === 'breed'">

                    {{--      Choix classe      --}}
                    <p class="text-xl text-center mb-1 font-light">{{ __('barbofus.labelSkinClass') }}</p>

                    <div class="flex flex-wrap gap-2 justify-center items-center"
                         @change="if (event.target.matches('input[type=radio]')) { shouldResetColors = checkIfDefaultColors(gender, breed, colors); breed = Number(event.target.value); editURLParam(getURLObject()); updateAlpineHead(); }">
                        <template x-for="breedInfo in breedInfos" :key="breedInfo.dofus_id">
                            <div>
                                <input :id="'breed_' + breedInfo.dofus_id"
                                       type="radio"
                                       name="breed"
                                       :value="breedInfo.dofus_id"
                                       class="hidden peer"
                                       :checked="breed === breedInfo.dofus_id">
                                <label :for="'breed_' + breedInfo.dofus_id"
                                       :title="breed.name"
                                       class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-20 h-20 flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                    <img loading="lazy" draggable="false" :src="'/storage/images/icons/classes/faces/unity/' + breedInfo.heads[gender === 0 ? 'male' : 'female'][0].assetId + '.png'"
                                         :alt="breed.name">
                                </label>
                            </div>
                        </template>
                    </div>
                </div>

                <div x-cloak class="p-4"
                     x-show="charactersCurrentTab === 'head'">

                    {{--      Choix visage      --}}
                    <p class="text-xl text-center mb-1 font-light">{{ __('barbofus.labelSkinFace') }}</p>

                    <div class="flex flex-wrap gap-2 justify-center items-center"
                         @change="if (event.target.matches('input[type=radio]')) { head = Number(event.target.value); editURLParam(getURLObject()); }">
                        <template x-for="breedHead in breedHeads" :key="breedHead.id">
                            <div>
                                <input :id="'head_' + breedHead.id"
                                       type="radio"
                                       name="head"
                                       :value="breedHead.id"
                                       class="hidden peer"
                                       :checked="head === breedHead.id">
                                <label :for="'head_' + breedHead.id"
                                       :title="'{{ __('barbofus.contentFace') }} ' + breedInfos[breed-1].name + ' ' + breedHead.id"
                                       class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-20 h-20 flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                    <img loading="lazy" draggable="false" :src="'/storage/images/icons/classes/faces/unity/' + breedHead.assetId + '.png'"
                                         :alt="'{{ __('barbofus.contentFace') }} ' + breedInfos[breed-1].name + ' ' + breedHead.id">
                                </label>
                            </div>
                        </template>
                    </div>
                </div>

                <div x-cloak id="color-tab" class="p-4 relative"
                     x-show="charactersCurrentTab === 'color'">

                    {{--      Choix couleur      --}}
                    <div class="flex flex-wrap justify-evenly"
                         @click="if(event.target.closest('button[data-copy]')) { copyToClipboard(colors[event.target.closest('button[data-copy]').dataset.copy], 'hex' + event.target.closest('button[data-copy]').dataset.copy) }"
                         @input="if(event.target.closest('input[data-color]')) { colors[event.target.closest('input[data-color]').dataset.color] = '#' + event.target.closest('input[data-color]').value.replace(/[^0-9a-fA-F]/g, '').slice(0, 6); editURLParam(getURLObject()) }">
                        <template x-for="(color, index) in colors" :key="index">
                            <div :id="'color-' + index" class="my-3 hover:bg-primary-100 rounded-t-lg overflow-hidden transition-colors">
                                <button type="button"
                                        :data-copy="index"
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
                                           :value="colors[index]"
                                           :data-color="index"
                                           class="uppercase order-last h-full peer rounded-r p-1 bg-primary-100 text-center w-28 focus:outline-none border-transparent focus:border-secondary border-y border-r transition-colors">

                                    <div class="w-10 h-full rounded-l cursor-pointer focus:outline-none border-transparent border-y border-l peer-focus:border-secondary" :style="{ background: colors[index] }">
                                        <input type="color"
                                               :data-color="index"
                                               :value="colors[index]"
                                               class="opacity-0 h-full w-full cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <button type="button"
                            @click="colors = getDefaultColor(gender, breed); editURLParam(getURLObject()); window.resetColors()"
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

                {{-- Skin + bouton d'export --}}
                <div class="relative w-fit mx-auto">
                    <canvas x-ref="canvas" id="canvas" width="250" height="390"></canvas>

                    {{-- Bouton DL --}}
                    <button type="button"
                            @click="() => {
                                const canvas = $refs.canvas;
                                const a = document.createElement('a');
                                a.href = canvas.toDataURL('image/png');
                                a.download = 'image.png';
                                a.click();
                            };"
                            class="absolute bottom-0 left-0 p-2 bg-primary-100 rounded-lg border-2 border-transparent hover:bg-primary hover:border-secondary transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </button>

                    {{-- Bouton Copier --}}
                    <button x-cloak type="button"
                            @click="() => {
                                copyToClipboard('', 'finalSkin');
                                const canvas = $refs.canvas;
                                canvas.toBlob(blob => {
                                    if (blob) {
                                        navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })]);
                                    }
                                });
                            }"
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
                        <img loading="lazy" src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 -scale-x-100 group-active:translate-y-0 group-active:scale-y-90 group-active:-scale-x-90 transition-all">
                    </button>

                    {{-- Choix anim exploration / combat --}}
                    <button type="button"
                            title="Exploration / Combat"
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
                        <img loading="lazy" src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 group-active:translate-y-0 group-active:scale-90 transition-all">
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

                {{--<div class="flex justify-evenly">
                    <p class="mt-16 whitespace-pre-wrap w-fit" x-text="getRendererObject"/>
                </div>--}}

                <script data-type="lazy" data-src="https://www.google.com/recaptcha/api.js"></script>

                <script>
                    function onSubmit(token) {
                        document.getElementById("skinator-form").submit();
                    }
                </script>
            </div>

            {{--      TOUS LES ITEMS      --}}
            <div class="flex-1 flex flex-col h-full">

                {{-- CHOIX ONGLET --}}
                <div class="text-xl h-12 font-thin flex justify-evenly"
                     @click="if(event.target.closest('button[data-tab]')) { itemsCurrentTab = event.target.closest('button[data-tab]').dataset.tab; maxItemVisible = 96; if(searchBar != '') { searchBar = ''; updateFilteredItems(); } }">

                    @foreach($itemCategories as $category)
                        <button type="button"
                                data-tab="{{ $category }}"
                                class="w-1/3 uppercase"
                                :class="(itemsCurrentTab === '{{ $category }}') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'">{{ __('barbofus.content' . ucfirst($category)) }}</button>
                    @endforeach
                </div>

                <div class="relative flex items-center space-x-2 h-10 my-2 w-[16rem] bg-primary-100 rounded-md py-2">
                    <input maxlength="64" id="skinator-search" type="text" placeholder="{{ __('barbofus.contentRefineSearch') }}"
                           x-model="searchBar"
                           x-ref="skinatorSearchInput"
                           @input="updateFilteredItems"
                           class="rounded-md pl-4 focus:outline-none placeholder-inactiveText bg-primary-100" />

                    <button type="button"
                            x-cloak
                            @click="searchBar = ''; $refs.skinatorSearchInput.focus(); updateFilteredItems()"
                            class="relative w-6 h-6"
                            for="skinator-search">
                        <svg :class="searchBar.length === 0 ? 'visible' : 'invisible'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="h-6 text-inactiveText absolute top-0 left-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>

                        <svg :class="searchBar.length > 0 ? 'visible' : 'invisible'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="h-6 text-red-500 absolute top-0 left-0">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-auto flex flex-wrap gap-2 justify-left"
                     @change="if (event.target.matches('input[type=radio]')) { items[event.target.dataset.category] = Number(event.target.dataset.id); editURLParam(getURLObject()); }">
                    <template x-for="(allItem, index) in (searchBar.length >= 3 ? filteredItems : filteredItems.filter(i => i.category === itemsCurrentTab)).slice(0, maxItemVisible)"
                              :key="allItem.dofus_id">
                        <div class="h-fit">
                            <input :id="allItem.category + '_' + allItem.dofus_id"
                                   :data-category="allItem.category"
                                   :data-id="allItem.dofus_id"
                                   type="radio"
                                   :name="allItem.category"
                                   :value="allItem.dofus_id"
                                   class="hidden peer"
                                   :checked="items[allItem.category] === allItem.dofus_id">
                            <label :for="allItem.category + '_' + allItem.dofus_id"
                                   :title="allItem.name"
                                   class="transition-all overflow-hidden relative rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-24 h-24 flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText"
                                   x-data="{ loaded: false, intersected: false }">

                                <div :class="allItem.subcategory != 'mimisymbic' ? 'visible' : 'invisible'" class="h-4 w-4 goldGradientTop absolute -top-2 -left-2 rotate-45"></div>

                                <div class="flex gap-1 absolute pointer-events-none">
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:0ms]"
                                         :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' : 'opacity-0 invisible'"></div>
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:100ms]"
                                         :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' : 'opacity-0 invisible'"></div>
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:200ms]"
                                         :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' : 'opacity-0 invisible'"></div>
                                </div>


                                <img loading="lazy"
                                     draggable="false"
                                     height="80"
                                     width="80"
                                     :src="'/storage/' + allItem.icon_path"
                                     :alt="allItem.name"
                                     class="mt-0 transition-opacity delay-100 duration-300"
                                     @load="loaded = true"
                                     x-intersect:enter="intersected = true"
                                     :class="(loaded && intersected) ? 'opacity-100' : 'opacity-0'">
                            </label>
                        </div>
                    </template>
                </div>

                <button type="button"
                        x-cloak
                        :class="maxItemVisible < filteredItems.filter(i => i.category === itemsCurrentTab).length ? 'visible' : 'invisible'"
                        :disabled="maxItemVisible >= filteredItems.filter(i => i.category === itemsCurrentTab).length"
                        class="py-2 w-fit mx-auto px-6 my-4 group rounded-md bg-secondary text-primary hover:rounded-lg transition-all"
                        @click="maxItemVisible += 480">
                    <p class="group-hover:-translate-y-0.5 transition-all">{{ __('barbofus.contentLoadMore') }}</p>
                </button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("skinator", () => ({
                breedInfos: @js($breeds),
                allItems: @js($items),
                loadedItems: new Set(),
                filteredItems: null,
                breedHeads: null,
                maxItemVisible: 96,
                searchBar: '',
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
                itemsCurrentTab: 'hat',
                oldGender: 0,
                oldBreed: 1,
                gender: 0,
                breed: 1,
                head: null,
                colors: [],
                animation: 'Static',
                items: {
                    hat: null,
                    cape: null,
                    shield: null,
                    pet: null,
                    shoulderpads: null,
                    wings: null,
                    costume: null,
                },
                previousData: '',

                initWatcher() {
                    Alpine.effect(() => {
                        const data = this.getRendererObject();

                        if (data !== this.previousData) {
                            this.previousData = data;
                            window.updateRendererData(data);
                        }
                    });
                },

                init()
                {
                    this.head = this.updateHead(this.gender, this.breed);
                    this.breedHeads = this.updateHeads(this.gender, this.breed);
                    this.updateFilteredItems();

                    if(getDataFromURL()) {
                        this.getAlpineDataFromURL(getDataFromURL())
                    }
                    else
                    {
                        this.colors = this.getDefaultColor(this.gender, this.breed);
                        editURLParam(this.getURLObject())
                    }
                },

                getAlpineDataFromURL(json)
                {
                    this.breed = json.breed;
                    this.gender = json.gender;
                    this.head = json.head;
                    this.breedHeads = this.updateHeads(json.gender, json.breed);
                    this.colors = json.colors.map(color => `#${color.toString(16).padStart(6, '0')}`);
                    this.items = json.items;
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
                        items: this.items,
                    }));
                },

                getRendererObject()
                {
                    return JSON.stringify({
                        gender: this.gender,
                        breed: this.breed,
                        head: this.head,
                        /*colors: this.colors.map(color =>
                            typeof color === 'string' ? parseInt(color.replace('#', ''), 16) : color
                        ),*/
                        orientation: this.possibleOrientation[this.animation][this.orientationKey],
                        animation: this.animation,
                        skins: Object.entries(this.items)
                            .map(([key, value]) => {
                                if (!value) return null;

                                const item = this.allItems.find(i => i.dofus_id === value && i.folder === 'skins');
                                return item ? (this.gender === 0 ? item.asset_id : item.female_asset_id) : null;
                            })
                            .filter(Boolean),
                        bones: Object.entries(this.items)
                            .map(([key, value]) => {
                                if (!value) return null;

                                const item = this.allItems.find(i => i.dofus_id === value && i.folder === 'bones');
                                return item ? (this.gender === 0 ? item.asset_id : item.female_asset_id) : null;
                            })
                            .filter(Boolean),
                    }, null, 2);
                },

                updateAlpineHead()
                {
                    this.head = this.updateHead(this.gender, this.breed);
                    this.breedHeads = this.updateHeads(this.gender, this.breed);

                    if(this.shouldResetColors) {
                        this.colors = this.getDefaultColor(this.gender, this.breed);
                        this.shouldResetColors = false;
                    }

                    editURLParam(this.getURLObject())

                    window.resetColors()
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

                checkIfDefaultColors(gender, breed, colors)
                {
                    let count = 0;
                    const defaultColors = this.getDefaultColor(gender, breed)

                    colors.forEach((color, index) => {
                        if(defaultColors[index].toUpperCase() == color.toUpperCase()) count++
                    })

                    return count === colors.length
                },

                updateFilteredItems()
                {
                    if(this.searchBar.length >= 3) {
                        this.filteredItems = this.allItems.filter(i =>
                            removeAccents(i.name).toLowerCase().includes(removeAccents(this.searchBar).toLowerCase())
                        );

                    }
                    else {
                        this.filteredItems = this.allItems;
                    }

                    this.maxItemVisible = 96;
                },

                updateHead(gender, breed)
                {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    return currentBreed ? currentBreed.heads[gender === 0 ? 'male' : 'female'][0].id : 1
                },

                updateHeads(gender, breed)
                {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    return currentBreed ? currentBreed.heads[gender === 0 ? 'male' : 'female'] : 1
                },

                getDefaultColor(gender, breed)
                {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed);

                    if (currentBreed) {
                        // Applique la fonction decimalToHex à chaque couleur de colors[gender]
                        return currentBreed.colors[gender === 0 ? 'male' : 'female'].map(decimalToHex);
                    }

                    return [];
                },
            }));
        });

        const colorTab = document.getElementById('color-tab')
        const mapKeys = { gender: "1", breed: "2", head: "3", colors: "4", items: "5", hat: "6", cape: "7", shield: "8", pet: "9", costume: "10", shoulderpads: "11", wings: "12" };

        function shortenKeys(obj) {
            if (Array.isArray(obj)) {
                return obj.map(item => shortenKeys(item, mapKeys));
            } else if (typeof obj === 'object' && obj !== null) {
                return Object.fromEntries(
                    Object.entries(obj).map(([key, value]) => [
                        mapKeys[key] || key,
                        shortenKeys(value, mapKeys)
                    ])
                );
            }
            return obj;
        }

        function expandKeys(obj) {
            const reverseMap = Object.fromEntries(Object.entries(mapKeys).map(([k, v]) => [v, k]));

            if (Array.isArray(obj)) {
                return obj.map(item => expandKeys(item, mapKeys));
            } else if (typeof obj === 'object' && obj !== null) {
                return Object.fromEntries(
                    Object.entries(obj).map(([key, value]) => [
                        reverseMap[key] || key,
                        expandKeys(value, mapKeys)
                    ])
                );
            }
            return obj;
        }

        function removeAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        const decimalToHex = (decimal) => '#' + decimal.toString(16).padStart(6, '0').toUpperCase();

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

        window.getDataFromURL = function () {
            const params = new URLSearchParams(window.location.search);
            const compressed = params.get('s');
            if (!compressed) return null;

            return expandKeys(JSON.parse(LZString.decompressFromEncodedURIComponent(compressed)));
        };
    </script>

    <script id="vertex-2d" type="x-shader/x-vertex">
        precision mediump float;

        attribute vec3 position;
        attribute vec2 texCoord;

        uniform vec2 u_resolution;

        varying vec2 vTexCoord;

        void main() {
            // Transformation du pixel vers clip space
            vec2 zeroToOne = position.xy / u_resolution;
            vec2 zeroToTwo = zeroToOne * 2.0;
            vec2 clipSpace = zeroToTwo - 1.0;

            // Inversion Y car WebGL a l'axe Y inversé
            gl_Position = vec4(clipSpace.x + 1.0, clipSpace.y + 0.6, 0.0, 0.55);
            vTexCoord = texCoord;
        }

    </script>

    <script id="fragment-2d" type="x-shader/x-fragment">
        precision mediump float;

        varying vec2 vTexCoord;
        uniform sampler2D u_texture;
        uniform vec3 u_mainColor;

        void main() {
            vec4 texColor = texture2D(u_texture, vec2(vTexCoord.s, 1.0 - vTexCoord.t));
            texColor.rgb *= u_mainColor.rgb;
            texColor.rgb *= texColor.a;
            gl_FragColor = texColor;

        }
    </script>

    <script src="//cdn.jsdelivr.net/npm/protobufjs@7.4.0/dist/protobuf.min.js"></script>

    <script async>

        let urlData = {};
        let COLORS = [];
        let rendererData = {};
        let gl = null;
        let program = null;

        let uMainColor
        let positionsBuffer
        let uvsBuffer
        let indicesBuffer

        let textures = null

        let data = null

        let focusColor = null

        let skinRendererProto = null

        window.addEventListener('DOMContentLoaded', () => {
            urlData = window.getDataFromURL();
            COLORS = urlData.colors;
        });

        window.resetColors = function () {
            urlData = window.getDataFromURL();
            COLORS = urlData.colors;
        };

        window.updateRendererData = function (data) {
            rendererData = data;
            console.log(rendererData);

            UpdateRenderer()
        };

        async function loadTexture(gl, url) {
            const image = await new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = (err) => reject(new Error(`Erreur de chargement de l'image: ${url}`));
                img.src = url;
            });

            const texture = gl.createTexture();
            gl.bindTexture(gl.TEXTURE_2D, texture);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
            gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image);
            gl.generateMipmap(gl.TEXTURE_2D);

            return texture;
        }

        async function Prepapre () {
            const root = await protobuf.load('/storage/proto/skin.proto')
            skinRendererProto = root.lookupType("SkinRenderer");
        }

        async function UpdateRenderer () {
            const response = await fetch('http://62.241.115.223:9461/renderer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: rendererData
            })
            if (!response.ok) {
                throw new Error('Network response was not ok' + response.statusText);
            }
            const buffer = await response.arrayBuffer();
            let newData = skinRendererProto.decode(new Uint8Array(buffer));

            const newTexture = []
            for (const texture of newData.textures) {
                newTexture.push(await loadTexture(gl, 'storage/images/skinator/' + texture))
            }


            textures = newTexture
            data = newData
        }

        async function InitGL() {
            const canvas = document.getElementById('canvas');
            gl = canvas.getContext('webgl2', { alpha: true,  antialias: true,
                depth: false, preserveDrawingBuffer: false , premultipliedAlpha: true, stencil: false });

            gl.viewport(0, 0, canvas.width, canvas.height);



            if (!gl) {
                console.error('WebGL not supported, falling back on experimental-webgl');
                gl = canvas.getContext('experimental-webgl');
            }

            if (!gl) {
                alert('Your browser does not support WebGL');
            }

            const vertexShaderSource = document.getElementById('vertex-2d').textContent;
            const fragmentShaderSource = document.getElementById('fragment-2d').textContent;

            const vertexShader = gl.createShader(gl.VERTEX_SHADER);
            gl.shaderSource(vertexShader, vertexShaderSource);
            gl.compileShader(vertexShader);

            const fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
            gl.shaderSource(fragmentShader, fragmentShaderSource);
            gl.compileShader(fragmentShader);

            program = gl.createProgram();
            gl.attachShader(program, vertexShader);
            gl.attachShader(program, fragmentShader);
            gl.linkProgram(program);
            gl.useProgram(program);

            const uResolution = gl.getUniformLocation(program, 'u_resolution');
            gl.uniform2f(uResolution, canvas.width, canvas.height);


            uMainColor = gl.getUniformLocation(program, 'u_mainColor')
            positionsBuffer = gl.createBuffer();
            uvsBuffer = gl.createBuffer();
            indicesBuffer = gl.createBuffer();

            gl.enable(gl.BLEND);
            gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);
        }


        function draw () {
            gl.clearColor(0, 0, 0, 0);
            gl.clear(gl.COLOR_BUFFER_BIT);

            if(!data) return;

            const frames0 = data.frames[indexFrame % data.frames.length].frame;

            for (const part of frames0) {

                if (part.colorIndex !== null) {
                    const color = COLORS[part.colorIndex];
                    const r = ((color >> 16) & 0xFF) / 255;
                    const g = ((color >> 8) & 0xFF) / 255;
                    const b = (color & 0xFF) / 255;
                    let focusing = false
                    if (focusColor == part.colorIndex) {
                        focusing = ((indexFrame >> 3) & 1)
                    }

                    if(focusing) {
                        gl.uniform3fv(uMainColor, [2-r*2, 2-g*2, 2-b*2]);
                    }
                    else {
                        gl.uniform3fv(uMainColor, [2*r, 2*g, 2*b]);
                    }

                } else {
                    gl.uniform3fv(uMainColor, [1, 1, 1]);
                }

                const positions = new Float32Array(part.positions);
                const uvs = new Float32Array(part.uvs);
                const indices = new Uint16Array(part.indices);

                gl.bindBuffer(gl.ARRAY_BUFFER, positionsBuffer);
                gl.bufferData(gl.ARRAY_BUFFER, positions, gl.STATIC_DRAW);

                gl.bindBuffer(gl.ARRAY_BUFFER, uvsBuffer);
                gl.bufferData(gl.ARRAY_BUFFER, uvs, gl.STATIC_DRAW);

                gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, indicesBuffer);
                gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, indices, gl.STATIC_DRAW);

                const positionAttribLocation = gl.getAttribLocation(program, 'position');
                gl.bindBuffer(gl.ARRAY_BUFFER, positionsBuffer);
                gl.enableVertexAttribArray(positionAttribLocation);
                gl.vertexAttribPointer(positionAttribLocation, 3, gl.FLOAT, false, 0, 0);

                const texCoordAttribLocation = gl.getAttribLocation(program, 'texCoord');
                gl.bindBuffer(gl.ARRAY_BUFFER, uvsBuffer);
                gl.enableVertexAttribArray(texCoordAttribLocation);
                gl.vertexAttribPointer(texCoordAttribLocation, 2, gl.FLOAT, false, 0, 0);

                gl.activeTexture(gl.TEXTURE0);
                gl.bindTexture(gl.TEXTURE_2D, textures[part.textureIndex]);
                const textureLocation = gl.getUniformLocation(program, 'u_texture');
                gl.uniform1i(textureLocation, 0);

                gl.bindBuffer(gl.ARRAY_BUFFER, indicesBuffer);
                gl.drawElements(gl.TRIANGLES, indices.length, gl.UNSIGNED_SHORT, 0 );
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.nextTick(() => {
                document.querySelectorAll('input[type="color"]').forEach(input => {
                    input.addEventListener('input', (event) => {
                        const colorIndex = event.target.getAttribute('data-color');
                        const colorValue = event.target.value;
                        const r = parseInt(colorValue.slice(1, 3), 16);
                        const g = parseInt(colorValue.slice(3, 5), 16);
                        const b = parseInt(colorValue.slice(5, 7), 16);
                        COLORS[colorIndex] = (r << 16) | (g << 8) | b;
                    });

                    input.addEventListener('mouseenter', (event) => {
                        focusColor = event.target.getAttribute('data-color');
                    });

                    input.addEventListener('mouseleave', () => {
                        focusColor = null;
                    });

                    input.addEventListener('click', () => {
                        focusColor = null;
                    });
                });

                document.querySelectorAll('input[type="text"][data-color]').forEach(input => {
                    input.addEventListener('input', (event) => {
                        const colorIndex = event.target.getAttribute('data-color');
                        const colorValue = event.target.value;
                        const r = parseInt(colorValue.slice(1, 3), 16);
                        const g = parseInt(colorValue.slice(3, 5), 16);
                        const b = parseInt(colorValue.slice(5, 7), 16);
                        COLORS[colorIndex] = (r << 16) | (g << 8) | b;
                    });
                });

            });
        });



        let indexFrame = 0
        let lastTime = 0;
        const targetFPS = 30;
        const interval = 1000 / targetFPS;

        async function main() {
            await Prepapre()
            await InitGL()
            //await UpdateRenderer()

            function animate(currentTime) {
                requestAnimationFrame(animate);

                const delta = currentTime - lastTime;

                if (delta >= interval) {
                    lastTime = currentTime - (delta % interval);
                    draw();
                    indexFrame += 1;
                }
            }

            requestAnimationFrame(animate);
        }
        main()

    </script>

@endsection
