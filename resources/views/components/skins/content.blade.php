<div class="h-full w-full">

    {{-- Pseudo --}}
    @if(!isset($showName) || $showName)
        <div class="absolute bottom-0 z-10 left-0 w-[calc(100%-3.75rem)] px-1 pb-[2px]">
            <button aria-label="Filtrer le nom sur {{ $skin->user_name }}" class="flex w-full h-12 items-end overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap" wire:click="$emit('ToggleSearchedText', ['{{ addslashes($skin->user_name) }}', {{ addslashes($skin->user_id) }}])">
                <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
            </button>
        </div>
    @endif

    <a class="slidingCard absolute group h-full w-full" title="Skin dofus {{ $skin->race_name }}" href="{{ route('skins.show', $id) }}">
        {{-- Barbe --}}
        @if($skin->user_name === 'Barbe Douce' &! isset($showBarbe))
            <img class="absolute top-0 left-0 h-16 w-16 aspect-square peer cursor-pointer" width="64" height="64" alt="Logo Barbe" loading="lazy" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
        @endif

        {{-- Rewards --}}
        @if(isset($skin->reward_id))

            {{-- Décoration de la carte --}}
            <div class="absolute flex items-end justify-center h-10 w-full top-[-2.75rem]">
                @if($skin->reward_id == 1)
                    <img src="{{ asset('storage/images/misc_ui/tofu_ocre.png') }}" width="50" height="39" alt="Tofu" loading="lazy" draggable="false" class="h-full">
                    <div class="absolute h-10 w-10 left-[50%+1.25rem]">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" width="39" loading="lazy" alt="Plume Tofu" draggable="false" class="absolute rotate-0 h-full top-[0rem] right-[-1.563rem] animate-feather" style="animation-delay: -{{ rand(0,3000) }}ms">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" width="39" loading="lazy" alt="Plume Tofu" draggable="false" class="absolute scale-x-[-1] rotate-[20deg] h-full top-[0.3125rem] right-[2.188rem] animate-featherLeft" style="animation-delay: -{{ rand(0,3000) }}ms">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" width="39" loading="lazy" alt="Plume Tofu" draggable="false" class="absolute rotate-[-35deg] h-full top-[0.3125rem] right-[-3.125rem] animate-feather" style="animation-delay: -{{ rand(0,3000) }}ms">
                    </div>
                @elseif($skin->reward_id == 2)
                    <img src="{{ asset('storage/images/misc_ui/symbol_emeraude.png') }}" height="41" width="41" loading="lazy" alt="Symbol Emeraude" draggable="false" class="h-full">
                    <div class="absolute h-10 w-10 left-[50%+1.25rem]">
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-200 scale-[.3] h-full top-[-15px] right-[-2px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.35] h-full top-[-9px] right-[17px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-200 scale-[.3] h-full top-[-9px] right-[-15px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -1250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-125 scale-[.3] h-full top-[2px] right-[16px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]" style="animation-delay: -1250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -3500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.4] h-full top-[4px] right-[-15px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -2250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -3500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.3] h-full top-[5px] right-[-27px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]" style="animation-delay: -2250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute scale-[.4] h-full top-[8px] right-[27px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute scale-[.5] h-full top-[14px] right-[20px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2750ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="40" width="40" loading="lazy" alt="Orbe" draggable="false" class="absolute brightness-125 scale-[.5] h-full top-[13px] right-[-17px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -1500ms">
                        </div>
                    </div>
                @elseif($skin->reward_id == 3)
                    <img src="{{ asset('storage/images/misc_ui/cawotte.png') }}" width="37" height="37" alt="Cawotte" loading="lazy" draggable="false" class="h-full origin-bottom animate-cawotte" style="animation-delay: {{ rand(0,16) }}s">
                @endif
            </div>

            {{-- Gradient border --}}
            <div class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 {{ (($skin->reward_id == 1) ? 'goldGradient' : (($skin->reward_id == 2) ? 'emeraldGradient' : 'cawotteGradient')) }}"></div>

            {{-- Les Dofus suivant les récompenses qu'on as --}}
            @if(!isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.webp' : (($skin->reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.webp'))) }}" draggable="false" width="120" alt="Dofus Ocre" class="dofus w-[20%] max-w-[119px] rotate-0 top-2 right-1 absolute cursor-pointer" >
            @endif

            @if(!isset($skin->third_reward_id) && isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.webp' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.webp'))) }}" width="120" alt="Dofus" class="w-[18%] -rotate-12 top-2 right-5 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.webp' : (($skin->reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.webp'))) }}" width="120" alt="Dofus" class="dofus w-[20%] rotate-6 top-3 right-1 absolute cursor-pointer" >
            @endif


            @if(isset($skin->third_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->third_reward_id == 1) ? 'dofus_ocre.webp' : (($skin->third_reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.webp'))) }}" width="119" height="157" loading="lazy" alt="Dofus" class="w-[16%] -rotate-12 top-2 right-8 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.webp' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.webp'))) }}" width="119" height="157" loading="lazy" alt="Dofus" class="w-[18%] rotate-6 top-2 right-4 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.webp' : (($skin->reward_id == 2) ? 'dofus_emeraude.webp' : 'dofus_cawotte.png'))) }}" width="119" height="157" loading="lazy" alt="Dofus" class="dofus w-[20%] rotate-12 top-4 right-1 absolute cursor-pointer" >
            @endif
        @elseif(rand(0,1) == 1)  {{-- Deco Evenementielle --}}


            {{-- Halouine --}}

            {{-- Décoration de la carte --}}
            {{--<div class="absolute flex items-end justify-center h-14 w-full top-[-3.5rem]">

                @if(rand(0,2) >= 1)
                    <img src="{{ asset('storage/images/misc_ui/citrouille.webp') }}" width="200" height="72" alt="Citrouille" loading="lazy" draggable="false" class="origin-bottom absolute -bottom-[0.875rem]">
                @else
                    <div class="absolute -bottom-4">
                        <img src="{{ asset('storage/images/misc_ui/bougies.webp') }}" width="156" height="85" alt="Bougies" loading="lazy" draggable="false" class="h-full origin-bottom">
                        <img src="{{ asset('storage/images/misc_ui/bougies-lueur.webp') }}" width="156" height="85" alt="Lumières bougies" loading="lazy" draggable="false" class="h-full absolute top-0 origin-bottom animate-pulse" style="animation-delay: {{ rand(0,2000) }}ms">
                    </div>
                @endif
            </div>--}}


        {{-- Nowel --}}

        {{-- Décoration de la carte --}}
            <div class="absolute flex items-end w-[15.125rem] h-32 justify-center -ml-4">

                @if(rand(0,2) >= 1)
                    <img src="{{ asset('storage/images/misc_ui/bonhomme_neige.webp') }}" width="242" height="128" alt="Bonhomme de neige" loading="lazy" draggable="false" class="origin-bottom absolute -top-16">
                @else
                    <img src="{{ asset('storage/images/misc_ui/sapin_cadeaux.webp') }}" width="242" height="128" alt="Sapin" loading="lazy" draggable="false" class="origin-bottom absolute -top-16">
                @endif
            </div>
        @endif

        {{-- Skin + Background --}}
        <div class="-z-10 absolute top-0 left-0 w-full h-full rounded-md cursor-pointer {{ (!isset($showName) || $showName) ? 'bg-primary-100' : (($skin->status == 'Pending') ? 'bg-pendingBackground' : (($skin->status == 'Refused') ? 'bg-refusedBackground' : 'bg-primary-100'))}} group-hover:brightness-125 transition-all overflow-hidden">
            <div class="skinBackGround bg-[linear-gradient(0deg,rgba(255,255,255,0)36%,rgba(255,255,255,0.05)40%,rgba(255,255,255,0)100%)] w-[200%] h-full rotate-[30deg] origin-bottom-right absolute right-0 top-[-12.5rem]">
            </div>



            {{-- Halouine --}}

            {{--@if(rand(0,2) == 2)
                @if(rand(0,1) == 1)
                    <img src="{{ asset('storage/images/misc_ui/scary-face.webp') }}" width="250" height="250" alt="Scary Face" loading="lazy" draggable="false" class="mx-auto origin-bottom opacity-20">
                @else
                    <img src="{{ asset('storage/images/misc_ui/bat.webp') }}" width="200" height="103" alt="Chauve souris" loading="lazy" draggable="false" class="mx-auto origin-bottom opacity-20">
                @endif
            @endif--}}



            {{-- Nowel --}}

            @if(rand(0,2) == 2)
                @if(rand(0,3) == 1)
                    <img src="{{ asset('storage/images/misc_ui/cloches.webp') }}" width="250" height="250" alt="Scary Face" loading="lazy" draggable="false" class="mx-auto origin-bottom opacity-20 mt-8">
                @else
                    @if(rand(0,2) == 1)
                        <img src="{{ asset('storage/images/misc_ui/cadeau.webp') }}" width="250" height="250" alt="Scary Face" loading="lazy" draggable="false" class="mx-auto origin-bottom opacity-20 mt-8">
                    @else
                        <img src="{{ asset('storage/images/misc_ui/sapin.webp') }}" width="200" height="103" alt="Chauve souris" loading="lazy" draggable="false" class="mx-auto origin-bottom opacity-20 mt-8">
                    @endif
                @endif
            @endif
        </div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" title="Skin dofus {{ $skin->race_name }}" loading="lazy" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </a>
</div>
