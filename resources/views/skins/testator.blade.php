@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(3rem,10vw)] mt-8 font-normal text-center uppercase">{{ (str_ends_with(Route::currentRouteName(), 'edit')) ? __('barbofus.titleEdit') : 'Skinator' }}</h1>

    <form autocomplete="off"
          class="w-[min(98vw,120rem)] mx-auto mb-16 h-fit relative"
          method="POST"
          id="skinator-form"
          action="{{ $route }}"
          enctype="multipart/form-data"
          onkeydown="return event.key != 'Enter';"
          x-data="skinator"
          x-init="initWatcher">

        @method($method)
        @csrf

        <input type="file" name="image_path" id="image_path" hidden>

        {{-- PREVISU PARTAGE --}}
        <div x-show="openShareUI" x-cloak
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             @click.outside="openShareUI = false; $refs.btnShare.disabled = false;"
             class="absolute p-4 shadow-[rgba(0,_0,_0,_0.5)_0px_0px_70px_4px] rounded-lg bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
            <img id="previsu-img" src="" height="500" width="300" alt="Render" style="opacity: 0" class="transition-all mx-auto">

            <div class="w-full absolute top-1/4 left-0 pointer-events-none">
                <div id="shareLoader" class="border-[0.375rem] border-inactiveText border-l-goldText w-20 h-20 rounded-full opacity-0 mx-auto [--custom-animation-time:1s]"></div>
            </div>

            <input x-ref="input"
                   maxlength="30" name="name" id="name" type="text" placeholder="{{ __('barbofus.inputName').' (optionnal)' }}"
                   value="{{ (old('name') ? old('name') : (isset($skin) ? $skin['name'] : '')) }}"
                   class="w-full h-10 pl-4 focus:outline-none placeholder-inactiveText bg-primary-100"/>

            {{-- Bouton Valider --}}
            <div class="w-full flex justify-evenly mt-4">

                {{-- Valider --}}
                <button type="button"
                        id="myRecaptchaBtn"
                        class="relative px-5 py-3 text-lg font-normal text-primary goldGradient rounded-lg hover:enabled:brightness-110 hover:enabled:tracking-widest disabled:cursor-not-allowed disabled:grayscale transition-all focus:brightness-75 uppercase"
                        data-sitekey="{{ config('services.recaptcha.site_key') }}"
                        data-callback='onSubmit'
                        data-action='store'>
                    <p class="absolute text-center w-full left-0">{{ __('barbofus.buttonValidate') }}</p>
                    <p class="opacity-0 tracking-widest">{{ __('barbofus.buttonValidate') }}</p>
                </button>

                {{-- Annuler --}}
                <button @click="openShareUI = false; $refs.btnShare.disabled = false;" type="button" class="relative px-5 py-3 text-lg font-normal text-primary bg-gradient-to-tr from-red-700 to-red-500 rounded-lg hover:brightness-110 hover:tracking-widest transition-all focus:brightness-75 uppercase">
                    <p class="absolute text-center w-full left-0">{{ __('barbofus.buttonCancel') }}</p>
                    <p class="opacity-0 tracking-widest">{{ __('barbofus.buttonCancel') }}</p>
                </button>

                <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const button = document.getElementById('myRecaptchaBtn');

                        button.addEventListener('click', function (e) {
                            e.preventDefault();

                            // Affiche le loader
                            const loader = document.getElementById('shareLoader');
                            if(loader) {
                                loader.classList.add('animate-customSpin');
                                loader.classList.remove('opacity-0');
                            }
                            const img = document.getElementById('previsu-img');
                            if(img) {
                                img.style.opacity = '0.5';
                            }

                            button.disabled = true;

                            grecaptcha.ready(function () {
                                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'store' }).then(function (token) {
                                    // Crée dynamiquement le champ hidden
                                    const form = document.getElementById('skinator-form');
                                    let input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'g-recaptcha-response';
                                    input.value = token;
                                    form.appendChild(input);

                                    window.generateFinalInputImage();
                                });
                            });
                        });
                    });
                </script>
            </div>
        </div>

        {{--    ITEMS ACTUELS    --}}
        <div class="flex space-x-4 my-2 h-24 overflow-auto"
             @click="if(event.target.closest('button[data-key]')) {
                const key = event.target.closest('button[data-key]').dataset.key;
                const id = items[key];

                if(key == 'mount')
                {
                    const harn = allItems.find(i => (i.dofus_id === items['pet'] && ['dragodinde', 'muldo', 'volkorne'].includes(i.pet_type)));
                    const mount = allItems.find(i => (i.dofus_id === items['mount'] ));

                    if(harn && mount)
                    {
                        const radio = document.querySelector(`input[type='radio'][data-id='${items['pet']}']`);
                        if (radio) radio.checked = false;
                        items['pet'] = null;
                    }
                }

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
                        <img loading="lazy" draggable="false" class="h-10 min-[1600px]:h-16" :src="'/storage/' + allItems.find(i => i.dofus_id === item).icon_path"
                             :alt="allItems.find(i => i.dofus_id === item).name">
                        <div class="flex items-end space-x-1 pt-4">
                            <img loading="lazy" draggable="false" width="24" height="24"
                                 class="h-6 w-6"
                                 :src="'/storage/images/icons/items/subcategories/' + allItems.find(i => i.dofus_id === item).subcategory + '.png'"
                                 :alt="allItems.find(i => i.dofus_id === item).subcategory">
                            <p x-text="'Lv.' + allItems.find(i => i.dofus_id === item).level" class="text-inactiveText whitespace-nowrap"></p>
                        </div>
                    </div>

                    <input type="text" :value="item" :name="key + '_id'" class="hidden">

                    <p x-text="allItems.find(i => i.dofus_id === item).name" class="text-left truncate"></p>

                    <div class="bg-black w-full h-full absolute top-0 left-0 opacity-0 group-hover:opacity-70 transition-all"></div>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                         class="h-6 w-6 text-red-500 absolute top-1 right-1 group-hover:h-20 group-hover:w-20 transition-all">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </template>
        </div>

        <div class="flex flex-col min-[700px]:flex-row max-[699px]:items-center">

            <div class="flex flex-col min-[1249px]:flex-row h-full">

                {{--      REGLAGES PERSONNAGE      --}}
                <div class="w-full min-[600px]:w-[max(min(20vw,25.5rem),23rem)]">

                    {{-- CHOIX ONGLET --}}
                    <div class="text-md min-[1600px]:text-xl h-12 font-thin flex justify-evenly"
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

                    <div x-cloak class="py-4 min-[600px]:px-4"
                         x-show="charactersCurrentTab === 'breed'">

                        {{--      Choix classe      --}}
                        <p class="text-xl text-center mb-1 font-light">{{ __('barbofus.labelSkinClass') }}</p>

                        <div class="flex flex-wrap gap-2 justify-center items-center"
                             @change="if (event.target.matches('input[type=radio]')) { shouldResetColors = checkIfDefaultColors(gender, breed, colors); breed = Number(event.target.value); editURLParam(getURLObject()); updateAlpineHead(); }">
                            <template x-for="breedInfo in breedInfos" :key="breedInfo.dofus_id">
                                <div>
                                    <input :id="'breed_' + breedInfo.dofus_id"
                                           type="radio"
                                           name="race_id"
                                           :value="breedInfo.dofus_id"
                                           class="hidden peer"
                                           :checked="breed === breedInfo.dofus_id">
                                    <label :for="'breed_' + breedInfo.dofus_id"
                                           :title="breed.name"
                                           class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(3.5vw,5rem),4rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                        <img loading="lazy" draggable="false" :src="'/storage/images/icons/classes/faces/unity/' + breedInfo.heads[gender === 0 ? 'male' : 'female'][0].assetId + '.png'"
                                             :alt="breed.name">
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-cloak class="py-4 min-[600px]:px-4"
                         x-show="charactersCurrentTab === 'head'">

                        {{--      Choix visage      --}}
                        <p class="text-xl text-center mb-1 font-light">{{ __('barbofus.labelSkinFace') }}</p>

                        <div class="flex flex-wrap gap-2 justify-center items-center"
                             @change="if (event.target.matches('input[type=radio]')) { head = Number(event.target.value); editURLParam(getURLObject()); }">
                            <template x-for="breedHead in breedHeads" :key="breedHead.id">
                                <div>
                                    <input :id="'head_' + breedHead.id"
                                           type="radio"
                                           name="face"
                                           :value="breedHead.id"
                                           class="hidden peer"
                                           :checked="head === breedHead.id">
                                    <label :for="'head_' + breedHead.id"
                                           :title="'{{ __('barbofus.contentFace') }} ' + (breedInfos.find(i => i.dofus_id === breed).name) + ' ' + breedHead.id"
                                           class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(3.5vw,5rem),4rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                        <img loading="lazy" draggable="false" :src="'/storage/images/icons/classes/faces/unity/' + breedHead.assetId + '.png'"
                                             :alt="'{{ __('barbofus.contentFace') }} ' + (breedInfos.find(i => i.dofus_id === breed).name) + ' ' + breedHead.id">
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-cloak id="color-tab" class="py-4 min-[600px]:px-4 relative"
                         x-show="charactersCurrentTab === 'color'">

                        {{--      Choix couleur      --}}
                        <div class="flex flex-wrap justify-evenly"
                             @click="if(event.target.closest('button[data-copy]')) { copyToClipboard(colors[event.target.closest('button[data-copy]').dataset.copy], 'hex' + event.target.closest('button[data-copy]').dataset.copy) }"
                             @change="editURLParam(getURLObject())"
                             @input="if(event.target.closest('input[data-color]')) { colors[event.target.closest('input[data-color]').dataset.color] = '#' + event.target.closest('input[data-color]').value.replace(/[^0-9a-fA-F]/g, '').slice(0, 6) }">
                            <template x-for="(color, index) in colors" :key="index">
                                <div :id="'color-' + index" class="my-3 hover:bg-primary-100 rounded-t-lg overflow-hidden transition-colors00">
                                    <button type="button"
                                            :data-copy="index"
                                            class="relative flex w-full py-1 px-2 justify-between items-center">
                                        <p x-text="colorsLabel[index] + ' :'" class="font-thin text-sm min-[600px]:text-lg truncate"></p>

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 fill-inactiveText">
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
                                               :name="'color_' + colorsName[index]"
                                               :data-color="index"
                                               class="uppercase order-last h-full peer rounded-r p-1 bg-primary-100 text-center w-[5.5rem] min-[600px]:w-28 focus:outline-none border-transparent focus:border-secondary border-y border-r transition-colors">

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
                                @click="colors = getDefaultColor(gender, breed); editURLParam(getURLObject()); window.resetDefaultColors()"
                                class="py-2 mt-4 flex items-center space-x-2 px-4 mx-auto rounded-md text-xl bg-primary-100 text-inactiveText uppercase hover:text-red-500 hover:rounded-3xl transition-all duration-75">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>

                            <p>Reset</p>
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{--      RESULTAT SKIN + ORIENTATION + EXPORT PNG + COPY LINK      --}}
                <div class="w-fit mx-auto px-4 h-fit max-[1240px]:order-first">

                    <style>
                        /* CSS REQUIC  */
                        .canvas-container {
                            position: relative;
                            display: inline-block;
                        }

                        .canvas-container.loading .canvas-renderer {
                            filter: blur(4px);
                        }

                        .loading-logo {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            width: 75%;
                            height: 75%;
                            pointer-events: none;
                        }
                    </style>

                    {{-- Skin --}}
                    <div class="relative inline-block">
                        <canvas @click="animated = !animated; " class="canvas-renderer cursor-pointer" title="Cliquez pour activer/désactiver l'animation" x-ref="canvas" id="canvas0" width="300px" height="500px"></canvas>
                        <svg class="loading-logo" style="display: none;" viewBox="0 0 66.410408 67.468735" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="progress-gradient" x1="0" y1="1" x2="0" y2="0">
                                    <stop offset="0%" stop-color="#fba436" />
                                    <stop offset="50%" stop-color="#faed61" />
                                    <stop offset="50%" stop-color="#fff5e9" />
                                    <stop offset="100%" stop-color="#f2e8dc" />
                                </linearGradient>
                            </defs>
                            <g
                                width="120px"
                                height="120px"
                                id="layer1"
                                transform="translate(-57.924089,-154.32008)">
                                <path
                                    style="fill:url(#progress-gradient);stroke:none;stroke-width:0.264583"
                                    d="m 61.628256,154.32008 c -1.322096,1.86955 -1.590754,3.58452 -1.058333,5.82083 l -2.645833,-0.52917 2.910416,5.02709 -2.910416,-0.79375 c 0.761182,5.88925 6.723168,11.10844 12.699999,10.83748 2.45028,-0.11107 4.340675,-1.45116 6.614583,-2.10624 l -1.5875,2.91042 c 5.3036,0 12.50818,-1.69172 14.81667,-7.14375 1.55257,0.75655 2.61276,2.40395 3.96875,3.49041 3.34909,2.68356 7.586918,4.41709 11.906248,3.38876 l -1.5875,-2.91042 c 7.96872,4.19896 17.21484,-0.40296 19.57916,-8.73125 l -3.175,0.52917 c 1.46394,-1.47725 2.59292,-3.00628 3.175,-5.02708 l -2.91042,1.05833 c 0.40349,-2.17331 0.60378,-4.36605 -1.32291,-5.82083 -1.42372,4.33834 -4.95538,5.84731 -9.26042,5.17937 -4.76911,-0.73998 -9.16305,-2.55677 -14.022908,-2.53333 -2.14895,0.0104 -4.20026,1.79644 -6.08542,1.70529 -1.05913,-0.0512 -2.1381,-0.92315 -3.175,-1.19634 -1.579298,-0.41603 -3.405452,-0.30779 -5.027083,-0.23415 -5.961539,0.27061 -12.953497,5.40988 -18.510223,0.90786 -1.345009,-1.08974 -1.482884,-2.52272 -2.39186,-3.8287 m 12.7,21.16666 c -4.916937,0.66212 -7.310464,0.35057 -11.641666,-2.11667 -3.294859,5.79528 -0.982478,12.15258 2.116666,17.4625 h 0.264584 l 0.264583,-2.91041 h 0.264583 c 0.941388,3.31602 2.901712,6.50081 5.291667,8.99583 l 0.264583,-0.79375 h 0.264583 l 2.645833,6.87916 h 0.264584 v -1.85208 h 0.264583 c 1.741911,3.35783 5.285793,4.13306 7.881144,6.48997 3.619239,3.28691 6.585479,9.50489 7.729269,14.14753 3.37238,-2.55852 5.51207,-6.30396 7.33981,-10.05417 0.71623,-1.47002 1.04907,-3.43905 2.09232,-4.70614 1.329008,-1.61422 3.777198,-2.70325 5.384538,-4.10157 2.65059,-2.30637 4.2971,-5.00565 5.82083,-8.12562 l 1.5875,2.38125 0.26459,-4.49792 1.32291,0.26459 c 1.49278,-5.10911 4.49792,-9.00721 4.49792,-14.55208 l 0.79375,0.52916 0.26458,-6.08541 c -4.03225,1.87372 -7.22471,2.46522 -11.64166,2.11666 -2.22409,4.62756 -10.755048,0.61701 -13.493748,-1.50278 -0.90409,-0.6999 -2.20478,-2.64749 -3.41498,-2.67972 -1.00965,-0.0269 -2.41009,1.97524 -3.19987,2.55293 -2.878933,2.10598 -6.040836,2.99371 -9.524736,3.40612 -1.372606,0.16248 -3.456358,0.34012 -3.96875,-1.24738 z"
                                />
                            </g>

                        </svg>
                    </div>

                    {{-- Zone sous skins / Orientation / Animation --}}
                    <div class="flex justify-evenly items-center space-x-8 w-fit mx-auto">
                        <button type="button" class="group" @click="orientationKey++; if(orientationKey >= possibleOrientation[animation].length) orientationKey = 0">
                            <img loading="lazy" src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 h-14 group-active:translate-y-0 group-active:scale-90 transition-all">
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

                                <svg x-cloak x-show="animation === 'Combat'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Sword-Attack--Streamline-Sharp" class="size-4 -scale-x-100"><desc>Sword Attack Streamline Icon: https://streamlinehq.com</desc><g id="sword-attack--entertainment-gaming-sword-attack"><path id="Union" fill="#000000" fill-rule="evenodd" d="M6.67488 1.37109h-5.3033v5.3033L12.4699 17.7727l5.3033 -5.3033L6.67488 1.37109ZM21.4854 13.7068l-2.4751 2.4751 3.9895 3.9894 0 2.8285 -2.8285 0 -3.9894 -3.9895 -2.4747 2.4747 -1.4142 -1.4142 7.7781 -7.7782 1.4143 1.4142Z" clip-rule="evenodd" stroke-width="1"></path></g></svg>
                            </div>
                        </button>

                        <button type="button" class="group" @click="orientationKey--; if(orientationKey < 0) orientationKey = possibleOrientation[animation].length - 1">
                            <img loading="lazy" src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}" class="group-hover:-translate-y-1 h-14 -scale-x-100 group-active:translate-y-0 group-active:scale-y-90 group-active:-scale-x-90 transition-all">
                        </button>
                    </div>

                    {{-- Bouton d'export --}}
                    <div class="relative w-full mx-auto mb-2">

                        <div class="flex justify-between">
                            {{-- Bouton DL Anim --}}
                            <button type="button"
                                    id="btnExportAnim"
                                    title="Telechargement image animé"
                                    class="p-2 bg-primary-100 rounded-lg border-2 border-transparent hover:bg-primary hover:border-secondary transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </button>

                            {{-- Bouton Copier --}}
                            <button type="button"
                                    id="btnCopyImg"
                                    title="Copie image"
                                    @click="copyToClipboard('test', 'finalSkin')"
                                    :class="copy === 'finalSkin' ? 'bg-secondary text-primary' : 'bg-primary-100 hover:bg-primary hover:border-secondary'"
                                    class="p-2 rounded-lg border-2 border-transparent transition-all">
                                <svg x-cloak x-show="copy != 'finalSkin'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                </svg>
                                <p x-cloak x-show="copy === 'finalSkin'">{{ __('barbofus.contentCopied') }}</p>
                            </button>

                            {{-- Bouton DL --}}
                            <button type="button"
                                    id="btnExport"
                                    title="Telechargement image"
                                    class="p-2 bg-primary-100 rounded-lg border-2 border-transparent hover:bg-primary hover:border-secondary transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                </svg>

                            </button>
                        </div>
                    </div>

                    {{-- Boutons copy link + Export PNG --}}
                    <div class="flex w-fit mx-auto justify-evenly space-x-2 min-[600px]:space-x-8">

                        {{-- Bouton Copy link --}}
                        <div class="w-full flex justify-end">
                            <button type="button"
                                    @click="copyToClipboard(window.location.href, 'url')"
                                    x-text="copy === 'url' ? '{{ __('barbofus.contentCopied') }}' : '{{ __('barbofus.contentCopy') }} URL'"
                                    :class="copy === 'url' ? 'bg-secondary text-primary' : 'bg-primary-100 hover:bg-primary hover:border-secondary'"
                                    class="px-4 py-2 rounded-lg border-2 border-transparent transition-all">
                            </button>
                        </div>

                        {{-- Bouton Partager --}}
                        <div class="w-full flex justify-start">
                            <button disabled
                                    x-ref="btnShare"
                                    type="button"
                                    id="btnShare"
                                    class="g-recaptcha relative px-5 min-[600px]:px-8 py-3 text-lg font-normal text-primary goldGradient rounded-lg hover:enabled:brightness-110 hover:enabled:tracking-widest disabled:cursor-not-allowed disabled:grayscale transition-all focus:brightness-75 uppercase"
                                    @click="openShareUI = true; $refs.btnShare.disabled = true;">
                                <p class="absolute text-center w-full left-0">{{ (str_ends_with(Route::currentRouteName(), 'edit')) ? __('barbofus.buttonModify') : __('barbofus.buttonShare') }}</p>
                                <p class="opacity-0 tracking-widest">{{ (str_ends_with(Route::currentRouteName(), 'edit')) ? __('barbofus.buttonModify') : __('barbofus.buttonShare') }}</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{--      TOUS LES ITEMS      --}}
            <div class="flex-1 flex flex-col h-full">

                {{-- CHOIX ONGLET --}}
                <div class="text-md min-[1600px]:text-xl h-fit font-thin flex flex-wrap gap-y-2 justify-evenly"
                     @click="if(event.target.closest('button[data-tab]')) { itemsCurrentTab = event.target.closest('button[data-tab]').dataset.tab; maxItemVisible = 96; if(searchBar != '') { searchBar = ''; updateFilteredItems(); } }">

                    @foreach($itemCategories as $category)
                        <button type="button"
                                data-tab="{{ $category }}"
                                class="px-2 flex-grow uppercase truncate"
                                :class="(itemsCurrentTab === '{{ $category }}') ? 'font-medium border-b-4 border-secondary' : 'border-b-2 border-inactiveText'">{{ __('barbofus.content' . ucfirst($category)) }}</button>
                    @endforeach
                </div>

                {{-- Barre de recherche --}}
                <div class="min-[950px]:flex h-fit my-2 min-[950px]:space-x-2">
                    <div class="relative flex items-center space-x-2 h-full w-[16rem] bg-primary-100 rounded-md py-2">
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

                    {{-- CHOIX ONGLET FAMILIER --}}
                    <div x-show="itemsCurrentTab === 'pet'" x-transition
                         class="h-10 font-thin flex space-x-2 mt-2 min-[950px]:mt-0"
                         @click="if(event.target.closest('button[data-tab]')) { petCurrentTab = event.target.closest('button[data-tab]').dataset.tab; maxItemVisible = 96; if(searchBar != '') { searchBar = ''; updateFilteredItems(); } }">

                        <button type="button" x-cloak
                                data-tab="familier"
                                class="h-full border-2 rounded-md bg-primary-100 hover:border-secondary transition-all"
                                :class="(petCurrentTab === 'familier') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'familier') ? 'opacity-100' : 'opacity-60'" class="h-full transition-all" src="{{ asset('storage/images/icons/mounts/familiar.png') }}" alt="Familier">
                        </button>

                        <button type="button" x-cloak
                                data-tab="montilier"
                                class="h-full border-2 rounded-md bg-primary-100 hover:border-secondary transition-all"
                                :class="(petCurrentTab === 'montilier') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'montilier') ? 'opacity-100' : 'opacity-60'" class="h-full transition-all" src="{{ asset('storage/images/icons/mounts/petsmount.png') }}" alt="Montilier">
                        </button>

                        <button type="button" x-cloak
                                data-tab="dragodinde"
                                class="h-full border-2 rounded-md bg-primary-100 hover:border-secondary transition-all"
                                :class="(petCurrentTab === 'dragodinde') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'dragodinde') ? 'opacity-100' : 'opacity-60'" class="h-full transition-all" src="{{ asset('storage/images/icons/mounts/dragoturkey.png') }}" alt="Dragodinde">
                        </button>

                        <button type="button" x-cloak
                                data-tab="muldo"
                                class="h-full border-2 rounded-md bg-primary-100 hover:border-secondary transition-all"
                                :class="(petCurrentTab === 'muldo') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'muldo') ? 'opacity-100' : 'opacity-60'" class="h-full transition-all" src="{{ asset('storage/images/icons/mounts/seemyool.png') }}" alt="Muldo">
                        </button>

                        <button type="button" x-cloak
                                data-tab="volkorne"
                                class="h-full border-2 rounded-md bg-primary-100 hover:border-secondary transition-all"
                                :class="(petCurrentTab === 'volkorne') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'volkorne') ? 'opacity-100' : 'opacity-60'" class="h-full transition-all" src="{{ asset('storage/images/icons/mounts/rhineetle.png') }}" alt="Volkorne">
                        </button>
                    </div>
                </div>

                {{-- Liste des items --}}
                <div class="overflow-auto flex flex-wrap gap-2 justify-left max-h-[25rem] min-[700px]:max-h-[60rem] min-[1249px]:max-h-[32rem]"
                     @change="if (event.target.matches('input[type=radio]'))
                     {
                        items[event.target.dataset.category] = Number(event.target.dataset.id);

                        if(items['pet']) {
                            const harn = allItems.find(i => (i.dofus_id === items['pet'] && ['dragodinde', 'muldo', 'volkorne'].includes(i.pet_type)));
                            const mount = allItems.find(i => (i.dofus_id === items['mount'] ));

                            if(event.target.dataset.category == 'pet')
                            {
                                if(harn != null && mount == null || harn != null && mount.pet_type != harn.pet_type)
                                {
                                    const id = {
                                        dragodinde: 1,
                                        muldo: 2,
                                        volkorne: 3,
                                    }
                                    items['mount'] = id[harn.pet_type];
                                }
                            }


                            if(event.target.dataset.category == 'pet' && harn == null && items['mount'] != null)
                            {
                                const id = items['mount'];
                                const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                                if (radio) radio.checked = false;

                                items['mount'] = null;
                            }

                            if(event.target.dataset.category == 'mount' && harn == null && items['pet'] != null)
                            {
                                const id = items['pet'];
                                const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                                if (radio) radio.checked = false;

                                items['pet'] = null;
                            }

                            if(event.target.dataset.category == 'mount' && harn)
                            {
                                if(harn.pet_type != mount.pet_type)
                                {
                                    const id = items['pet'];
                                    const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                                    if (radio) radio.checked = false;

                                    items['pet'] = null;
                                }
                            }
                        }

                        editURLParam(getURLObject());
                     }">

                    <template x-for="(allItem, index) in (
                              searchBar.length >= 3
                                ? filteredItems
                                : filteredItems.filter(i =>
                                    i.category === itemsCurrentTab &&
                                    (i.pet_type === petCurrentTab || i.pet_type === null)
                                  )
                            ).slice(0, maxItemVisible)"
                              :key="allItem.dofus_id">
                        <div class="h-fit">
                            <input :id="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem.subcategory == 'mimisymbic') ? 'mount' : allItem.category) + '_' + allItem.dofus_id"
                                   :data-category="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem.subcategory == 'mimisymbic') ? 'mount' : allItem.category)"
                                   :data-id="allItem.dofus_id"
                                   type="radio"
                                   :name="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem.subcategory == 'mimisymbic') ? 'mount' : allItem.category)"
                                   :value="allItem.dofus_id"
                                   class="hidden peer"
                                   :checked="items[((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem.subcategory == 'mimisymbic') ? 'mount' : allItem.category)] === allItem.dofus_id">
                            <label :for="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem.subcategory == 'mimisymbic') ? 'mount' : allItem.category) + '_' + allItem.dofus_id"
                                   :title="allItem.name"
                                   class="transition-all overflow-hidden relative rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(4vw,5rem),3.8rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText"
                                   x-data="{ loaded: false, intersected: false }">

                                <div :class="allItem.subcategory != 'mimisymbic' ? 'visible' : 'invisible'" class="h-4 w-4 goldGradientTop absolute -top-2 -left-2 rotate-45"></div>

                                <img src="{{ asset('storage/images/misc_ui/colorable_items_icon.png') }}" alt="Colorable item"
                                     :class="(allItem.colorable === 1 && loaded && intersected) ? 'visible' : 'invisible'"
                                     class="h-6 w-6 absolute top-1 right-1">

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
                                     height="64"
                                     width="64"
                                     :src="'/storage/' + allItem.icon_path"
                                     :alt="allItem.name"
                                     class="mt-0 transition-opacity delay-100 duration-300 relative z-10"
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
        // Masquer les query params comme ?skin=123 après chargement
        if (window.location.search.includes('skin=')) {
            const url = new URL(window.location);
            url.searchParams.delete('skin');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }


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
                rendererOrientation: {
                    /*'Static': [1,2,1,0,5,6,5,0],
                    'Combat': [1,1,5,5],
                    'Monture': [1,2,1,0,5,6,5,0],*/
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
                colorsName: [
                    'skin',
                    'hair',
                    'cloth_1',
                    'cloth_2',
                    'cloth_3',
                    'cloth_4',
                ],
                shouldResetColors: false,
                charactersCurrentTab: 'breed',
                itemsCurrentTab: 'hat',
                petCurrentTab: 'familier',
                oldGender: 0,
                oldBreed: 1,
                gender: @json($skin ? $skin->gender : 0),
                breed: @json($skin ? $skin->race_id : 1),
                head: @json($skin?->face),
                colors: {!! json_encode($skin ? [
                    '#' . ltrim((string) $skin?->color_skin, '#'),
                    '#' . ltrim((string) $skin?->color_hair, '#'),
                    '#' . ltrim((string) $skin?->color_cloth_1, '#'),
                    '#' . ltrim((string) $skin?->color_cloth_2, '#'),
                    '#' . ltrim((string) $skin?->color_cloth_3, '#'),
                    '#' . ltrim((string) $skin?->color_cloth_4, '#'),
                ] : []) !!},
                animation: 'Static',
                animated: true,
                cameleon: false,
                items: {
                    hat: @json($skin?->hat_id),
                    cape: @json($skin?->cape_id),
                    shield: @json($skin?->shield_id),
                    pet: @json($skin?->pet_id),
                    shoulderpads: @json($skin?->shoulderpads_id),
                    wings: @json($skin?->wings_id),
                    costume: @json($skin?->costume_id),
                    mount: @json($skin?->mount_id),
                },
                previousData: '',
                previousInvertX: '',
                openShareUI: false,

                initWatcher() {
                    Alpine.effect(() => {
                        const data = this.getRendererObject();
                        const invertX = [3,4,7].includes(this.possibleOrientation[this.animation][this.orientationKey]);

                        if (data !== this.previousData || invertX !== this.previousInvertX) {
                            this.previousData = data;
                            this.previousInvertX = invertX;

                            let interval = setInterval(() => {
                                if (window.updateRendererData) {
                                    window.updateRendererData(data, invertX);
                                    clearInterval(interval);
                                }
                            }, 50);
                        }
                    });
                },

                init()
                {
                    if(this.head == null) {
                        this.head = this.updateHead(this.gender, this.breed);
                    }
                    this.breedHeads = this.updateHeads(this.gender, this.breed);
                    this.updateFilteredItems();

                    if(getDataFromURL()) {
                        this.getAlpineDataFromURL(getDataFromURL())
                    }
                    else
                    {
                        if(this.colors.length == 0) {
                            this.colors = this.getDefaultColor(this.gender, this.breed);
                        }
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
                        head: this.head,
                        orientation: this.rendererOrientation[this.animation][this.orientationKey],
                        animation: this.animation,
                        items: Object.entries(this.items)
                            .map(([key, value]) => {
                                if (!value) return null;
                                if (key === 'mount') return null;

                                return this.items[key];
                            })
                            .filter(Boolean),
                        mount: this.items.mount ? this.allItems.find(i => i.dofus_id === this.items.mount).asset_id : null,
                        cameleon: this.items.mount ? ([1, 2, 3].includes(this.items.mount)) : false,
                        animated: this.animated
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
        const mapKeys = { gender: "1", breed: "2", head: "3", colors: "4", items: "5", hat: "6", cape: "7", shield: "8", pet: "9", costume: "10", shoulderpads: "11", wings: "12", mount: "13" };

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

    <!-- Extration des données -->
    <script src="//cdn.jsdelivr.net/npm/protobufjs@7.4.0/dist/protobuf.min.js"></script>

    <script async type="module">

        //import { FFmpeg } from './@ffmpeg/ffmpeg/dist/esm/index.js';
        import { FFmpeg } from '/storage/package/@ffmpeg/ffmpeg/dist/esm/index.js';


        class SkinRenderer {

            static skinRendererProto = null
            static async decodeData (data) {
                if (!SkinRenderer.skinRendererProto) {
                    const root = await protobuf.load('/storage/proto/skin.proto')
                    SkinRenderer.skinRendererProto = root.lookupType("SkinRenderer")
                }
                return SkinRenderer.skinRendererProto.decode(new Uint8Array(data))
            }

            static GetSourceVertexShader () {
                return `
          precision mediump float;
          attribute vec2 position;
          attribute vec2 texCoord;
          uniform float u_invertX;
          varying vec2 vTexCoord;

          void main() {
            gl_Position = vec4(position.x * u_invertX, position.y, 0.0, 1.0);
            vTexCoord = texCoord;
          }`
            }

            static GetSourceFragmentShader () {
                return `
          precision mediump float;

          varying vec2 vTexCoord;
          uniform sampler2D u_texture;
          uniform vec3 u_mainColor;
          uniform float u_Opacity;

          void main() {
            vec4 texColor = texture2D(u_texture, vec2(vTexCoord.s, 1.0 - vTexCoord.t));
            texColor.rgb *= u_mainColor.rgb;
            texColor.rgb *= (texColor.a * u_Opacity);
            texColor.a *= u_Opacity;
            gl_FragColor = texColor;
          }
        `
            }


            constructor ($canvas) {
                this.$canvas = $canvas
                this.$parent = $canvas.parentElement
                this.$svgLogo = this.$parent.querySelector('.loading-logo')
                this.$progressGradient = this.$svgLogo.querySelector('#progress-gradient')
                this.gl = this.$canvas.getContext('webgl2', {
                    alpha: true,
                    antialias: true,
                    depth: false,
                    preserveDrawingBuffer: true ,
                    premultipliedAlpha: false,
                    stencil: false
                })


                if (!this.gl) {
                    throw new Error('WebGL not supported')
                }

                this.__init = false
                this.__running = false

                // Animation
                this.indexFrame = 0
                this.lastTime = 0

                this.rendererData = null

                this.data = null

                this.colors = [0xe59b68, 0x773f29, 0xd8742e, 0x496352, 0x512a15, 0x5b5243]
                this.indexFocusColor = null

                // OpenGL
                this.program = null
                this.uMainColor = null
                this.uOpacity = null
                this.uInvertX = null
                this.positionsBuffer = null
                this.uvsBuffer = null
                this.indicesBuffer = null
                this.textures = []



            }


            async setData (data, invX = false) {

                if (!this.__init) {
                    await this.InitGL()
                    document.getElementById('btnShare').disabled = false
                    this.__init = true
                }

                this.__running = false
                const _data = await SkinRenderer.decodeData(data)
                this.gl.uniform1f(this.uInvertX, invX ? -1 : 1)

                console.log(this.data)

                const textures = []
                for (const texture of _data.textures) {
                    textures.push(await this.loadTexture(texture))
                }
                this.unloadTextures()
                this.data = _data
                this.textures = textures
                this.__updateViewport()
                this.start()
            }

            // ======================================================================
            // ==== Gestion de l'animation ====
            // ======================================================================
            __animate (currentTime) {
                if (!this.__running) return
                requestAnimationFrame(this.__animate.bind(this))
                const interval = 1000 / 30; // 30 FPS
                const delta = currentTime - this.lastTime
                if (delta >= interval) {
                    this.lastTime = currentTime - (delta % interval)
                    this.draw()
                    this.indexFrame += 1
                }
            }

            start () {
                if (!this.data) return
                this.indexFrame = 0
                this.lastTime = 0
                this.__running = true
                this.draw()
                requestAnimationFrame(this.__animate.bind(this))
            }

            stop () {
                this.__running = false
                this.unloadTextures()
            }

            // ======================================================================
            // ==== Export de l'animation ====
            // ======================================================================
            async downloadAnimation () {
                return new Promise(async (resolve, reject) => {
                    this.setProgress(0)
                    this.setLoading(true)
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 1080
                    this.$canvas.height = 1080
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()



                    const ffmpeg = new FFmpeg({ log: false });
                    await ffmpeg.load()


                    const maxFrames = this.data.frames.length
                    const frames = []
                    for (let i = 0; i < maxFrames; i++) {
                        this.indexFrame = i
                        this.draw()
                        const frame = this.$canvas.toDataURL('image/webp', 1.0)
                        const response = await fetch(frame);
                        const arrayBuffer = await response.arrayBuffer();
                        await ffmpeg.writeFile(`frame${String(i).padStart(3, '0')}.webp`, new Uint8Array(arrayBuffer))
                        this.setProgress((i + 1) / maxFrames * 0.75)
                    }

                    let fakeProgress = 0.75
                    const fakeProgressStep = 0.25 / (maxFrames / 4)
                    ffmpeg.on('progress', ({ progress, time }) => {
                        fakeProgress = Math.min(fakeProgress + fakeProgressStep, 1)
                        this.setProgress(fakeProgress)
                    });

                    await ffmpeg.exec([
                        '-framerate', '30',                  // 30 fps
                        '-i', 'frame%03d.webp',               // frame000.webp, frame001.webp, etc.
                        '-loop', '0',                         // boucle infinie
                        '-c:v', 'libwebp_anim',               // encoder en WebP animé
                        '-quality', '100',                 // Meilleure qualité pour l'export (100%)
                        'out.webp'                            // sortie
                    ])
                    const data = await ffmpeg.readFile('out.webp');
                    const blob = new Blob([data], { type: 'video/webm' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'skin.webp';
                    a.click();
                    URL.revokeObjectURL(url);

                    this.$canvas.width = originalWidth
                    this.$canvas.height = originalHeight

                    this.$canvas.style.width = 'initial'
                    this.$canvas.style.height = 'initial'

                    this.__updateViewport()

                    this.setProgress(0)
                    this.setLoading(false)
                    this.start()
                })
            }

            async downloadImage () {
                return new Promise(async (resolve, reject) => {
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 1080
                    this.$canvas.height = 1080
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()


                    this.draw()
                    const url = this.$canvas.toDataURL('image/png')
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'skin.png';
                    a.click();
                    URL.revokeObjectURL(url);

                    this.$canvas.width = originalWidth
                    this.$canvas.height = originalHeight

                    this.$canvas.style.width = 'initial'
                    this.$canvas.style.height = 'initial'

                    this.__updateViewport()

                    this.start()
                })

            }

            async copyImage () {
                return new Promise(async (resolve, reject) => {
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 1080
                    this.$canvas.height = 1080
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()


                    this.draw()
                    const url = this.$canvas.toDataURL('image/png');


                    this.$canvas.width = originalWidth
                    this.$canvas.height = originalHeight

                    this.$canvas.style.width = 'initial'
                    this.$canvas.style.height = 'initial'

                    this.__updateViewport()

                    this.start()

                    const blob = await (await fetch(url)).blob();
                    const item = new ClipboardItem({ 'image/png': blob });
                    await navigator.clipboard.write([item]);
                })

            }

            async showSharePrevImage () {
                return new Promise(async (resolve, reject) => {
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 300
                    this.$canvas.height = 500
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()


                    this.draw()
                    const url = this.$canvas.toDataURL('image/png');


                    this.$canvas.width = originalWidth
                    this.$canvas.height = originalHeight

                    this.$canvas.style.width = 'initial'
                    this.$canvas.style.height = 'initial'

                    this.__updateViewport()

                    this.start()

                    // 🔄 Insertion de l'image dans l'élément <img>
                    const img = document.getElementById('previsu-img');
                    if (img) {
                        img.src = url;
                        img.style.opacity = '1'; // ou applique une animation si souhaité
                    }

                    resolve(); // N'oublie pas de résoudre la promesse
                })

            }

            async fillShareInputImage () {
                this.__running = false

                const originalWidth = this.$canvas.width
                const originalHeight = this.$canvas.height

                this.$canvas.width = 300
                this.$canvas.height = 500
                this.$canvas.style.width = originalWidth + 'px'
                this.$canvas.style.height = originalHeight + 'px'
                this.__updateViewport()


                this.draw()
                const url = this.$canvas.toDataURL('image/png');


                this.$canvas.width = originalWidth
                this.$canvas.height = originalHeight

                this.$canvas.style.width = 'initial'
                this.$canvas.style.height = 'initial'

                this.__updateViewport()

                this.start()

                return url;
            }

            // ======================================================================
            // ==== Gestion des couleurs ====
            // ======================================================================
            static GetAlternativeColor (r,g, b) {
                return (r > 0.4 && r < 0.6 && g > 0.4 && g < 0.6 && b > 0.4 && b < 0.6)
                    ? [1, 0, 1]
                    : [1 - r, 1 - g, 1 - b]
            }
            setColors (colors) {
                this.colors = colors
            }
            setColorIndex (index, color) {
                this.colors[index] = color
            }
            setColorFocusIndex (index) {
                this.indexFocusColor = index
            }

            // ======================================================================
            // ==== Gestion des textures ====
            // ======================================================================
            async unloadTextures() {
                for (const texture of this.textures) {
                    this.gl.deleteTexture(texture);
                }
                this.textures = []
            }
            async loadTexture(url) {

                const gl = this.gl
                const image = await new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.onerror = (err) => reject(new Error(`Erreur de chargement de l'image: ${url}`));
                    img.src = '/storage/images/skinator/' + url;
                });

                const texture = gl.createTexture();
                gl.bindTexture(gl.TEXTURE_2D, texture);
                gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
                gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
                gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image);
                gl.generateMipmap(gl.TEXTURE_2D);

                return texture;
            }

            // ======================================================================
            // ==== Gestion OpenGL ====
            // ======================================================================
            async InitGL() {
                const gl = this.gl
                gl.viewport(0, 0, this.$canvas.width, this.$canvas.height);


                const vertexShaderSource = SkinRenderer.GetSourceVertexShader();
                const fragmentShaderSource = SkinRenderer.GetSourceFragmentShader();

                const vertexShader = gl.createShader(gl.VERTEX_SHADER);
                gl.shaderSource(vertexShader, vertexShaderSource);
                gl.compileShader(vertexShader);

                const fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
                gl.shaderSource(fragmentShader, fragmentShaderSource);
                gl.compileShader(fragmentShader);

                const program = gl.createProgram();
                gl.attachShader(program, vertexShader);
                gl.attachShader(program, fragmentShader);
                gl.linkProgram(program);
                gl.useProgram(program);


                const uMainColor = gl.getUniformLocation(program, 'u_mainColor')
                const uOpacity = gl.getUniformLocation(program, 'u_Opacity')
                const uInvertX = gl.getUniformLocation(program, 'u_invertX')

                gl.uniform1f(uOpacity, 1.0)


                const positionsBuffer = gl.createBuffer();
                const uvsBuffer = gl.createBuffer();
                const indicesBuffer = gl.createBuffer();

                gl.enable(gl.BLEND);
                gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);

                this.program = program
                this.uMainColor = uMainColor
                this.uOpacity = uOpacity
                this.uInvertX = uInvertX
                this.positionsBuffer = positionsBuffer
                this.uvsBuffer = uvsBuffer
                this.indicesBuffer = indicesBuffer
            }
            draw () {
                const gl = this.gl
                const data = this.data
                const program = this.program
                const uMainColor = this.uMainColor
                const uOpacity = this.uOpacity
                const positionsBuffer = this.positionsBuffer
                const uvsBuffer = this.uvsBuffer
                const indicesBuffer = this.indicesBuffer

                if (!data) return
                gl.clearColor(0, 0, 0, 0);
                gl.clear(gl.COLOR_BUFFER_BIT);

                const lColor = [...this.colors]
                for (let i = 0; i < lColor.length; i++) {
                    const color = lColor[i]
                    const r = ((color >> 16) & 0xFF) / 255;
                    const g = ((color >> 8) & 0xFF) / 255;
                    const b = (color & 0xFF) / 255;
                    if (this.indexFocusColor === i && ((this.indexFrame >> 3) & 1)) {
                        if (((this.indexFrame >> 3) & 1) ) {
                            lColor[i] = SkinRenderer.GetAlternativeColor(r, g, b)
                        } else {
                            lColor[i] = [ r, g, b]
                        }

                    } else {
                        lColor[i] = [r, g, b]
                    }
                }

                const frames0 = data.frames[this.indexFrame % data.frames.length].frame;

                for (const part of frames0) {

                    let customColor = null
                    if (part.colorIndex !== null && part.colorIndex !== -1) {
                        customColor = lColor[part.colorIndex] ?? [1, 1, 1]
                    } else if (part.color !== null) {

                        customColor = [
                            ((part.color >> 16) & 0xFF) / 255,
                            ((part.color >> 8) & 0xFF) / 255,
                            (part.color & 0xFF) / 255
                        ]
                    }


                    if (customColor) {
                        // const additiveColor = part.additiveColor ?? 0x7F7F7F7F
                        const multiplicativeColor = part.multiplicativeColor ?? 0xFEFEFEFE
                        const mr = ((multiplicativeColor >> 16) & 0xFF) / 0x7F;
                        const mg = ((multiplicativeColor >> 8) & 0xFF) / 0x7F;
                        const mb = (multiplicativeColor & 0xFF) / 0x7F;
                        gl.uniform3fv(uMainColor, [mr * customColor[0], mg * customColor[1], mb * customColor[2]]);
                    } else {
                        gl.uniform3fv(uMainColor, [1, 1, 1]);
                    }

                    gl.uniform1f(uOpacity, part.alpha ?? 1.0)

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
                    gl.vertexAttribPointer(positionAttribLocation, 2, gl.FLOAT, false, 0, 0);

                    const texCoordAttribLocation = gl.getAttribLocation(program, 'texCoord');
                    gl.bindBuffer(gl.ARRAY_BUFFER, uvsBuffer);
                    gl.enableVertexAttribArray(texCoordAttribLocation);
                    gl.vertexAttribPointer(texCoordAttribLocation, 2, gl.FLOAT, false, 0, 0);

                    gl.activeTexture(gl.TEXTURE0);
                    gl.bindTexture(gl.TEXTURE_2D, this.textures[part.textureIndex]);
                    const textureLocation = gl.getUniformLocation(program, 'u_texture');
                    gl.uniform1i(textureLocation, 0);

                    gl.drawElements(gl.TRIANGLES, indices.length, gl.UNSIGNED_SHORT, 0 );
                }
            }

            // ======================================================================
            // ==== Autre / Loader / Ratio Viewport ====
            // ======================================================================
            async setLoading (loading) {
                if (loading) {
                    this.$parent.classList.add('loading')
                    this.$svgLogo.style.display = 'block'
                } else {
                    this.$parent.classList.remove('loading')
                    this.$svgLogo.style.display = 'none'
                }
            }
            async setProgress (progress) {
                const stops = this.$progressGradient.querySelectorAll('stop')
                stops[1].setAttribute('offset', `${progress * 100}%`)
                stops[2].setAttribute('offset', `${progress * 100}%`)
            }
            async __updateViewport () {
                const gl = this.gl
                const {maxX, maxY, minX, minY} = this.data.bounds
                const height = this.$canvas.height
                const width = this.$canvas.width
                let ratio = width / height

                console.log({ maxX, ratio})

                if (ratio < 1) {
                    if (maxX < ratio) {
                        const offsetX = (height - width) / 2
                        gl.viewport(-offsetX, 0, height, height);
                    } else if (maxX > ratio) {
                        const size = width / maxX
                        const offsetX = (width - size) / 2
                        const offsetY = (height - size) / 2
                        gl.viewport(offsetX, offsetY, size, size);
                    }
                } else if (ratio > 1) {
                    ratio = 1 / ratio
                    if (maxY < ratio) {
                        const offsetY = (width - height) / 2
                        gl.viewport(0, -offsetY, width, width);
                    } else if (maxY > ratio) {
                        const size = height / maxY
                        const offsetX = (width - size) / 2
                        const offsetY = (height - size) / 2
                        gl.viewport(offsetX, offsetY, size, size);
                    }
                } else {
                    gl.viewport(0, 0, this.$canvas.width, this.$canvas.height);
                }
            }

        }


















        // ======================================================================
        // ==== Exemple Button d'export  ====
        // ======================================================================
        const skinRenderer = new SkinRenderer(document.querySelector('#canvas0'))

        const urlData = window.getDataFromURL();
        skinRenderer.setColors(urlData.colors)

        window.resetColors = function () {
            const urlData = window.getDataFromURL();
            skinRenderer.stop()
            skinRenderer.setColors(urlData.colors)
        };

        window.resetDefaultColors = function () {
            const urlData = window.getDataFromURL();
            skinRenderer.setColors(urlData.colors)
        };

        window.updateRendererData = function (data, invX) {
            console.log(data);

            UpdateRenderer(data, invX)
        };


        let currentController = null;

        async function UpdateRenderer(data, invX) {
            // Si une requête précédente existe, on l'annule
            if (currentController) {
                currentController.abort();
            }

            // Nouveau controller pour la nouvelle requête
            currentController = new AbortController();

            try {
                const response = await fetch('http://62.241.115.223:9461/renderer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: data,
                    signal: currentController.signal // on passe le signal ici
                });


                skinRenderer.rendererData = data;
                const buffer = await response.arrayBuffer();
                await skinRenderer.setData(buffer, invX);
            } catch (error) {
                if (error.name === 'AbortError') {
                    // La requête a été annulée, c'est normal
                    console.log('Fetch aborted');
                } else {
                    // Une autre erreur est arrivée
                    console.error('Fetch error:', error);
                }
            }
        }



        // ======================================================================
        // ==== Exemple des couleurs ====
        // ======================================================================
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('input', (e) => {
                const index = parseInt(e.target.getAttribute('data-color'))
                const color = parseInt(e.target.value.replace('#', ''), 16)
                skinRenderer.setColorFocusIndex(null)
                skinRenderer.setColorIndex(index, color)
            });

            input.addEventListener('mouseenter', (e) => {
                const index = parseInt(e.target.getAttribute('data-color'))
                skinRenderer.setColorFocusIndex(index)
            });

            input.addEventListener('mouseleave', (e) => {
                const index = parseInt(e.target.getAttribute('data-color'))
                skinRenderer.setColorFocusIndex(null)
            });

            input.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-color'))
                skinRenderer.setColorFocusIndex(null)
            });
        });

        document.querySelectorAll('input[type="text"][data-color]').forEach(input => {
            input.addEventListener('input', (e) => {
                const index = parseInt(e.target.getAttribute('data-color'))
                const color = parseInt(e.target.value.replace('#', ''), 16)
                skinRenderer.setColorFocusIndex(null)
                skinRenderer.setColorIndex(index, color)
            });
        });


        // ======================================================================
        // ==== Exemple Button d'export  ====
        // ======================================================================
        document.querySelector('#btnExportAnim').addEventListener('click', (e) => {
            skinRenderer.downloadAnimation()
        })

        document.querySelector('#btnExport').addEventListener('click', (e) => {
            skinRenderer.downloadImage()
        })

        document.querySelector('#btnCopyImg').addEventListener('click', (e) => {
            skinRenderer.copyImage()
        })

        document.querySelector('#btnShare').addEventListener('click', async (e) => {
            let data = JSON.parse(skinRenderer.rendererData);
            data.orientation = 1;
            data.animation = 'Static';

            // Affiche le loader
            const loader = document.getElementById('shareLoader');
            if(loader) {
                loader.classList.add('animate-customSpin');
                loader.classList.remove('opacity-0');
            }

            // Vide l'ancienne image
            const img = document.getElementById('previsu-img');
            if (img) {
                img.src = '';
                img.style.opacity = '0';
            }

            // Génére la nouvelle
            await UpdateRenderer(JSON.stringify(data, null, 2), false);

            // Puis l'applique
            await skinRenderer.showSharePrevImage();

            // Masque le loader
            if(loader) {
                loader.classList.remove('animate-customSpin');
                loader.classList.add('opacity-0');
            }
        })

        window.generateFinalInputImage = async function () {

            // Génère l'image
            let data = JSON.parse(skinRenderer.rendererData);
            data.orientation = 1;
            data.animation = 'Static';

            await UpdateRenderer(JSON.stringify(data, null, 2), false);

            const url = await skinRenderer.fillShareInputImage();
            const blob = await (await fetch(url)).blob();
            const file = new File([blob], 'webgl-image.png', { type: 'image/png' });

            // Injecte ce fichier dans le champ file caché via DataTransfer
            const dt = new DataTransfer();
            dt.items.add(file);

            const input = document.getElementById('image_path');
            input.files = dt.files;

            const form = document.getElementById('skinator-form');
            form.submit();
        };


    </script>

@endsection
