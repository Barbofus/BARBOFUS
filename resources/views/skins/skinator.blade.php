@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(3rem,10vw)] mt-8 font-normal text-center uppercase">
        {{ str_ends_with(Route::currentRouteName(), 'edit') ? __('barbofus.titleEdit') : 'Skinator' }}</h1>

    @if ($isMissSkinTime)
        <div class="flex items-center justify-center mx-auto gap-x-2 w-fit">
            <p class="text-lg italic font-light text-center text-inactiveText whitespace-nowrap">Thème du Miss'Skin: <span class="text-secondary">{{ $missSkinTheme }}</span></p>


                <!-- Icone Info -->
                <div class="relative h-6 cursor-pointer min-w-[1.5rem] group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-secondary">
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
                        c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z" />
                    </svg>
                    <div
                        class="group-hover:visible group-hover:opacity-100 z-10 invisible opacity-0 transition-all cursor-text absolute top-[150%]
                        min-[901px]:-left-[17.5rem] min-[901px]:-top-4">
                        <x-utils.miss-skin />
                        <svg class="absolute h-4 text-secondary right-[50%] rotate-180 -top-4
                            min-[901px]:-rotate-90 min-[901px]:top-5 min-[901px]:-right-4 "
                            x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                            <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                        </svg>
                    </div>
                </div>
        </div>
    @endif

    <form autocomplete="off" class="w-[min(98vw,120rem)] mx-auto mb-16 h-fit relative" method="POST" id="skinator-form"
        action="{{ $route }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';"
        x-data="skinator" x-init="initWatcher();
        window.skinator = $data">

        @method($method)
        @csrf

        <input type="file" name="image_path" id="image_path" hidden>

        {{-- PREVISU PARTAGE --}}
        <div x-show="openShareUI" x-cloak x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            @click.outside="openShareUI = false; $refs.btnShare.disabled = false;"
            class="absolute p-4 shadow-[rgba(0,_0,_0,_0.5)_0px_0px_70px_4px] rounded-lg bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-30">
            <img id="previsu-img" src="" height="500" width="300" alt="Render" style="opacity: 0"
                class="mx-auto transition-all">

            <div class="absolute left-0 w-full pointer-events-none top-1/4">
                <div id="shareLoader"
                    class="border-[0.375rem] border-inactiveText border-l-goldText w-20 h-20 rounded-full opacity-0 mx-auto [--custom-animation-time:1s]">
                </div>
            </div>

            <input x-ref="input" maxlength="30" name="name" id="name" type="text"
                placeholder="{{ __('barbofus.inputName') . ' (optionnal)' }}"
                value="{{ old('name') ? old('name') : (isset($skin) ? $skin['name'] : '') }}"
                class="w-full h-10 pl-4 focus:outline-none placeholder-inactiveText bg-primary-100" />

            {{-- Bouton Valider --}}
            <div class="flex w-full mt-4 justify-evenly">

                {{-- Valider --}}
                <button type="button"
                    class="relative px-5 py-3 text-lg font-normal uppercase transition-all rounded-lg recaptcha-btn text-primary goldGradient hover:enabled:brightness-110 hover:enabled:tracking-widest disabled:cursor-not-allowed disabled:grayscale focus:brightness-75"
                    data-sitekey="{{ config('services.recaptcha.site_key') }}" data-callback='onSubmit' data-action='store'>
                    <p class="absolute left-0 w-full text-center">{{ __('barbofus.buttonValidate') }}</p>
                    <p class="tracking-widest opacity-0">{{ __('barbofus.buttonValidate') }}</p>
                </button>

                {{-- Annuler --}}
                <button @click="openShareUI = false; $refs.btnShare.disabled = false;" type="button"
                    class="relative px-5 py-3 text-lg font-normal uppercase transition-all rounded-lg text-primary bg-gradient-to-tr from-red-700 to-red-500 hover:brightness-110 hover:tracking-widest focus:brightness-75">
                    <p class="absolute left-0 w-full text-center">{{ __('barbofus.buttonCancel') }}</p>
                    <p class="tracking-widest opacity-0">{{ __('barbofus.buttonCancel') }}</p>
                </button>
            </div>

            @if ($isMissSkinTime)
                {{-- Miss Skin --}}
                <div class="flex justify-center mt-4" x-transition>
                    <div class="flex items-center gap-3 cursor-pointer" @click="useForMissSkin = !useForMissSkin">
                        <button id="use_for_miss_skin" type="button"
                            class="w-[1.125rem] h-[1.125rem] border rounded-[3px] bg-anthraciteLit border-1 border-ivory flex-shrink-0 relative">

                            <img src="{{ asset('storage/images/misc_ui/checkmark.png') }}" alt=""
                                class="absolute min-w-[1.875rem] h-[1.875rem] -left-1 -top-3 transition-all"
                                :class="useForMissSkin ? 'opacity-100' : 'opacity-0'">
                        </button>

                        <label for="use_for_miss_skin" @click="useForMissSkin = !useForMissSkin"
                            class="text-lg font-thin cursor-pointer text-secondary whitespace-nowrap">
                            Utiliser pour Miss'Skin
                        </label>
                    </div>
                </div>
            @endif

            <input type="hidden" name="use_for_miss_skin" :value="useForMissSkin ? '1' : '0'">

            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Sélectionne tous les boutons avec la classe 'recaptcha-btn'
                    const buttons = document.querySelectorAll('.recaptcha-btn');

                    // Attache l'événement click à chaque bouton
                    buttons.forEach(function(button) {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Affiche le loader
                            const loader = document.getElementById('shareLoader');
                            if (loader) {
                                loader.classList.add('animate-customSpin');
                                loader.classList.remove('opacity-0');
                            }
                            const img = document.getElementById('previsu-img');
                            if (img) {
                                img.style.opacity = '0.5';
                            }

                            // Désactive le bouton cliqué
                            button.disabled = true;

                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                                    action: 'store'
                                }).then(function(token) {
                                    // Crée dynamiquement le champ hidden
                                    const form = document.getElementById('skinator-form');

                                    // Supprime le token précédent s'il existe
                                    const existingInput = form.querySelector(
                                        'input[name="g-recaptcha-response"]');
                                    if (existingInput) {
                                        existingInput.remove();
                                    }

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
                });
            </script>
        </div>

        {{--    ITEMS ACTUELS    --}}
        <div class="flex h-24 my-2 space-x-4 overflow-auto"
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
            <template
                x-for="(item, key) in Object.fromEntries(Object.entries(items).filter(([key, value]) => value !== null))"
                :key="item">
                <button type="button" :title="allItems.find(i => i.dofus_id === item).name" :data-key="key"
                    class="bg-primary-100 h-full group relative rounded-lg py-1 px-2 min-w-[11rem] overflow-hidden">

                    <div class="flex items-start">
                        <img loading="lazy" draggable="false" class="h-10 min-[1600px]:h-16"
                            :src="'/storage/' + allItems.find(i => i.dofus_id === item).icon_path"
                            :alt="allItems.find(i => i.dofus_id === item).name">
                        <div class="flex items-end pt-4 space-x-1">
                            <img loading="lazy" draggable="false" width="24" height="24" class="w-6 h-6"
                                :src="'/storage/images/icons/items/subcategories/' + allItems.find(i => i.dofus_id ===
                                        item)
                                    .subcategory + '.png'"
                                :alt="allItems.find(i => i.dofus_id === item).subcategory">
                            <p x-text="'Lv.' + allItems.find(i => i.dofus_id === item).level"
                                class="text-inactiveText whitespace-nowrap"></p>
                        </div>
                    </div>

                    <input type="text" :value="item" :name="key + '_id'" class="hidden">

                    <p x-text="allItems.find(i => i.dofus_id === item).name" class="text-left truncate"></p>

                    <div
                        class="absolute top-0 left-0 w-full h-full transition-all bg-black opacity-0 group-hover:opacity-70">
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="absolute w-6 h-6 text-red-500 transition-all top-1 right-1 group-hover:h-20 group-hover:w-20">
                        <path
                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
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
                        <button type="button" class="w-1/3 uppercase" data-tab="breed"
                            :class="(charactersCurrentTab === 'breed') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentBreed') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="head"
                            :class="(charactersCurrentTab === 'head') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentFace') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="body"
                            :class="(charactersCurrentTab === 'body') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentBody') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="color"
                            :class="(charactersCurrentTab === 'color') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentColor') }}</button>
                    </div>

                    {{--      Choix sexe      --}}
                    <p class="mt-4 mb-1 text-xl font-light text-center">{{ __('barbofus.labelSkinGender') }}</p>
                    <div class="flex mx-auto gap-x-4 w-fit"
                        @change="if (event.target.matches('input[type=radio]')) { shouldResetColors = checkIfDefaultColors(gender, breed, colors); gender = Number(event.target.value); editURLParam(getURLObject()); updateAlpineHead(); updateAlpineBody(); }">
                        <div>
                            <input id="male" type="radio" name="gender" value="0" class="hidden peer"
                                :checked="gender === 0">
                            <label for="male"
                                class="flex items-center w-32 h-12 p-2 transition-all border-2 rounded-md cursor-pointer justify-left gap-x-2 text-inactiveText border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText bg-primary-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z" />
                                </svg>
                                <p>{{ __('barbofus.inputSkinMale') }}</p>
                            </label>
                        </div>

                        <div>
                            <input id="female" type="radio" name="gender" value="1" class="hidden peer"
                                :checked="gender === 1">
                            <label for="female"
                                class="flex items-center w-32 h-12 p-2 transition-all border-2 rounded-md cursor-pointer justify-left gap-x-2 text-inactiveText border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText bg-primary-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z" />
                                </svg>
                                <p>{{ __('barbofus.inputSkinFemale') }}</p>
                            </label>
                        </div>
                    </div>

                    <div x-cloak class="py-4 min-[600px]:px-4" x-show="charactersCurrentTab === 'breed'">

                        {{--      Choix classe      --}}
                        <p class="mb-1 text-xl font-light text-center">{{ __('barbofus.labelSkinClass') }}</p>

                        <div class="flex flex-wrap items-center justify-center gap-2"
                            @change="if (event.target.matches('input[type=radio]')) { shouldResetColors = checkIfDefaultColors(gender, breed, colors); breed = Number(event.target.value); editURLParam(getURLObject()); updateAlpineHead(); updateAlpineBody(); }">
                            <template x-for="breedInfo in breedInfos" :key="breedInfo.dofus_id">
                                <div>
                                    <input :id="'breed_' + breedInfo.dofus_id" type="radio" name="race_id"
                                        :value="breedInfo.dofus_id" class="hidden peer"
                                        :checked="breed === breedInfo.dofus_id">
                                    <label :for="'breed_' + breedInfo.dofus_id" :title="breed.name"
                                        class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(3.5vw,5rem),4rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                        <img loading="lazy" draggable="false"
                                            :src="'/storage/images/icons/classes/faces/unity/' + breedInfo.heads[
                                                gender ===
                                                0 ? 'male' : 'female'][0].assetId + '.png'"
                                            :alt="breed.name">
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-cloak class="py-4 min-[600px]:px-4" x-show="charactersCurrentTab === 'head'">

                        {{--      Choix visage      --}}
                        <p class="mb-1 text-xl font-light text-center">{{ __('barbofus.labelSkinFace') }}</p>

                        <div class="flex flex-wrap items-center justify-center gap-2"
                            @change="if (event.target.matches('input[type=radio]')) { head = Number(event.target.value); editURLParam(getURLObject()); }">
                            <template x-for="breedHead in breedHeads" :key="breedHead.id">
                                <div>
                                    <input :id="'head_' + breedHead.id" type="radio" name="face"
                                        :value="breedHead.id" class="hidden peer" :checked="head === breedHead.id">
                                    <label :for="'head_' + breedHead.id"
                                        :title="'{{ __('barbofus.contentFace') }} ' + (breedInfos.find(i => i.dofus_id ===
                                            breed).name) + ' ' + breedHead.id"
                                        class="transition-all rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(3.5vw,5rem),4rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText">
                                        <img loading="lazy" draggable="false"
                                            :src="'/storage/images/icons/classes/faces/unity/' + breedHead.assetId +
                                                '.png'"
                                            :alt="'{{ __('barbofus.contentFace') }} ' + (breedInfos.find(i => i
                                                .dofus_id ===
                                                breed).name) + ' ' + breedHead.id">
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-cloak class="py-4 min-[600px]:px-4" x-show="charactersCurrentTab === 'body'">

                        {{--      Choix corps      --}}
                        <p class="mb-1 text-xl font-light text-center">{{ __('barbofus.labelSkinBody') }}</p>

                        <div class="grid items-center justify-center grid-cols-3 gap-2"
                            @change="if (event.target.matches('input[type=radio]')) { body = Number(event.target.value); editURLParam(getURLObject()); }">
                            <template x-for="breedBody in breedBodies" :key="breedBody.id">
                                <div>
                                    <input :id="'body_' + breedBody.id" type="radio" name="body"
                                        :value="breedBody.id" class="hidden peer" :checked="body === breedBody.id">
                                    <label :for="'body_' + breedBody.id"
                                        :title="'{{ __('barbofus.contentBody') }} ' + (breedInfos.find(i => i.dofus_id ===
                                            breed).name) + ' ' + breedBody.id"
                                        class="flex p-2 items-center justify-center transition-all border-2 rounded-md cursor-pointer text-inactiveText hover:border-inactiveText bg-primary-100 aspect-[2/3] border-primary-100 peer-checked:text-secondary peer-checked:border-goldText overflow-hidden">
                                        <img loading="lazy" draggable="false" class="object-cover w-auto h-full"
                                            :src="'/storage/images/icons/classes/bodies/unity/' + breedBody.assetId.replace(/\d+$/, n => +n - 1) +
                                                '.png'"
                                            :alt="'{{ __('barbofus.contentBody') }} ' + (breedInfos.find(i => i
                                                .dofus_id ===
                                                breed).name) + ' ' + breedBody.id">
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-cloak id="color-tab" class="py-4 min-[600px]:px-4 relative"
                        x-show="charactersCurrentTab === 'color'">

                        {{--      Choix couleur      --}}
                        <div class="flex flex-wrap justify-evenly"
                            @click="if(event.target.closest('button[data-copy]')) {
                                const index = parseInt(event.target.closest('button[data-copy]').dataset.copy);
                                const colorValue = index < colors.length ? colors[index] : guildColors[index - colors.length];
                                copyToClipboard(colorValue.slice(1), 'hex' + index);
                            }"
                            @change="editURLParam(getURLObject())"
                            @input="if(event.target.closest('input[data-color]'))
                             {
                                const index = parseInt(event.target.closest('input[data-color]').dataset.color);
                                newColor = '#' + event.target.closest('input[data-color]').value.replace(/[^0-9a-fA-F]/g, '').slice(0, 6);
                                if (index < colors.length) {
                                    colors[index] = newColor;
                                } else {
                                    guildColors[index - colors.length] = newColor;
                                }
                                event.target.value = newColor;
                             }">
                            <template x-for="(color, index) in [...colors, ...guildColors]" :key="index">
                                <div :id="'color-' + index"
                                    class="my-3 overflow-hidden rounded-t-lg hover:bg-primary-100 transition-colors00">
                                    <button type="button" :data-copy="index"
                                        class="relative flex items-center justify-between w-full px-2 py-1">
                                        <p x-text="colorsLabel[index] + ' :'"
                                            class="font-thin text-sm min-[600px]:text-lg truncate"></p>

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4 fill-inactiveText">
                                            <path
                                                d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z" />
                                            <path
                                                d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z" />
                                        </svg>

                                        <div x-cloak :class="copy === 'hex' + index ? 'opacity-100' : 'opacity-0'"
                                            class="absolute top-0 left-0 flex items-center justify-center w-full h-full transition bg-secondary">
                                            <p class="text-xl font-medium uppercase text-primary">
                                                {{ __('barbofus.contentCopied') }} !</p>
                                        </div>
                                    </button>

                                    <div class="flex items-center h-10">

                                        <!-- Input de couleur -->
                                        <input type="text"
                                            :value="index < colors.length ? colors[index] : guildColors[index - colors
                                                .length]"
                                            :name="'color_' + colorsName[index]" maxlength="7" :data-color="index"
                                            class="uppercase order-last h-full peer rounded-r p-1 bg-primary-100 text-center w-[5.5rem] min-[600px]:w-28 focus:outline-none border-transparent focus:border-secondary border-y border-r transition-colors">

                                        <div class="relative z-0 w-10 h-full group">
                                            <div class="w-full h-full border-l border-transparent rounded-l cursor-pointer focus:outline-none border-y peer-focus:border-secondary"
                                                :style="{
                                                    background: index < colors.length ? colors[index] : guildColors[
                                                        index - colors.length]
                                                }">
                                                <input type="color" :data-color="index"
                                                    :value="index < colors.length ? colors[index] : guildColors[index -
                                                        colors
                                                        .length]"
                                                    class="w-full h-full opacity-0 cursor-pointer">
                                            </div>

                                            <button
                                                class="absolute top-0 left-0 w-full h-full transition-all border-transparent opacity-0 -z-10 bg-primary-100 text-inactiveText group-hover:opacity-100 group-hover:translate-x-full hover:text-red-500"
                                                @click="if (index < colors.length) { colors[index] = getOneDefaultColor(gender, breed, index); } else { guildColors[index - colors.length] = index === 6 ? '#241F1D' : '#FAB420'; } editURLParam(getURLObject()); window.resetDefaultColors()"
                                                type="button" title="reset">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="mx-auto h-7">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>

                                            <button
                                                class="opacity-0 -z-10 absolute top-0 left-0 h-full w-full border-transparent bg-primary-100 text-inactiveText group-hover:opacity-100 group-hover:translate-x-[calc(100%*2)] hover:text-purple-500 transition-all"
                                                @click="if (index < colors.length) { colors[index] = getOneRandomColor(); } else { guildColors[index - colors.length] = getOneRandomColor(); } editURLParam(getURLObject()); window.resetDefaultColors()"
                                                type="button" title="randomize">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="h-6 mx-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-evenly">

                            <button type="button"
                                @click="colors = colors.map(() => getOneRandomColor()); editURLParam(getURLObject()); window.resetDefaultColors()"
                                class="flex items-center px-4 py-2 mx-auto mt-4 space-x-2 text-lg uppercase transition-all duration-75 rounded-md bg-primary-100 text-inactiveText hover:text-purple-500 hover:rounded-3xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>

                                <p>Randomize</p>
                            </button>

                            <button type="button"
                                @click="colors = getDefaultColor(gender, breed); editURLParam(getURLObject()); window.resetDefaultColors()"
                                class="flex items-center px-4 py-2 mx-auto mt-4 space-x-2 text-xl uppercase transition-all duration-75 rounded-md bg-primary-100 text-inactiveText hover:text-red-500 hover:rounded-3xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>

                                <p>Reset</p>
                            </button>
                        </div>
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
                    <div class="relative inline-block group">

                        {{-- Toggle animation --}}
                        <div
                            class="absolute left-0 w-8 h-8 transition-all opacity-0 pointer-events-none group-hover:opacity-100 text-secondary top-2">
                            {{-- Pause --}}
                            <svg x-cloak x-show="animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                fill="currentColor" class="size-4">
                                <path
                                    d="M4.5 2a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-.5-.5h-1ZM10.5 2a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-.5-.5h-1Z" />
                            </svg>

                            {{-- Play --}}
                            <svg x-cloak x-show="!animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                fill="currentColor" class="size-4">
                                <path
                                    d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z" />
                            </svg>
                        </div>

                        {{-- Render --}}
                        <canvas @click="if(!showAnimationList) { animated = !animated }"
                            class="cursor-pointer canvas-renderer" title="Cliquez pour activer/désactiver l'animation"
                            x-ref="canvas" id="canvas0" width="300px" height="500px"></canvas>

                        {{-- Loader --}}
                        <svg class="loading-logo" style="display: none;" viewBox="0 0 66.410408 67.468735"
                            xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="progress-gradient" x1="0" y1="1" x2="0"
                                    y2="0">
                                    <stop offset="0%" stop-color="#fba436" />
                                    <stop offset="50%" stop-color="#faed61" />
                                    <stop offset="50%" stop-color="#fff5e9" />
                                    <stop offset="100%" stop-color="#f2e8dc" />
                                </linearGradient>
                            </defs>
                            <g width="120px" height="120px" id="layer1"
                                transform="translate(-57.924089,-154.32008)">
                                <path style="fill:url(#progress-gradient);stroke:none;stroke-width:0.264583"
                                    d="m 61.628256,154.32008 c -1.322096,1.86955 -1.590754,3.58452 -1.058333,5.82083 l -2.645833,-0.52917 2.910416,5.02709 -2.910416,-0.79375 c 0.761182,5.88925 6.723168,11.10844 12.699999,10.83748 2.45028,-0.11107 4.340675,-1.45116 6.614583,-2.10624 l -1.5875,2.91042 c 5.3036,0 12.50818,-1.69172 14.81667,-7.14375 1.55257,0.75655 2.61276,2.40395 3.96875,3.49041 3.34909,2.68356 7.586918,4.41709 11.906248,3.38876 l -1.5875,-2.91042 c 7.96872,4.19896 17.21484,-0.40296 19.57916,-8.73125 l -3.175,0.52917 c 1.46394,-1.47725 2.59292,-3.00628 3.175,-5.02708 l -2.91042,1.05833 c 0.40349,-2.17331 0.60378,-4.36605 -1.32291,-5.82083 -1.42372,4.33834 -4.95538,5.84731 -9.26042,5.17937 -4.76911,-0.73998 -9.16305,-2.55677 -14.022908,-2.53333 -2.14895,0.0104 -4.20026,1.79644 -6.08542,1.70529 -1.05913,-0.0512 -2.1381,-0.92315 -3.175,-1.19634 -1.579298,-0.41603 -3.405452,-0.30779 -5.027083,-0.23415 -5.961539,0.27061 -12.953497,5.40988 -18.510223,0.90786 -1.345009,-1.08974 -1.482884,-2.52272 -2.39186,-3.8287 m 12.7,21.16666 c -4.916937,0.66212 -7.310464,0.35057 -11.641666,-2.11667 -3.294859,5.79528 -0.982478,12.15258 2.116666,17.4625 h 0.264584 l 0.264583,-2.91041 h 0.264583 c 0.941388,3.31602 2.901712,6.50081 5.291667,8.99583 l 0.264583,-0.79375 h 0.264583 l 2.645833,6.87916 h 0.264584 v -1.85208 h 0.264583 c 1.741911,3.35783 5.285793,4.13306 7.881144,6.48997 3.619239,3.28691 6.585479,9.50489 7.729269,14.14753 3.37238,-2.55852 5.51207,-6.30396 7.33981,-10.05417 0.71623,-1.47002 1.04907,-3.43905 2.09232,-4.70614 1.329008,-1.61422 3.777198,-2.70325 5.384538,-4.10157 2.65059,-2.30637 4.2971,-5.00565 5.82083,-8.12562 l 1.5875,2.38125 0.26459,-4.49792 1.32291,0.26459 c 1.49278,-5.10911 4.49792,-9.00721 4.49792,-14.55208 l 0.79375,0.52916 0.26458,-6.08541 c -4.03225,1.87372 -7.22471,2.46522 -11.64166,2.11666 -2.22409,4.62756 -10.755048,0.61701 -13.493748,-1.50278 -0.90409,-0.6999 -2.20478,-2.64749 -3.41498,-2.67972 -1.00965,-0.0269 -2.41009,1.97524 -3.19987,2.55293 -2.878933,2.10598 -6.040836,2.99371 -9.524736,3.40612 -1.372606,0.16248 -3.456358,0.34012 -3.96875,-1.24738 z" />
                            </g>

                        </svg>
                    </div>

                    {{-- Zone sous skins / Orientation / Animation --}}
                    <div class="flex items-center mx-auto space-x-8 justify-evenly w-fit">
                        <button type="button" class="group"
                            @click="orientationKey++; if(orientationKey >= possibleOrientation[animations[animation].orientation].length) orientationKey = 0">
                            <img loading="lazy"
                                src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}"
                                class="transition-all group-hover:-translate-y-1 h-14 group-active:translate-y-0 group-active:scale-90">
                        </button>

                        {{-- Choix anim exploration / combat --}}
                        <button type="button" title="Exploration / Combat"
                            class="relative p-1 uppercase transition-all rounded-md group bg-secondary text-primary hover:rounded-3xl"
                            @click="showAnimationList = !showAnimationList">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-8">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 0 0-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634Zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 0 1-.189-.866c0-.298.059-.605.189-.866Zm2.023 6.828a.75.75 0 1 0-1.06-1.06 3.75 3.75 0 0 1-5.304 0 .75.75 0 0 0-1.06 1.06 5.25 5.25 0 0 0 7.424 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <button type="button" class="group"
                            @click="orientationKey--; if(orientationKey < 0) orientationKey = possibleOrientation[animations[animation].orientation].length - 1">
                            <img loading="lazy"
                                src="{{ asset('storage/images/misc_ui/btn_skinator_orientation_arrow.png') }}"
                                class="transition-all group-hover:-translate-y-1 h-14 -scale-x-100 group-active:translate-y-0 group-active:scale-y-90 group-active:-scale-x-90">
                        </button>
                    </div>

                    {{-- Bouton d'export --}}
                    <div class="relative w-full mx-auto mb-2">

                        <div class="flex justify-between">
                            {{-- Bouton DL Anim --}}
                            <button type="button" id="btnExportAnim" title="Telechargement image animé"
                                class="p-2 transition-all border-2 border-transparent rounded-lg bg-primary-100 hover:bg-primary hover:border-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </button>

                            {{-- Bouton Copier --}}
                            <button type="button" id="btnCopyImg" title="Copie image"
                                @click="copyToClipboard('test', 'finalSkin')"
                                :class="copy === 'finalSkin' ? 'bg-secondary text-primary' :
                                    'bg-primary-100 hover:bg-primary hover:border-secondary'"
                                class="p-2 transition-all border-2 border-transparent rounded-lg">
                                <svg x-cloak x-show="copy != 'finalSkin'" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                </svg>
                                <p x-cloak x-show="copy === 'finalSkin'">{{ __('barbofus.contentCopied') }}</p>
                            </button>

                            {{-- Bouton DL --}}
                            <button type="button" id="btnExport" title="Telechargement image"
                                class="p-2 transition-all border-2 border-transparent rounded-lg bg-primary-100 hover:bg-primary hover:border-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                </svg>

                            </button>
                        </div>
                    </div>

                    {{-- Boutons copy link + Export PNG --}}
                    <div class="flex w-fit mx-auto justify-evenly space-x-2 min-[600px]:space-x-8">

                        {{-- Bouton Copy link --}}
                        <div class="flex justify-end w-full">
                            <button type="button" @click="copyToClipboard(window.location.href, 'url')"
                                x-text="copy === 'url' ? '{{ __('barbofus.contentCopied') }}' : '{{ __('barbofus.contentCopy') }} URL'"
                                :class="copy === 'url' ? 'bg-secondary text-primary' :
                                    'bg-primary-100 hover:bg-primary hover:border-secondary'"
                                class="px-4 py-2 transition-all border-2 border-transparent rounded-lg">
                            </button>
                        </div>

                        {{-- Bouton Partager --}}
                        <div class="flex justify-start w-full">
                            <button disabled x-ref="btnShare" type="button" id="btnShare"
                                class="g-recaptcha relative px-5 min-[600px]:px-8 py-3 text-lg font-normal text-primary goldGradient rounded-lg hover:enabled:brightness-110 hover:enabled:tracking-widest disabled:cursor-not-allowed disabled:grayscale transition-all focus:brightness-75 uppercase"
                                @click="openShareUI = true; $refs.btnShare.disabled = true;">
                                <p class="absolute left-0 w-full text-center">
                                    {{ str_ends_with(Route::currentRouteName(), 'edit') ? __('barbofus.buttonModify') : __('barbofus.buttonShare') }}
                                </p>
                                <p class="tracking-widest opacity-0">
                                    {{ str_ends_with(Route::currentRouteName(), 'edit') ? __('barbofus.buttonModify') : __('barbofus.buttonShare') }}
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{--      TOUS LES ITEMS      --}}
            <div class="relative flex flex-col flex-1 h-full">

                {{-- CHOIX ONGLET --}}
                <div class="text-md min-[1600px]:text-xl h-fit font-thin flex flex-wrap gap-y-2 justify-evenly"
                    @click="if(event.target.closest('button[data-tab]')) { itemsCurrentTab = event.target.closest('button[data-tab]').dataset.tab; maxItemVisible = 96; if(searchBar != '') { searchBar = ''; updateFilteredItems(); } }">

                    @foreach ($itemCategories as $category)
                        <button type="button" data-tab="{{ $category }}" class="flex-grow px-2 uppercase truncate"
                            :class="(itemsCurrentTab === '{{ $category }}') ?
                            'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.content' . ucfirst($category)) }}</button>
                    @endforeach
                </div>

                {{-- Barre de recherche --}}
                <div class="relative flex flex-wrap mt-2 h-fit">
                    <div
                        class="relative flex items-center space-x-2 mb-2 h-full w-[16rem] mr-6 bg-primary-100 rounded-md py-2">
                        <input maxlength="64" id="skinator-search" type="text"
                            placeholder="{{ __('barbofus.contentRefineSearch') }}" x-model="searchBar"
                            x-ref="skinatorSearchInput" @input="updateFilteredItems"
                            class="pl-4 rounded-md focus:outline-none placeholder-inactiveText bg-primary-100" />

                        <button type="button" x-cloak
                            @click="searchBar = ''; $refs.skinatorSearchInput.focus(); updateFilteredItems()"
                            class="relative w-6 h-6" for="skinator-search">
                            <svg :class="searchBar.length === 0 ? 'visible' : 'invisible'"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="absolute top-0 left-0 h-6 text-inactiveText">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>

                            <svg :class="searchBar.length > 0 ? 'visible' : 'invisible'"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="absolute top-0 left-0 h-6 text-red-500">
                                <path
                                    d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex mb-2 mr-6 space-x-2">

                        {{-- election items aléatoire --}}
                        <button type="button" x-cloak title="Randomize items" @click="getRandomItems()"
                            class="w-10 h-10 transition-all border-2 rounded-md text-md bg-primary-100 border-inactiveText text-inactiveText hover:text-secondary hover:border-secondary">
                            <img src="{{ asset('storage/images/misc_ui/simple_dice.png') }}" alt="Skin Aléatoire"
                                height="32" width="32" draggable="false"
                                class="h-8 mx-auto transition-all opacity-75 hover:opacity-100 hover:scale-90">
                        </button>
                    </div>

                    {{-- Color filter --}}
                    <div class="relative z-10 mb-2 mr-6 group">
                        <div class="w-10 h-10 transition-all border-2 rounded cursor-pointer focus:outline-none border-inactiveText group-hover:border-secondary peer-focus:border-secondary"
                            :style="searchColor
                                ?
                                { background: searchColor } : {
                                    backgroundImage: 'repeating-conic-gradient(#ffffff00 0% 25%, #e1e1e120 0% 50%)',
                                    backgroundSize: '15px 15px',
                                    backgroundColor: 'transparent'
                                }">
                            <input type="color" title="Item filter" x-model="searchColor"
                                @change="updateFilteredItems()" class="w-full h-full opacity-0 cursor-pointer">
                        </div>

                        <button
                            class="absolute top-0 left-0 w-full h-full transition-all border-transparent opacity-0 -z-10 bg-primary-100 text-inactiveText hover:text-red-500"
                            :class="searchColor ? 'group-hover:translate-x-full group-hover:opacity-100' : ''"
                            @click="searchColor = null; updateFilteredItems()" type="button" title="reset">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="mx-auto h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Item filter --}}
                    <div class="flex mb-2 mr-6 space-x-2">

                        {{-- Show colorable --}}
                        <button type="button" x-cloak title="Show only colorable"
                            @click="showOnlyColorable = !showOnlyColorable; updateFilteredItems()"
                            class="w-10 h-10 transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="showOnlyColorable ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="showOnlyColorable ? 'opacity-100' : 'opacity-60 grayscale'"
                                class="mx-auto transition-all h-7 hover:scale-90"
                                src="{{ asset('storage/images/misc_ui/colorable_items_icon.png') }}" alt="Colorable">
                        </button>

                        {{-- Show Mimisymbic --}}
                        <button type="button" x-cloak title="Show only mimisymbic"
                            @click="showOnlyMimisymbic = !showOnlyMimisymbic; updateFilteredItems()"
                            class="w-10 h-10 transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="showOnlyMimisymbic ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="showOnlyMimisymbic ? 'opacity-100' : 'opacity-60 grayscale'"
                                class="mx-auto transition-all h-7 hover:scale-90"
                                src="{{ asset('storage/images/icons/items/subcategories/mimisymbic.png') }}"
                                alt="Colorable">
                        </button>

                        {{-- Show Ceremonial --}}
                        <button type="button" x-cloak title="Show only ceremonial"
                            @click="showOnlyCeremonial = !showOnlyCeremonial; updateFilteredItems()"
                            class="w-10 h-10 transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="showOnlyCeremonial ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="showOnlyCeremonial ? 'opacity-100' : 'opacity-60 grayscale'"
                                class="mx-auto transition-all h-7 hover:scale-90"
                                src="{{ asset('storage/images/icons/items/subcategories/ceremonial.png') }}"
                                alt="Colorable">
                        </button>

                        <button type="button" x-cloak title="Show only favorite"
                            @click="showOnlyFavorite = !showOnlyFavorite; updateFilteredItems()"
                            class="w-10 h-10 transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="showOnlyFavorite ? 'border-secondary text-secondary' :
                                'border-inactiveText text-inactiveText'">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="mx-auto h-7 hover:scale-90">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    {{-- CHOIX ONGLET FAMILIER --}}
                    <div x-show="itemsCurrentTab === 'pet'" x-transition class="flex h-10 mb-2 space-x-2 font-thin"
                        @click="if(event.target.closest('button[data-tab]')) { petCurrentTab = event.target.closest('button[data-tab]').dataset.tab; maxItemVisible = 96; if(searchBar != '') { searchBar = ''; updateFilteredItems(); } }">

                        <button type="button" x-cloak data-tab="familier"
                            class="w-10 h-full transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="(petCurrentTab === 'familier') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'familier') ? 'opacity-100' : 'opacity-60'"
                                class="h-full transition-all"
                                src="{{ asset('storage/images/icons/mounts/familiar.png') }}" alt="Familier">
                        </button>

                        <button type="button" x-cloak data-tab="montilier"
                            class="w-10 h-full transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="(petCurrentTab === 'montilier') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'montilier') ? 'opacity-100' : 'opacity-60'"
                                class="h-full transition-all"
                                src="{{ asset('storage/images/icons/mounts/petsmount.png') }}" alt="Montilier">
                        </button>

                        <button type="button" x-cloak data-tab="dragodinde"
                            class="w-10 h-full transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="(petCurrentTab === 'dragodinde') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'dragodinde') ? 'opacity-100' : 'opacity-60'"
                                class="h-full transition-all"
                                src="{{ asset('storage/images/icons/mounts/dragoturkey.png') }}" alt="Dragodinde">
                        </button>

                        <button type="button" x-cloak data-tab="muldo"
                            class="w-10 h-full transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="(petCurrentTab === 'muldo') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'muldo') ? 'opacity-100' : 'opacity-60'"
                                class="h-full transition-all"
                                src="{{ asset('storage/images/icons/mounts/seemyool.png') }}" alt="Muldo">
                        </button>

                        <button type="button" x-cloak data-tab="volkorne"
                            class="w-10 h-full transition-all border-2 rounded-md bg-primary-100 hover:border-secondary"
                            :class="(petCurrentTab === 'volkorne') ? 'border-secondary' : 'border-inactiveText'">
                            <img :class="(petCurrentTab === 'volkorne') ? 'opacity-100' : 'opacity-60'"
                                class="h-full transition-all"
                                src="{{ asset('storage/images/icons/mounts/rhineetle.png') }}" alt="Volkorne">
                        </button>
                    </div>
                </div>

                {{-- Animation lists --}}
                <div x-show="showAnimationList" x-transition x-cloak @click.outside="showAnimationList = false"
                    class="h-[37.5rem] rounded border-2 border-secondary p-4 pb-8 w-full overflow-auto z-30 top-20 left-0 absolute bg-primary">

                    {{-- CHOIX ONGLET --}}
                    <div class="text-md mb-4 min-[1600px]:text-xl w-full h-10 font-thin flex justify-evenly"
                        @click="if(event.target.closest('button[data-tab]')) { animationsCurrentTab = event.target.closest('button[data-tab]').dataset.tab; }">
                        <button type="button" class="w-1/3 uppercase" data-tab="default"
                            :class="(animationsCurrentTab === 'default') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentdefault') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="combat"
                            :class="(animationsCurrentTab === 'combat') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentCombat') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="retro"
                            :class="(animationsCurrentTab === 'retro') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentRetro') }}</button>
                        <button type="button" class="w-1/3 uppercase" data-tab="newage"
                            :class="(animationsCurrentTab === 'newage') ? 'font-medium border-b-4 border-secondary' :
                            'border-b-2 border-inactiveText'">{{ __('barbofus.contentNewAge') }}</button>
                    </div>


                    {{-- DEFAULT --}}
                    <div x-cloak class="flex flex-wrap gap-4 gap-y-5" x-show="animationsCurrentTab === 'default'">
                        <template x-for="(a, index) in animations" :key="index">
                            <button type="button" @click="animation = index; orientationKey = 0"
                                class="relative transition-all rounded bg-primary-100 group hover:brightness-110">
                                <img draggable="false" class="h-[9rem]"
                                    :src="'{{ asset('storage/images/icons/anims/') }}/' + a.name + '.png'" alt="a.shortName">
                                <p x-text="a.shortName"
                                    class="absolute bottom-0 right-0 z-50 px-2 py-1 text-right transition-all translate-y-1/2 border opacity-0 bg-primary border-secondary whitespace-nowrap w-fit group-hover:opacity-100">
                                </p>
                            </button>
                        </template>
                    </div>


                    {{-- COMBAT --}}
                    <div x-cloak class="flex flex-wrap gap-4 gap-y-5" x-show="animationsCurrentTab === 'combat'">
                        <template x-for="b in breedInfos" :key="b.dofus_id">
                            <button type="button" @click="animationName = `AnimStatiqueCombat${b.dofus_id}a@1-${b.dofus_id}-static`; orientationKey = 0"
                                class="relative transition-all rounded bg-primary-100 group hover:brightness-110">
                                <img draggable="false" class="h-[9rem]"
                                    :src="'/storage/images/icons/anims/combat_' + b.dofus_id + '.png'" :alt="'{{ __('barbofus.contentCombat') }} ' + b.name">
                                <p x-text="'{{ __('barbofus.contentCombat') }} ' + b.name"
                                    class="absolute bottom-0 right-0 z-50 px-2 py-1 text-right transition-all translate-y-1/2 border opacity-0 bg-primary border-secondary whitespace-nowrap w-fit group-hover:opacity-100">
                                </p>
                            </button>
                        </template>
                    </div>


                    {{-- RETRO --}}
                    <div x-cloak class="flex flex-wrap gap-4 gap-y-5" x-show="animationsCurrentTab === 'retro'">
                        <template x-for="b in breedInfos" :key="b.dofus_id">
                            <button type="button" @click="animationName = `AnimStatiqueExploRetro${b.dofus_id}@1-${b.dofus_id}-static`; orientationKey = 0"
                                class="relative transition-all rounded bg-primary-100 group hover:brightness-110">
                                <img draggable="false" class="h-[9rem]"
                                    :src="'/storage/images/icons/classes/bodies/unity/' + b.bodies[gender ? 'female' : 'male'][2].assetId.replace(/\d+$/, n => +n - 1) + '.png'" :alt="'{{ __('barbofus.contentRetro') }} ' + b.name">
                                <p x-text="'{{ __('barbofus.contentRetro') }} ' + b.name"
                                    class="absolute bottom-0 right-0 z-50 px-2 py-1 text-right transition-all translate-y-1/2 border opacity-0 bg-primary border-secondary whitespace-nowrap w-fit group-hover:opacity-100">
                                </p>
                            </button>
                        </template>
                    </div>


                    {{-- NEW AGE --}}
                    <div x-cloak class="flex flex-wrap gap-4 gap-y-5" x-show="animationsCurrentTab === 'newage'">
                        <template x-for="b in breedInfos" :key="b.dofus_id">
                            <button type="button" @click="animationName = `AnimStatiqueExploNewAge${b.dofus_id}@1-${b.dofus_id}-static`; orientationKey = 0"
                                class="relative transition-all rounded bg-primary-100 group hover:brightness-110">
                                <img draggable="false" class="h-[9rem]"
                                    :src="'/storage/images/icons/classes/bodies/unity/' + b.bodies[gender ? 'female' : 'male'][3].assetId.replace(/\d+$/, n => +n - 1) + '.png'" :alt="'{{ __('barbofus.contentNewAge') }} ' + b.name">
                                <p x-text="'{{ __('barbofus.contentNewAge') }} ' + b.name"
                                    class="absolute bottom-0 right-0 z-50 px-2 py-1 text-right transition-all translate-y-1/2 border opacity-0 bg-primary border-secondary whitespace-nowrap w-fit group-hover:opacity-100">
                                </p>
                            </button>
                        </template>
                    </div>

                    <button type="button" @click="showAnimationList = false"
                        class="absolute w-12 h-12 transition-all text-inactiveText hover:text-red-500 hover:scale-110 top-2 right-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
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
                                if(harn != null)
                                {
                                    if(mount != null) {
                                        const id = items['mount'];
                                        const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                                        if (radio) radio.checked = false;
                                    }

                                    const id = {
                                        dragodinde: 1,
                                        muldo: 2,
                                        volkorne: 3,
                                    }
                                    items['mount'] = id[harn.pet_type];
                                    const radio = document.querySelector(`input[type='radio'][data-id='${id[harn.pet_type]}']`);

                                    if (radio) radio.checked = true;
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
                                const id = items['pet'];
                                const radio = document.querySelector(`input[type='radio'][data-id='${id}']`);

                                if (radio) radio.checked = false;

                                items['pet'] = null;
                            }
                        }

                        editURLParam(getURLObject());
                     }">

                    <template
                        x-for="(allItem, index) in (
                              searchBar.length >= 3
                                ? filteredItems
                                : filteredItems.filter(i =>
                                    i.category === itemsCurrentTab &&
                                    (i.pet_type === petCurrentTab || i.pet_type === null)
                                  )
                            ).slice(0, maxItemVisible)"
                        :key="allItem.dofus_id">
                        <div class="h-fit group">
                            <input
                                :id="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem
                                    .subcategory == 'mimisymbic') ? 'mount' : allItem.category) + '_' + allItem
                                    .dofus_id"
                                :data-category="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem
                                    .subcategory == 'mimisymbic') ? 'mount' : allItem.category)"
                                :data-id="allItem.dofus_id" type="radio"
                                :name="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem
                                    .subcategory == 'mimisymbic') ? 'mount' : allItem.category)"
                                :value="allItem.dofus_id" class="hidden peer"
                                :checked="items[((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem
                                        .subcategory == 'mimisymbic') ? 'mount' : allItem.category)] === allItem
                                    .dofus_id">
                            <label
                                :for="((['dragodinde', 'muldo', 'volkorne'].includes(allItem.pet_type) && allItem
                                    .subcategory == 'mimisymbic') ? 'mount' : allItem.category) + '_' + allItem
                                    .dofus_id"
                                :title="allItem.name"
                                class="transition-all overflow-hidden relative rounded-md text-inactiveText border-2 hover:border-inactiveText bg-primary-100 cursor-pointer w-[max(min(4vw,5rem),3.8rem)] aspect-square flex justify-center items-center border-primary-100 peer-checked:text-secondary peer-checked:border-goldText"
                                x-data="{ loaded: false, intersected: false }">

                                <div :class="allItem.subcategory != 'mimisymbic' ? 'visible' : 'invisible'"
                                    class="absolute w-4 h-4 rotate-45 goldGradientTop -top-2 -left-2"></div>

                                {{-- Logo colorable --}}
                                <img src="{{ asset('storage/images/misc_ui/colorable_items_icon.png') }}"
                                    alt="Colorable item"
                                    :class="(allItem.colorable && loaded && intersected) ? 'visible' : 'invisible'"
                                    class="h-6 w-6 absolute bottom-0 right-0 min-[1501px]:bottom-1 min-[1501px]:right-1">

                                {{-- Bouton favoris --}}
                                <button type="button"
                                    class="h-4 w-4 min-[1501px]:h-6 min-[1501px]:w-6 absolute top-0 right-0 p-0 min-[1501px]:top-1 min-[1501px]:right-1 transition-all z-20"
                                    :class="favorites.includes(allItem.dofus_id) ? 'text-secondary' :
                                        'text-inactiveText opacity-0 group-hover:opacity-100'"
                                    @click="SwitchFavorite(allItem.dofus_id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="absolute top-0 z-10 transition-all hover:brightness-125">
                                        <path fill-rule="evenodd"
                                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="absolute top-0 transition-all scale-0"
                                        :class="(clicked === allItem.dofus_id) ? 'animate-onePing' : ''">
                                        <path fill-rule="evenodd"
                                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>


                                <div class="absolute flex gap-1 pointer-events-none">
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:0ms]"
                                        :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' :
                                            'opacity-0 invisible'">
                                    </div>
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:100ms]"
                                        :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' :
                                            'opacity-0 invisible'">
                                    </div>
                                    <div class="w-1.5 h-1.5 bg-inactiveText rounded-full transition-all duration-100 [animation-delay:200ms]"
                                        :class="!loaded && intersected ? 'opacity-100 visible animate-bounce' :
                                            'opacity-0 invisible'">
                                    </div>
                                </div>


                                <img loading="lazy" draggable="false" height="64" width="64"
                                    :src="'/storage/' + allItem.icon_path" :alt="allItem.name"
                                    class="relative z-10 mt-0 transition-opacity duration-300 delay-100"
                                    @load="loaded = true" x-intersect:enter="intersected = true"
                                    :class="(loaded && intersected) ? 'opacity-100' : 'opacity-0'">

                            </label>
                        </div>
                    </template>
                </div>

                <button type="button" x-cloak
                    :class="maxItemVisible < filteredItems.filter(i => i.category === itemsCurrentTab).length ? 'visible' :
                        'invisible'"
                    :disabled="maxItemVisible >= filteredItems.filter(i => i.category === itemsCurrentTab).length"
                    class="px-6 py-2 mx-auto my-4 transition-all rounded-md w-fit group bg-secondary text-primary hover:rounded-lg"
                    @click="maxItemVisible += 4800">
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

        function dE00(x1, x2, weights) {
            var sqrt = Math.sqrt;
            var pow = Math.pow;

            this.x1 = x1;
            this.x2 = x2;

            this.weights = weights || {};
            this.ksubL = this.weights.lightness || 1;
            this.ksubC = this.weights.chroma || 1;
            this.ksubH = this.weights.hue || 1;

            // Delta L Prime
            this.deltaLPrime = x2.L - x1.L;

            // L Bar
            this.LBar = (x1.L + x2.L) / 2;

            // C1 & C2
            this.C1 = sqrt(pow(x1.A, 2) + pow(x1.B, 2));
            this.C2 = sqrt(pow(x2.A, 2) + pow(x2.B, 2));

            // C Bar
            this.CBar = (this.C1 + this.C2) / 2;

            // A Prime 1
            this.aPrime1 = x1.A +
                (x1.A / 2) *
                (1 - sqrt(
                    pow(this.CBar, 7) /
                    (pow(this.CBar, 7) + pow(25, 7))
                ));

            // A Prime 2
            this.aPrime2 = x2.A +
                (x2.A / 2) *
                (1 - sqrt(
                    pow(this.CBar, 7) /
                    (pow(this.CBar, 7) + pow(25, 7))
                ));

            // C Prime 1
            this.CPrime1 = sqrt(
                pow(this.aPrime1, 2) +
                pow(x1.B, 2)
            );

            // C Prime 2
            this.CPrime2 = sqrt(
                pow(this.aPrime2, 2) +
                pow(x2.B, 2)
            );

            // C Bar Prime
            this.CBarPrime = (this.CPrime1 + this.CPrime2) / 2;

            // Delta C Prime
            this.deltaCPrime = this.CPrime2 - this.CPrime1;

            // S sub L
            this.SsubL = 1 + (
                (0.015 * pow(this.LBar - 50, 2)) /
                sqrt(20 + pow(this.LBar - 50, 2))
            );

            // S sub C
            this.SsubC = 1 + 0.045 * this.CBarPrime;

            /**
             * Properties set in getDeltaE method, for access to convenience functions
             */
            // h Prime 1
            this.hPrime1 = 0;

            // h Prime 2
            this.hPrime2 = 0;

            // Delta h Prime
            this.deltahPrime = 0;

            // Delta H Prime
            this.deltaHPrime = 0;

            // H Bar Prime
            this.HBarPrime = 0;

            // T
            this.T = 0;

            // S sub H
            this.SsubH = 0;

            // R sub T
            this.RsubT = 0;
        }

        /**
         * Returns the deltaE value.
         */
        dE00.prototype.getDeltaE = function() {
            var sqrt = Math.sqrt;
            var sin = Math.sin;
            var pow = Math.pow;

            // h Prime 1
            this.hPrime1 = this.gethPrime1();

            // h Prime 2
            this.hPrime2 = this.gethPrime2();

            // Delta h Prime
            this.deltahPrime = this.getDeltahPrime();

            // Delta H Prime
            this.deltaHPrime = 2 * sqrt(this.CPrime1 * this.CPrime2) * sin(this.degreesToRadians(this.deltahPrime) / 2);

            // H Bar Prime
            this.HBarPrime = this.getHBarPrime();

            // T
            this.T = this.getT();

            // S sub H
            this.SsubH = 1 + 0.015 * this.CBarPrime * this.T;

            // R sub T
            this.RsubT = this.getRsubT();

            // Put it all together!
            var lightness = this.deltaLPrime / (this.ksubL * this.SsubL);
            var chroma = this.deltaCPrime / (this.ksubC * this.SsubC);
            var hue = this.deltaHPrime / (this.ksubH * this.SsubH);

            return sqrt(
                pow(lightness, 2) +
                pow(chroma, 2) +
                pow(hue, 2) +
                this.RsubT * chroma * hue
            );
        };

        /**
         * Returns the RT variable calculation.
         */
        dE00.prototype.getRsubT = function() {
            var sin = Math.sin;
            var sqrt = Math.sqrt;
            var pow = Math.pow;
            var exp = Math.exp;

            return -2 *
                sqrt(
                    pow(this.CBarPrime, 7) /
                    (pow(this.CBarPrime, 7) + pow(25, 7))
                ) *
                sin(this.degreesToRadians(
                    60 *
                    exp(
                        -(
                            pow(
                                (this.HBarPrime - 275) / 25, 2
                            )
                        )
                    )
                ));
        };

        /**
         * Returns the T variable calculation.
         */
        dE00.prototype.getT = function() {
            var cos = Math.cos;

            return 1 -
                0.17 * cos(this.degreesToRadians(this.HBarPrime - 30)) +
                0.24 * cos(this.degreesToRadians(2 * this.HBarPrime)) +
                0.32 * cos(this.degreesToRadians(3 * this.HBarPrime + 6)) -
                0.20 * cos(this.degreesToRadians(4 * this.HBarPrime - 63));
        };

        /**
         * Returns the H Bar Prime variable calculation.
         */
        dE00.prototype.getHBarPrime = function() {
            var abs = Math.abs;

            if (abs(this.hPrime1 - this.hPrime2) > 180) {
                return (this.hPrime1 + this.hPrime2 + 360) / 2
            }

            return (this.hPrime1 + this.hPrime2) / 2
        };

        /**
         * Returns the Delta h Prime variable calculation.
         */
        dE00.prototype.getDeltahPrime = function() {
            var abs = Math.abs;

            // When either C′1 or C′2 is zero, then Δh′ is irrelevant and may be set to
            // zero.
            if (0 === this.C1 || 0 === this.C2) {
                return 0;
            }

            if (abs(this.hPrime1 - this.hPrime2) <= 180) {
                return this.hPrime2 - this.hPrime1;
            }

            if (this.hPrime2 <= this.hPrime1) {
                return this.hPrime2 - this.hPrime1 + 360;
            } else {
                return this.hPrime2 - this.hPrime1 - 360;
            }
        };

        /**
         * Returns the h Prime 1 variable calculation.
         */
        dE00.prototype.gethPrime1 = function() {
            return this._gethPrimeFn(this.x1.B, this.aPrime1);
        };

        /**
         * Returns the h Prime 2 variable calculation.
         */
        dE00.prototype.gethPrime2 = function() {
            return this._gethPrimeFn(this.x2.B, this.aPrime2);
        };

        /**
         * A helper function to calculate the h Prime 1 and h Prime 2 values.
         */
        dE00.prototype._gethPrimeFn = function(x, y) {
            var hueAngle;

            if (x === 0 && y === 0) {
                return 0;
            }

            hueAngle = this.radiansToDegrees(Math.atan2(x, y));

            if (hueAngle >= 0) {
                return hueAngle;
            } else {
                return hueAngle + 360;
            }
        };

        /**
         * Gives the radian equivalent of a specified degree angle.
         */
        dE00.prototype.radiansToDegrees = function(radians) {
            return radians * (180 / Math.PI);
        };

        /**
         * Gives the degree equivalent of a specified radian.
         */
        dE00.prototype.degreesToRadians = function(degrees) {
            return degrees * (Math.PI / 180);
        };

        const LocalFavorites = {
            key: 'favorites', // clé dans le localStorage

            // Lire les favoris depuis localStorage
            get() {
                const data = localStorage.getItem(this.key);
                try {
                    return data ? JSON.parse(data) : [];
                } catch {
                    console.warn("Impossible de parser les favoris dans le localStorage");
                    return [];
                }
            },

            // Sauvegarder les favoris dans localStorage
            save(favorites) {
                localStorage.setItem(this.key, JSON.stringify(favorites));
            },

            // Ajouter un favori
            add(id) {
                const favorites = this.get();
                if (!favorites.includes(id)) {
                    favorites.push(id);
                    this.save(favorites);
                }
            },

            // Supprimer un favori
            remove(id) {
                const favorites = this.get();
                const index = favorites.indexOf(id);
                if (index > -1) {
                    favorites.splice(index, 1);
                    this.save(favorites);
                }
            },

            // Vérifier si un item est favori
            has(id) {
                return this.get().includes(id);
            }
        };

        document.addEventListener("alpine:init", () => {
            Alpine.data("skinator", () => ({
                breedInfos: @json($breeds),
                allItems: @json($items),
                loadedItems: new Set(),
                filteredItems: null,
                breedHeads: null,
                breedBodies: null,
                maxItemVisible: 96,
                searchBar: '',
                copy: null,
                copyTimeout: null,
                possibleOrientation: [
                    [1, 3, 5, 7],
                    [1, 2, 3, 4, 5, 6, 7, 0],
                    [1, 3],
                ],
                orientationKey: 0,
                colorsLabel: [
                    '{{ __('barbofus.labelSkinColorsSkin') }}',
                    '{{ __('barbofus.labelSkinColorsHair') }}',
                    '{{ __('barbofus.labelSkinColorsClothes') }} 1',
                    '{{ __('barbofus.labelSkinColorsClothes') }} 2',
                    '{{ __('barbofus.labelSkinColorsClothes') }} 3',
                    '{{ __('barbofus.labelSkinColorsClothes') }} 4',
                    '{{ __('barbofus.labelSkinColorsGuild') }} 1',
                    '{{ __('barbofus.labelSkinColorsGuild') }} 2',
                ],
                colorsName: [
                    'skin',
                    'hair',
                    'cloth_1',
                    'cloth_2',
                    'cloth_3',
                    'cloth_4',
                    'guild_1',
                    'guild_2',
                ],
                shouldResetColors: false,
                charactersCurrentTab: 'breed',
                itemsCurrentTab: 'hat',
                petCurrentTab: 'familier',
                animationsCurrentTab: 'default',
                oldGender: 0,
                oldBreed: 1,
                gender: @json($skin ? $skin->gender : rand(0, 1)),
                breed: @json($skin ? $skin->race_id : $breeds[rand(0, $breeds->count() - 1)]->dofus_id),
                head: @json($skin?->face),
                body: @json($skin?->body),
                colors: {!! json_encode(
                    $skin
                        ? [
                            '#' . ltrim((string) $skin?->color_skin, '#'),
                            '#' . ltrim((string) $skin?->color_hair, '#'),
                            '#' . ltrim((string) $skin?->color_cloth_1, '#'),
                            '#' . ltrim((string) $skin?->color_cloth_2, '#'),
                            '#' . ltrim((string) $skin?->color_cloth_3, '#'),
                            '#' . ltrim((string) $skin?->color_cloth_4, '#'),
                        ]
                        : [],
                ) !!},
                guildColors: {!! json_encode(
                    $skin
                        ? ['#' . ltrim((string) $skin?->color_guild_1, '#'), '#' . ltrim((string) $skin?->color_guild_2, '#')]
                        : ['#241F1D', '#FAB420'],
                ) !!},
                animations: [{
                        shortName: @json(__('barbofus.AnimStatic')),
                        name: 'AnimStatiqueExplo0@1-static',
                        frame: 0,
                        orientation: 1
                    },
                    {
                        shortName: @json(__('barbofus.AnimCombat')),
                        name: 'Combat',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimWalk')),
                        name: 'Marche',
                        frame: 0,
                        orientation: 1
                    },
                    {
                        shortName: @json(__('barbofus.AnimRun')),
                        name: 'Course',
                        frame: 0,
                        orientation: 1
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteJuggle')),
                        name: 'AnimEmoteJuggle_Statique@AnimEmoteJuggle',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmotePaint')),
                        name: 'AnimEmotePaint@AnimEmotePaint',
                        frame: 66,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteCry')),
                        name: 'AnimEmoteCry@AnimEmoteCry',
                        frame: 24,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteBunnyhop')),
                        name: 'AnimEmoteBunnyhop@AnimEmoteBunnyhop',
                        frame: 17,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteCarnival')),
                        name: 'AnimEmoteCarnival_Statique@AnimEmoteCarnival',
                        frame: 0,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteSamourai')),
                        name: 'AnimEmoteSamourai@AnimEmoteSamourai',
                        frame: 31,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteSit')),
                        name: 'AnimEmoteSit_Statique@AnimEmoteSit',
                        frame: 0,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteWrite')),
                        name: 'AnimEmoteWrite_Statique@AnimEmoteWrite',
                        frame: 25,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteBoxing')),
                        name: 'AnimEmoteBoxing@AnimEmoteBoxing',
                        frame: 1,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteColor')),
                        name: 'AnimEmoteColor@AnimEmoteColor',
                        frame: 10,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteMad')),
                        name: 'AnimEmoteMad@AnimEmoteMad',
                        frame: 10,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteNoxine')),
                        name: 'AnimEmoteNoxine@AnimEmoteNoxine',
                        frame: 25,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteHeartbreak')),
                        name: 'AnimEmoteHeartbreak@AnimEmoteHeartbreak',
                        frame: 53,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteSwishswish')),
                        name: 'AnimEmoteSwishswish@AnimEmoteSwishswish',
                        frame: 5,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteBallon')),
                        name: 'AnimEmoteBallon@AnimEmoteBallon',
                        frame: 100,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteUlgrude')),
                        name: 'AnimEmoteUlgrude@AnimEmoteUlgrude',
                        frame: 60,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteKrosmose')),
                        name: 'AnimEmoteKrosmose@AnimEmoteKrosmose',
                        frame: 150,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteSlip20ans')),
                        name: 'AnimEmoteSlip20ans@AnimEmoteSlip20ans',
                        frame: 50,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteCross')),
                        name: 'AnimEmoteCross_Statique@AnimEmoteCross',
                        frame: 0,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteBehind')),
                        name: 'AnimEmoteBehind_Statique@AnimEmoteBehind',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteFear')),
                        name: 'AnimEmoteFear_Statique@AnimEmoteFear',
                        frame: 0,
                        orientation: 2
                    },
                    {
                        shortName: @json(__('barbofus.AnimEmoteOups')),
                        name: 'AnimEmoteOups@AnimEmoteOups',
                        frame: 27,
                        orientation: 0
                    },
                    {
                        shortName: 'Aegis',
                        name: 'AnimEmoteEtendardAgis_Statique@AnimEmoteEtendardAgis',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: 'Gentlemate',
                        name: 'AnimEmoteEtendardGentlemate_Statique@AnimEmoteEtendardGentlemate',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: 'KCorp',
                        name: 'AnimEmoteEtendardKCorp_Statique@AnimEmoteEtendardKCorp',
                        frame: 0,
                        orientation: 0
                    },
                    {
                        shortName: 'Solary',
                        name: 'AnimEmoteEtendardSolary_Statique@AnimEmoteEtendardSolary',
                        frame: 0,
                        orientation: 0
                    },
                ],
                showAnimationList: false,
                animation: 0,
                animationName: "",
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
                searchColor: null,
                showOnlyColorable: false,
                showOnlyMimisymbic: false,
                showOnlyCeremonial: false,
                showOnlyFavorite: false,
                clicked: -1,
                userId: @json(auth()->check() ? auth()->id() : -1),
                favorites: [],
                csrfToken: '{{ csrf_token() }}',
                useForMissSkin: @json($skin && $skin->status === 'MissSkin'),

                initWatcher() {
                    Alpine.effect(() => {
                        const data = this.getRendererObject();
                        const invertX = [3, 4, 7].includes(this.possibleOrientation[this
                            .animations[this.animation].orientation][this
                            .orientationKey
                        ]);

                        if (data !== this.previousData || invertX !== this.previousInvertX) {
                            this.previousData = data;
                            this.previousInvertX = invertX;

                            let interval = setInterval(() => {
                                if (window.updateRendererData) {
                                    window.updateRendererData(data, invertX);
                                    window.resetDefaultColors()
                                    clearInterval(interval);
                                }
                            }, 50);
                        }
                    });
                },

                init() {
                    console.log(this.breedInfos)
                    if (this.userId > -1) {
                        this.favorites = @json(auth()->user()?->favorites()->pluck('item_id'));
                    } else {
                        this.favorites = LocalFavorites.get();
                    }

                    this.SortFavorites();

                    if (this.head == null) {
                        this.head = this.updateHead(this.gender, this.breed);
                    }

                    if (this.body === 0) {
                        this.body = this.getFirstBody(this.gender, this.breed);
                    }

                    if (this.body == null) {
                        this.body = this.updateBody(this.gender, this.breed);
                    }

                    this.breedHeads = this.updateHeads(this.gender, this.breed);
                    this.breedBodies = this.updateBodies(this.gender, this.breed);
                    this.updateFilteredItems();

                    if (getDataFromURL()) {
                        this.getAlpineDataFromURL(getDataFromURL())
                    } else {
                        if (this.colors.length == 0) {
                            this.colors = this.getDefaultColor(this.gender, this.breed);
                        }
                        editURLParam(this.getURLObject())
                    }
                },

                SortFavorites() {
                    // Trier les items : les favoris d'abord
                    this.allItems.sort((a, b) => {
                        const aFav = this.favorites.includes(a.dofus_id);
                        const bFav = this.favorites.includes(b.dofus_id);

                        if (aFav && !bFav) return -1; // a est favori → passe avant
                        if (!aFav && bFav) return 1; // b est favori → passe avant
                        return 0; // sinon, garde l’ordre
                    });
                },

                SwitchFavorite(id) {
                    this.clicked = id;

                    (!this.favorites.includes(id)) ? this.addFavorite(id): this.removeFavorite(id);
                    this.SortFavorites();
                    setTimeout(() => this.clicked = -1, 500);
                },

                async addFavorite(id) {
                    this.favorites.push(id);

                    if (this.userId > -1) {
                        try {
                            const response = await fetch("/favorites", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": this.csrfToken,
                                },
                                body: JSON.stringify({
                                    item_id: id,
                                }),
                            });

                            // 🚨 Vérifie le statut
                            if (!response.ok) {
                                let message = `Erreur serveur (${response.status})`;
                                try {
                                    const data = await response.json();
                                    if (data?.message) message = data.message;
                                } catch {}
                                throw new Error(message);
                            }
                        } catch (error) {
                            console.error("%cErreur lors de l’ajout du favori :", "color: #ef4444;",
                                error);
                            // rollback
                            const index = this.favorites.indexOf(id);
                            if (index > -1) this.favorites.splice(index, 1);
                        }
                    } else {
                        LocalFavorites.add(id);
                        this.favorites = LocalFavorites.get();
                    }
                },

                async removeFavorite(id) {
                    const index = this.favorites.indexOf(id);
                    if (index > -1) {
                        this.favorites.splice(index, 1);
                    }

                    if (this.userId > -1) {
                        try {
                            const response = await fetch("/favorites", {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": this.csrfToken,
                                },
                                body: JSON.stringify({
                                    item_id: id,
                                }),
                            });

                            // 🚨 Vérifie le statut
                            if (!response.ok) {
                                let message = `Erreur serveur (${response.status})`;
                                try {
                                    const data = await response.json();
                                    if (data?.message) message = data.message;
                                } catch {}
                                throw new Error(message);
                            }
                        } catch (error) {
                            console.error("%cErreur lors de la suppression du favori :",
                                "color: #ef4444;", error);
                            // rollback
                            if (!this.favorites.includes(id)) this.favorites.push(id);
                        }
                    } else {
                        LocalFavorites.remove(id);
                        this.favorites = LocalFavorites.get();
                    }
                },

                getAlpineDataFromURL(json) {
                    this.breed = json.breed;
                    this.gender = json.gender;
                    this.head = json.head;
                    this.body = json.body;
                    this.breedHeads = this.updateHeads(json.gender, json.breed);
                    this.breedBodies = this.updateBodies(json.gender, json.breed);
                    const allColors = json.colors.map(color =>
                        `#${color.toString(16).padStart(6, '0')}`);

                    // Sécurité pour les URLs avec seulement 6 couleurs (sans couleurs de guilde)
                    if (allColors.length === 6) {
                        this.colors = allColors; // Toutes les 6 couleurs
                        this.guildColors = ['#241F1D', '#FAB420']; // Couleurs de guilde par défaut
                    } else if (allColors.length >= 8) {
                        this.colors = allColors.slice(0, -
                            2); // Toutes les couleurs sauf les 2 dernières
                        this.guildColors = allColors.slice(-2); // Les 2 dernières couleurs
                    } else {
                        // Fallback pour d'autres cas
                        this.colors = allColors;
                        this.guildColors = ['#241F1D', '#FAB420'];
                    }

                    this.items = json.items;
                },

                getURLObject() {
                    return JSON.stringify(shortenKeys({
                        gender: this.gender,
                        breed: this.breed,
                        head: this.head,
                        ...(this.body !== 0 && { body: this.body }),
                        colors: [...this.colors, ...this.guildColors].map(color =>
                            typeof color === 'string' ? parseInt(color.replace('#', ''),
                                16) : color
                        ),
                        items: this.items,
                    }));
                },

                getRendererObject() {
                    return JSON.stringify({
                        head: this.head,
                        ...(this.body !== 0 && { body: this.body }),
                        orientation: this.possibleOrientation[this.animations[this.animation]
                            .orientation][this.orientationKey],
                        animation: this.getAnimation(),
                        items: Object.entries(this.items)
                            .map(([key, value]) => {
                                if (!value) return null;
                                if (key === 'mount') return null;

                                return this.items[key];
                            })
                            .filter(Boolean),
                        mount: this.items.mount ? this.allItems.find(i => i.dofus_id === this
                            .items.mount).asset_id : null,
                        cameleon: this.items.mount ? ([1, 2, 3].includes(this.items.mount)) :
                            false,
                        animated: this.animated
                    }, null, 2);
                },

                getAnimation() {
                    if(this.animationsCurrentTab === "default") {
                        return this.animations[this.animation].name
                    }

                    return this.animationName
                },

                updateAlpineHead() {
                    this.head = this.updateHead(this.gender, this.breed);
                    this.breedHeads = this.updateHeads(this.gender, this.breed);

                    if (this.shouldResetColors) {
                        this.colors = this.getDefaultColor(this.gender, this.breed);
                        this.shouldResetColors = false;
                    }

                    editURLParam(this.getURLObject())

                    window.resetColors()
                },

                updateAlpineBody() {
                    this.body = this.updateBody(this.gender, this.breed);
                    this.breedBodies = this.updateBodies(this.gender, this.breed);

                    if (this.shouldResetColors) {
                        this.colors = this.getDefaultColor(this.gender, this.breed);
                        this.shouldResetColors = false;
                    }

                    editURLParam(this.getURLObject())

                    window.resetColors()
                },

                copyToClipboard(toCopy, name) {
                    if (this.copyTimeout) {
                        clearTimeout(this.copyTimeout);
                    }

                    this.copy = name;
                    navigator.clipboard.writeText(toCopy);

                    this.copyTimeout = setTimeout(() => {
                        this.copy = null;
                        this.copyTimeout = null;
                    }, 1000);
                },

                checkIfDefaultColors(gender, breed, colors) {
                    let count = 0;
                    const defaultColors = this.getDefaultColor(gender, breed)

                    colors.forEach((color, index) => {
                        if (defaultColors[index].toUpperCase() == color.toUpperCase()) count++
                    })

                    return count === colors.length
                },

                rgb2lab(rgb) {
                    let r = rgb[0] / 255,
                        g = rgb[1] / 255,
                        b = rgb[2] / 255,
                        x, y, z;

                    r = (r > 0.04045) ? Math.pow((r + 0.055) / 1.055, 2.4) : r / 12.92;
                    g = (g > 0.04045) ? Math.pow((g + 0.055) / 1.055, 2.4) : g / 12.92;
                    b = (b > 0.04045) ? Math.pow((b + 0.055) / 1.055, 2.4) : b / 12.92;

                    x = (r * 0.4124 + g * 0.3576 + b * 0.1805) / 0.95047;
                    y = (r * 0.2126 + g * 0.7152 + b * 0.0722) / 1.00000;
                    z = (r * 0.0193 + g * 0.1192 + b * 0.9505) / 1.08883;

                    x = (x > 0.008856) ? Math.pow(x, 1 / 3) : (7.787 * x) + 16 / 116;
                    y = (y > 0.008856) ? Math.pow(y, 1 / 3) : (7.787 * y) + 16 / 116;
                    z = (z > 0.008856) ? Math.pow(z, 1 / 3) : (7.787 * z) + 16 / 116;

                    return [(116 * y) - 16, 500 * (x - y), 200 * (y - z)]
                },

                updateFilteredItems() {
                    let filteredItems = this.allItems;

                    if (this.searchBar.length >= 3) {
                        filteredItems = this.allItems.filter(i =>
                            removeAccents(i.name).toLowerCase().includes(removeAccents(this
                                .searchBar).toLowerCase())
                        );
                    }

                    if (this.showOnlyFavorite) {
                        filteredItems = filteredItems.filter(i => this.favorites.includes(i.dofus_id));
                    }

                    if (this.showOnlyColorable) {
                        filteredItems = filteredItems.filter(i => i.colorable);
                    }

                    if (this.showOnlyMimisymbic & !this.showOnlyCeremonial) {
                        filteredItems = filteredItems.filter(i => i.subcategory === 'mimisymbic');
                    }

                    if (this.showOnlyCeremonial & !this.showOnlyMimisymbic) {
                        filteredItems = filteredItems.filter(i => i.subcategory === 'ceremonial' || i
                            .subcategory === 'livingObject');
                    }

                    if (this.searchColor !== null) {
                        const searchColor = [
                            parseInt(this.searchColor.slice(1, 3), 16),
                            parseInt(this.searchColor.slice(3, 5), 16),
                            parseInt(this.searchColor.slice(5, 7), 16)
                        ];
                        const searchColorLab = this.rgb2lab(searchColor);

                        filteredItems = filteredItems.map(i => {
                            const dofusId = i.dofus_id;
                            // DEBUG REWRITE KOLORS
                            const kolors = i
                                .kolors // this.itemsKolors.find(k => k.itemId == dofusId)?.kolors;

                            if (kolors == null || kolors == []) return {
                                ...i,
                                minDist: Infinity
                            };
                            if (i.colorable) return {
                                ...i,
                                minDist: Infinity
                            };

                            let minDist = Infinity;
                            kolors.forEach((kolor) => {

                                const kolorLab = this.rgb2lab([
                                    parseInt(kolor.slice(0, 2), 16),
                                    parseInt(kolor.slice(2, 4), 16),
                                    parseInt(kolor.slice(4, 6), 16)
                                ]);
                                // const alpha = parseInt(kolor.slice(6, 8), 16) / 255;

                                const de00 = new dE00({
                                    L: kolorLab[0],
                                    A: kolorLab[1],
                                    B: kolorLab[2]
                                }, {
                                    L: searchColorLab[0],
                                    A: searchColorLab[1],
                                    B: searchColorLab[2]
                                })
                                const newDist = de00.getDeltaE();
                                if (newDist < minDist) {
                                    minDist = newDist;
                                }

                            })

                            return {
                                ...i,
                                minDist: minDist,
                            };
                        });

                        filteredItems = filteredItems
                            .sort((a, b) => a.minDist - b.minDist)
                    }

                    this.filteredItems = filteredItems;
                    this.maxItemVisible = 96;
                },

                updateHead(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    const heads = currentBreed.heads[gender === 0 ? 'male' : 'female']
                    const keys = Object.keys(heads)
                    const randKey = keys[Math.floor(Math.random() * keys.length)]
                    return currentBreed ? heads[randKey].id : 1
                },

                updateHeads(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    return currentBreed ? currentBreed.heads[gender === 0 ? 'male' : 'female'] : 1
                },

                getFirstBody(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    const bodies = currentBreed.bodies[gender === 0 ? 'male' : 'female']
                    const keys = Object.keys(bodies)
                    return currentBreed ? bodies[keys[0]].id : 1
                },

                updateBody(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    const bodies = currentBreed.bodies[gender === 0 ? 'male' : 'female']
                    const keys = Object.keys(bodies)
                    const randKey = keys[Math.floor(Math.random() * keys.length)]
                    return currentBreed ? bodies[randKey].id : 1
                },

                updateBodies(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed)
                    return currentBreed ? currentBreed.bodies[gender === 0 ? 'male' : 'female'] : 1
                },

                getDefaultColor(gender, breed) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed);

                    if (currentBreed) {
                        // Applique la fonction decimalToHex à chaque couleur de colors[gender]
                        return currentBreed.colors[gender === 0 ? 'male' : 'female'].map(decimalToHex);
                    }

                    return [];
                },

                getOneDefaultColor(gender, breed, index) {
                    const currentBreed = this.breedInfos.find(b => b.dofus_id === breed);

                    if (currentBreed) {
                        // Applique la fonction decimalToHex à chaque couleur de colors[gender]
                        return decimalToHex(currentBreed.colors[gender === 0 ? 'male' : 'female'][
                            index
                        ]);
                    }

                    return '#FFFFFF';
                },

                getOneRandomColor() {
                    const randomDecimal = Math.floor(Math.random() *
                        0xFFFFFF); // Nombre aléatoire entre 0 et 16777215
                    return '#' + randomDecimal.toString(16).padStart(6, '0').toUpperCase();
                },

                getRandomItems() {
                    const categories = [
                        "hat",
                        "cape",
                        "shield",
                        "pet",
                        "shoulderpads",
                        "wings",
                        "costume",
                    ];

                    let filteredItemsIds = [];

                    this.allItems.forEach((item) => {
                        const dofusId = item.dofus_id;
                        const kolors = item.kolors;

                        if (item.colorable) {
                            filteredItemsIds.push(dofusId);
                            return;
                        }

                        if (!kolors || kolors.length === 0) return;

                        const shouldAdd = this.colors.slice(2).some((color) => {
                            const searchColor = [
                                parseInt(color.slice(1, 3), 16),
                                parseInt(color.slice(3, 5), 16),
                                parseInt(color.slice(5, 7), 16)
                            ];
                            const searchColorLab = this.rgb2lab(searchColor);

                            let minDist = Infinity;

                            for (const kolor of kolors) {
                                const kolorLab = this.rgb2lab([
                                    parseInt(kolor.slice(0, 2), 16),
                                    parseInt(kolor.slice(2, 4), 16),
                                    parseInt(kolor.slice(4, 6), 16)
                                ]);

                                const de00 = new dE00({
                                    L: kolorLab[0],
                                    A: kolorLab[1],
                                    B: kolorLab[2]
                                }, {
                                    L: searchColorLab[0],
                                    A: searchColorLab[1],
                                    B: searchColorLab[2]
                                });
                                const dist = de00.getDeltaE();
                                if (dist < minDist) {
                                    minDist = dist;
                                }
                            }

                            return minDist < 10;
                        });

                        if (shouldAdd) {
                            filteredItemsIds.push(dofusId);
                        }
                    });

                    const searchItems = this.allItems.filter(i => filteredItemsIds.includes(i
                        .dofus_id));

                    categories.forEach(category => {
                        // Filtrer les items correspondant à la catégorie
                        let filtered = searchItems.filter(item => item.category === category);

                        if (category === 'pet') {
                            filtered = filtered.filter(item => ['familier', 'montilier']
                                .includes(item.pet_type));
                        }

                        // Vérifier s'il y a des items dans cette catégorie
                        if (filtered.length === 0) return;

                        // Choisir un item aléatoire
                        let randomItem = filtered[Math.floor(Math.random() * filtered.length)];

                        // Pour shoulderpads, wings, costume : chance sur 3
                        if (["shoulderpads", "wings", "costume"].includes(category)) {
                            if (Math.random() > 1 / 3) randomItem =
                                null; // 2 fois sur 3 on saute
                        }

                        this.items[category] = (randomItem) ? randomItem.dofus_id : null;
                    });

                    editURLParam(this.getURLObject());
                },
            }));
        });

        const colorTab = document.getElementById('color-tab')
        const mapKeys = {
            gender: "1",
            breed: "2",
            head: "3",
            colors: "4",
            items: "5",
            hat: "6",
            cape: "7",
            shield: "8",
            pet: "9",
            costume: "10",
            shoulderpads: "11",
            wings: "12",
            mount: "13"
        };

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

        function getInputPosition(index) {
            const input = document.getElementById('color-' + index);

            let x = input.getBoundingClientRect().x - colorTab.getBoundingClientRect().x;
            let y = input.getBoundingClientRect().y + input.getBoundingClientRect().height - colorTab
                .getBoundingClientRect().y;

            return {
                x,
                y
            }
        }

        function editURLParam(json) {
            const compressed = LZString.compressToEncodedURIComponent(json);
            const params = new URLSearchParams(window.location.search);
            params.set('s', compressed);

            const url = new URL(window.location.href);
            url.search = "";

            const newUrl = url + '?' + params.toString();
            window.history.pushState({
                path: newUrl
            }, '', newUrl);
        }

        function getDataFromURL() {
            const params = new URLSearchParams(window.location.search);
            const compressed = params.get('s');
            if (!compressed) return null;

            return expandKeys(JSON.parse(LZString.decompressFromEncodedURIComponent(compressed)));
        }

        function hexToHsl(hex) {
            hex = hex.replace(/^#/, '');
            let r = parseInt(hex.slice(0, 2), 16) / 255;
            let g = parseInt(hex.slice(2, 4), 16) / 255;
            let b = parseInt(hex.slice(4, 6), 16) / 255;

            let max = Math.max(r, g, b),
                min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0;
            } else {
                let d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

                switch (max) {
                    case r:
                        h = ((g - b) / d + (g < b ? 6 : 0));
                        break;
                    case g:
                        h = ((b - r) / d + 2);
                        break;
                    case b:
                        h = ((r - g) / d + 4);
                        break;
                }
                h *= 60;
            }

            return {
                h,
                s,
                l
            };
        }

        function colorDistanceHSL(hex1, hex2, weights = {
            h: 30,
            s: 1,
            l: 2
        }) {
            const c1 = hexToHsl(hex1);
            const c2 = hexToHsl(hex2);

            const hueDiff = Math.min(Math.abs(c1.h - c2.h), 360 - Math.abs(c1.h - c2.h)) / 180; // normalisé [0–1]
            const satDiff = Math.abs(c1.s - c2.s); // [0–1]
            const lightDiff = Math.abs(c1.l - c2.l); // [0–1]

            return (
                Math.sqrt(
                    weights.h * hueDiff ** 2 +
                    weights.s * satDiff ** 2 +
                    weights.l * lightDiff ** 2
                )
            );
        }

        window.getDataFromURL = function() {
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
        import {
            FFmpeg
        } from '/storage/package/@ffmpeg/ffmpeg/dist/esm/index.js';


        class SkinRenderer {

            static skinRendererProto = null
            static async decodeData(data) {
                if (!SkinRenderer.skinRendererProto) {
                    const root = await protobuf.load('/storage/proto/skin.proto')
                    SkinRenderer.skinRendererProto = root.lookupType("SkinRenderer")
                }
                return SkinRenderer.skinRendererProto.decode(new Uint8Array(data))
            }

            static GetSourceVertexShader() {
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

            static GetSourceFragmentShader() {
                return `
          precision mediump float;

          varying vec2 vTexCoord;
          uniform sampler2D u_texture;
          uniform vec3 u_mainColor;
          uniform vec3 u_additiveColor;
          uniform float u_Opacity;


          void main() {
            vec4 texColor = texture2D(u_texture, vec2(vTexCoord.s, 1.0 - vTexCoord.t));

            texColor.rgb *= u_mainColor.rgb;
            texColor.rgb += u_additiveColor;
            texColor.rgb *= (texColor.a * u_Opacity);

            texColor.a *= u_Opacity;
            gl_FragColor = texColor;
          }
        `
            }


            constructor($canvas) {
                this.$canvas = $canvas
                this.$parent = $canvas.parentElement
                this.$svgLogo = this.$parent.querySelector('.loading-logo')
                this.$progressGradient = this.$svgLogo.querySelector('#progress-gradient')
                this.gl = this.$canvas.getContext('webgl2', {
                    alpha: true,
                    antialias: true,
                    depth: false,
                    preserveDrawingBuffer: true,
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

                this.colors = [0xe59b68, 0x773f29, 0xd8742e, 0x496352, 0x512a15, 0x5b5243, 0x512a15, 0x5b5243]
                this.indexFocusColor = null

                // OpenGL
                this.program = null
                this.uMainColor = null
                this.uAdditiveColor = null
                this.uOpacity = null
                this.uInvertX = null
                this.positionsBuffer = null
                this.uvsBuffer = null
                this.indicesBuffer = null
                this.textures = []
                this.cacheTexture = @json($itemsCache)


            }


            async setData(data, invX = false) {

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
            __animate(currentTime) {
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

            start() {
                if (!this.data) return
                this.indexFrame = 0
                this.lastTime = 0
                this.__running = true
                this.draw()
                requestAnimationFrame(this.__animate.bind(this))
            }

            stop() {
                this.__running = false
                this.unloadTextures()
            }

            // ======================================================================
            // ==== Export de l'animation ====
            // ======================================================================
            async downloadAnimation() {
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



                const ffmpeg = new FFmpeg({
                    log: false
                });
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
                ffmpeg.on('progress', ({
                    progress,
                    time
                }) => {
                    fakeProgress = Math.min(fakeProgress + fakeProgressStep, 1)
                    this.setProgress(fakeProgress)
                });

                await ffmpeg.exec([
                    '-framerate', '30', // 30 fps
                    '-i', 'frame%03d.webp', // frame000.webp, frame001.webp, etc.
                    '-loop', '0', // boucle infinie
                    '-c:v', 'libwebp_anim', // encoder en WebP animé
                    '-quality', '100', // Meilleure qualité pour l'export (100%)
                    'out.webp' // sortie
                ])
                const data = await ffmpeg.readFile('out.webp');
                const blob = new Blob([data], {
                    type: 'video/webm'
                });
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
            }

            async downloadImage(frame) {
                return new Promise(async (resolve, reject) => {
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 1080
                    this.$canvas.height = 1080
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()

                    this.indexFrame = frame

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

            async copyImage(frame) {
                return new Promise(async (resolve, reject) => {
                    this.__running = false

                    const originalWidth = this.$canvas.width
                    const originalHeight = this.$canvas.height

                    this.$canvas.width = 1080
                    this.$canvas.height = 1080
                    this.$canvas.style.width = originalWidth + 'px'
                    this.$canvas.style.height = originalHeight + 'px'
                    this.__updateViewport()

                    this.indexFrame = frame

                    this.draw()
                    const url = this.$canvas.toDataURL('image/png');


                    this.$canvas.width = originalWidth
                    this.$canvas.height = originalHeight

                    this.$canvas.style.width = 'initial'
                    this.$canvas.style.height = 'initial'

                    this.__updateViewport()

                    this.start()

                    const blob = await (await fetch(url)).blob();
                    const item = new ClipboardItem({
                        'image/png': blob
                    });
                    await navigator.clipboard.write([item]);
                })

            }

            async showSharePrevImage() {
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

            async fillShareInputImage() {
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
            static GetAlternativeColor(r, g, b) {
                return (r > 0.4 && r < 0.6 && g > 0.4 && g < 0.6 && b > 0.4 && b < 0.6) ? [1, 0, 1] : [1 - r, 1 - g, 1 -
                    b
                ]
            }
            setColors(colors) {
                this.colors = colors
            }
            setColorIndex(index, color) {
                this.colors[index] = color
            }
            setColorFocusIndex(index) {
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

                    const [category, filename] = url.includes("/") ? url.split("/") : url.split("\\");
                    const id = filename.split('.')[0] ?? "0";

                    const itemCache = this.cacheTexture[category][id] ?? 123456;
                    const textureVersion = '?v=' + itemCache;
                    url = url.replace('skins', 'skins_webp')
                        .replace('bones', 'bones_webp')
                        .replace('.png', '.webp')

                    img.src = '/storage/images/skinator/' + url + textureVersion;
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
                const uAdditiveColor = gl.getUniformLocation(program, 'u_additiveColor')

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
            draw() {
                const gl = this.gl
                const data = this.data
                const program = this.program
                const uMainColor = this.uMainColor
                const uAdditiveColor = this.uAdditiveColor
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
                        if (((this.indexFrame >> 3) & 1)) {
                            lColor[i] = SkinRenderer.GetAlternativeColor(r, g, b)
                        } else {
                            lColor[i] = [r, g, b]
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


                    let alpha = part.alpha ?? 1.0

                    if (customColor) {

                        // const additiveColor = part.additiveColor ?? 0x7F7F7F7F
                        const multiplicativeColor = part.multiplicativeColor ?? 0x7F7F7F7F
                        const mr = ((multiplicativeColor >> 0x10) & 0xFF) / 0x40;
                        const mg = ((multiplicativeColor >> 0x08) & 0xFF) / 0x40;
                        const mb = ((multiplicativeColor >> 0x00) & 0xFF) / 0x40;

                        gl.uniform3fv(uMainColor, [mr * customColor[0], mg * customColor[1], mb * customColor[2]]);
                        gl.uniform3fv(uAdditiveColor, [0, 0, 0]);
                    } else {


                        const multiplicativeColor = part.multiplicativeColor ?? 0x00000000
                        const mr = ((multiplicativeColor >> 0x10) & 0xFF) / 0x7F;
                        const mg = ((multiplicativeColor >> 0x08) & 0xFF) / 0x7F;
                        const mb = ((multiplicativeColor >> 0x00) & 0xFF) / 0x7F;

                        const additiveColor = part.additiveColor ?? 0
                        let aa = ((additiveColor >> 0x18) & 0xFF) / 0xFF;
                        let ar = ((additiveColor >> 0x10) & 0xFF) / 0xFF;
                        let ag = ((additiveColor >> 0x08) & 0xFF) / 0xFF;
                        let ab = ((additiveColor >> 0x00) & 0xFF) / 0xFF;

                        if (aa) {
                            alpha = alpha - (aa / 2)
                        }

                        gl.uniform3fv(uMainColor, [1, 1, 1]);
                        gl.uniform3fv(uAdditiveColor, [ar, ag, ab]);
                    }


                    gl.uniform1f(uOpacity, alpha)

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

                    gl.drawElements(gl.TRIANGLES, indices.length, gl.UNSIGNED_SHORT, 0);
                }
            }

            // ======================================================================
            // ==== Autre / Loader / Ratio Viewport ====
            // ======================================================================
            async setLoading(loading) {
                if (loading) {
                    this.$parent.classList.add('loading')
                    this.$svgLogo.style.display = 'block'
                } else {
                    this.$parent.classList.remove('loading')
                    this.$svgLogo.style.display = 'none'
                }
            }
            async setProgress(progress) {
                const stops = this.$progressGradient.querySelectorAll('stop')
                stops[1].setAttribute('offset', `${progress * 100}%`)
                stops[2].setAttribute('offset', `${progress * 100}%`)
            }
            async __updateViewport() {
                const gl = this.gl
                const {
                    maxX,
                    maxY,
                    minX,
                    minY
                } = this.data.bounds
                const height = this.$canvas.height
                const width = this.$canvas.width
                let ratio = width / height

                console.log({
                    maxX,
                    ratio
                })

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

        /*const urlData = window.getDataFromURL();
        skinRenderer.setColors(urlData.colors)*/

        window.resetColors = function() {
            const urlData = window.getDataFromURL();
            let colors = urlData.colors;

            // Si seulement 6 couleurs, ajouter les couleurs de guilde par défaut
            if (colors.length === 6) {
                colors = [...colors, 0x241F1D, 0xFAB420]; // Ajouter les couleurs de guilde par défaut
            }

            skinRenderer.stop()
            skinRenderer.setColors(colors)
        };

        window.resetDefaultColors = function() {
            const urlData = window.getDataFromURL();
            let colors = urlData.colors;

            // Si seulement 6 couleurs, ajouter les couleurs de guilde par défaut
            if (colors.length === 6) {
                colors = [...colors, 0x241F1D, 0xFAB420]; // Ajouter les couleurs de guilde par défaut
            }

            skinRenderer.setColors(colors)
        };

        window.updateRendererData = function(data, invX) {
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
                const response = await fetch('https://skinator.barbofus.com/renderer', {
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
        document.querySelector('#btnExportAnim').addEventListener('click', async (e) => {
            // Génère l'image
            let data = JSON.parse(skinRenderer.rendererData);
            if (data.animated === true) {
                skinRenderer.downloadAnimation()
            } else {
                data.animated = true;
                await UpdateRenderer(JSON.stringify(data, null, 2), false);

                await skinRenderer.downloadAnimation()

                data.animated = false;
                await UpdateRenderer(JSON.stringify(data, null, 2), false);
            }
        })

        document.querySelector('#btnExport').addEventListener('click', (e) => {
            const frame = window.skinator.animations[window.skinator.animation].frame;
            skinRenderer.downloadImage(frame)
        })

        document.querySelector('#btnCopyImg').addEventListener('click', (e) => {
            const frame = window.skinator.animations[window.skinator.animation].frame;
            skinRenderer.copyImage(frame)
        })

        document.querySelector('#btnShare').addEventListener('click', async (e) => {
            let data = JSON.parse(skinRenderer.rendererData);
            data.orientation = 1;
            data.animation = 'Static';

            // Affiche le loader
            const loader = document.getElementById('shareLoader');
            if (loader) {
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
            if (loader) {
                loader.classList.remove('animate-customSpin');
                loader.classList.add('opacity-0');
            }
        })

        window.generateFinalInputImage = async function() {

            // Génère l'image
            let data = JSON.parse(skinRenderer.rendererData);
            data.orientation = 1;
            data.animation = 'Static';

            await UpdateRenderer(JSON.stringify(data, null, 2), false);

            const url = await skinRenderer.fillShareInputImage();
            const blob = await (await fetch(url)).blob();
            const file = new File([blob], 'webgl-image.png', {
                type: 'image/png'
            });

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
