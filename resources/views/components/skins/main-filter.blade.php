<div id="left-section"
     x-data="{
              showFilter: (window.innerWidth > 1500),
              showLive: (window.innerHeight > 700),
            }"
     @resize.window="
              if(window.innerWidth > 1500) showFilter = true;
              showLive=!(window.innerWidth <= 1500 && showFilter);"
     :class="showFilter ? ' max-[900px]:fixed max-[900px]:top-0 max-[900px]:left-0 max-[900px]:z-40 max-[900px]:pt-8 max-[900px]:pb-16 max-[900px]:overflow-x-hidden max-[900px]:overflow-y-scroll min-[901px]:top-32' : 'top-32 [@media(min-height:701px)_and_(max-width:501px)]:top-28 min-[501px]:top-48 min-[851px]:top-32'"
     class="flex sticky flex-col w-full h-full items-center z-20 row-start-2 bg-primary
            max-[1500px]:shadow-lg min-[1501px]:z-10
            [@media(max-height:500px)_and_(max-width:900px)]:invisible
            min-[1501px]:min-h-[calc(100vh-15vh-theme(spacing.14))] min-[1501px]:max-h-[calc(100vh-theme(spacing.14))] min-[1501px]:top-12 min-[1501px]:row-span-2">



    <!-- Header -->
    <div class="flex py-3 items-end justify-center transition-all duration-150 group
              max-[1500px]:cursor-pointer max-[1500px]:bg-primary-100 max-[1500px]:w-[18.125rem] max-[1500px]:rounded-lg max-[1500px]:shadow-md
              min-[1501px]:justify-start min-[1501px]:pl-10 min-[1501px]:h-[4rem]"
         @click="if(window.innerWidth <= 1500) {showFilter = !showFilter; if(window.innerHeight > 700) showLive = !showFilter}">
        <div class="flex items-center transition-all duration-150"
             :class="showFilter ? 'max-[1500px]:group-hover:-translate-y-1' : 'max-[1500px]:group-hover:translate-y-1'">
            <div class="relative w-10 h-10">
                <svg class="absolute top-0 left-0 w-10 fill-secondary invisible min-[1501px]:visible"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M17 2.75a.75.75 0 00-1.5 0v5.5a.75.75 0 001.5 0v-5.5zM17 15.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM3.75 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zM4.5 2.75a.75.75 0 00-1.5 0v5.5a.75.75 0 001.5 0v-5.5zM10 11a.75.75 0 01.75.75v5.5a.75.75 0 01-1.5 0v-5.5A.75.75 0 0110 11zM10.75 2.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10 6a2 2 0 100 4 2 2 0 000-4zM3.75 10a2 2 0 100 4 2 2 0 000-4zM16.25 10a2 2 0 100 4 2 2 0 000-4z" />
                </svg>

                <svg class="rotate-180 absolute top-1 left-0 w-8 text-secondary min-[1501px]:invisible transition-all duration-150" viewBox="256 256 512 512" fill="currentColor"
                     :class="showFilter ? 'rotate-0' : 'rotate-180'">
                    <path d="m512 256 144.8 144.8-36.2 36.2-83-83v311.6h-51.2V354l-83 83-36.2-36.2L512      256zM307.2 716.8V768h409.6v-51.2H307.2z"/>
                </svg>

            </div>

            <p class="ml-2 text-[1.35rem] text-secondary font-medium tracking-wide">Affine ta recherche</p>
        </div>

    </div>



    <!-- Container -->
    <div x-show="showFilter" x-transition class="bg-primary relative z-[51] w-full flex flex-col py-4 pl-6
              max-[900px]:h-[100vh]
              min-[901px]:flex-row min-[901px]:justify-center min-[901px]:gap-x-8 min-[901px]:pl-0
              max-[1500px]:shadow-lg
              min-[1501px]:flex-col min-[1501px]:max-h-[37.5rem] min-[1501px]:border-r-2 min-[1501px]:border-ivory min-[1501px]:pl-6 min-[1501px]:pt-0 min-[1501px]:pb-4">

        <!-- Bottom border -->
        <div class="absolute h-full top-0 left-[10%] w-[80%] border-b-4 border-secondary invisible
                min-[901px]:visible
                min-[1501px]:invisible"></div>


        <!-- First part -->
        <div class="pl-0
                min-[901px]:pl-6
                min-[1501px]:pl-0">


            <!-- SearchBar -->
            <div>
                <livewire:forms.skin-filter-search-bar wire:key="search{{ rand() }}" :searchFilterInput="$searchFilterInput" />
            </div>


            <!-- Rewards Only -->
            <div class="relative mt-5 tracking-wide w-[min(90vw,23.75rem)]">
                <x-forms.filter-button :name="'missskin'" :checked="$winnersOnly" wire:click="ToggleShowWinnersOnly" >
                    <label for="missskin" class="absolute cursor-pointer font-thin text-secondary left-7 top-2 text-[0.9rem] text-left w-[min(calc(75vw),22rem)]">Voir uniquement les vainqueurs du <span class="font-normal">Miss'Skin</span></label>
                </x-forms.filter-button>

                <div class="absolute right-0 w-6 h-6 cursor-pointer group top-1">
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
                      c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z"/>
                    </svg>

                    <div class="group-hover:visible group-hover:opacity-100 z-10 opacity-0 transition-all invisible cursor-text absolute -top-4 right-8
                        min-[801px]:-right-[17.5rem]">
                        <x-utils.miss-skin />
                        <svg class="absolute h-4 top-5 text-secondary -rotate-90 -right-4
                            min-[801px]:rotate-90 min-[801px]:-left-4" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                            <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                        </svg>
                    </div>

                </div>

            </div>


            <!-- Barb Only -->
            <div class="relative my-5 min-[430px]:my-2 tracking-wide w-[min(90vw,23.75rem)]">
                <x-forms.filter-button :name="'barbe only'" :checked="$barbOnly" wire:click="ToggleShowBarbeOnly" >
                    <label for="barbe only" class="absolute font-thin text-secondary text-[0.9rem] left-7 top-2 cursor-pointer text-left w-[min(80vw,23.75rem)]">Voir uniquement les skins de <span class=" font-normal">Barbe Douce</span></label>
                </x-forms.filter-button>
            </div>
        </div>


        <!-- Second part -->
        <div class="max-[1500px]:max-w-[38.75rem] max-[900px]:pb-8">



            <!-- Skin content -->
            <div>
                <div class="ml-4 border-b border-ivory w-[50%]">
                    <p class="-ml-4 font-thin text-secondary text-[1.15rem]">Le skin peut contenir :</p>
                </div>



                <!-- Checkboxs -->
                <div class="flex flex-col min-[450px]:flex-row justify-start pt-2 pr-5 ml-2 tracking-wide gap-x-4 gap-y-2">

                    <!-- Mimibiotes -->
                    <div class="relative w-[6.25rem]">
                        <x-forms.filter-button :name="'Mimibiotes'" :label="'Mimibiotes'" :checked="!in_array(1, $skinContent)" wire:click="ToggleSkinContent(1)" />
                    </div>

                    <!-- Cosmétiques -->
                    <div class="relative w-[7.5rem]">
                        <x-forms.filter-button :name="'Cosmétiques'" :label="'Cosmétiques'" :checked="!in_array(2, $skinContent)" wire:click="ToggleSkinContent(2)" />
                    </div>

                    <!-- Objets vivants -->
                    <div class="relative w-32">
                        <x-forms.filter-button :name="'Objets vivants'" :label="'Objets vivants'" :checked="!in_array(3, $skinContent)" wire:click="ToggleSkinContent(3)" />
                    </div>
                </div>
            </div>



            <!-- Classes -->
            <div class="relative mt-5">

                <livewire:forms.skin-filter-races wire:key="races{{ rand() }}" :races="$races" :raceWhere="$raceWhere" />
            </div>

            <!-- Sexe -->
            <div class="flex items-center justify-center gap-x-20 mt-2">

                <!-- Mâle -->
                <div class="relative w-16">
                    <x-forms.filter-button :name="'Homme'" :label="'Homme'" :checked="!in_array(['gender', '!=', 'Homme'], $gender)" wire:click="ToggleGender('Homme')" />
                </div>

                <!-- Femelle -->
                <div class="relative w-20">
                    <x-forms.filter-button :name="'Femme'" :label="'Femme'" :checked="!in_array(['gender', '!=', 'Femme'], $gender)" wire:click="ToggleGender('Femme')" />
                </div>
            </div>
        </div>

    </div>



    <!-- Twitch section -->
    <div x-show="showLive"
         class="fixed z-50 w-[20vw] min-w-[250px] bottom-8 left-8 hidden
              [@media(min-height:801px)_and_(min-width:801px)]:block
              min-[1501px]:static min-[1501px]:w-[min(100%,27rem)] min-[1501px]:pt-8 min-[1501px]:pb-4 min-[1501px]:px-1 min-[1501px]:flex-1">
        <x-utils.twitch-embed :can-close="true"/>
    </div>
</div>
