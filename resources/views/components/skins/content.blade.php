<div class="h-full w-full">

    {{-- Pseudo --}}
    @if(!isset($showName) || $showName)
        <div class="absolute bottom-0 z-10 left-0 w-[calc(100%-3.75rem)] px-1 pb-[2px]">
            <button aria-label="Filtrer le nom sur {{ $skin->user_name }}" class="flex w-full h-12 items-end overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap" wire:click="$emit('ToggleSearchedText', ['{{ addslashes($skin->user_name) }}', {{ addslashes($skin->user_id) }}])">
                <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
            </button>
        </div>
    @endif

    <a class="slidingCard absolute group h-full w-full" title="Skin {{ $skin->race_name }} de {{ $skin->user_name }}" href="{{ route('skins.show', $id) }}">
        {{-- Barbe --}}
        @if($skin->user_name === 'Barbe Douce' &! isset($showBarbe))
            <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" height="64" alt="Logo Barbe" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
        @endif

        {{-- Rewards --}}
        @if(isset($skin->reward_id))

            {{-- Décoration de la carte --}}
            <div class="absolute flex items-end justify-center h-10 w-full top-[-2.75rem]">
                @if($skin->reward_id == 1)
                    <img src="{{ asset('storage/images/misc_ui/tofu_ocre.png') }}" height="39" alt="Tofu" draggable="false" class="h-full">
                    <div class="absolute h-10 w-10 left-[50%+1.25rem]">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" alt="Plume Tofu" draggable="false" class="absolute rotate-0 h-full top-[0rem] right-[-1.563rem] animate-feather" style="animation-delay: -{{ rand(0,3000) }}ms">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" alt="Plume Tofu" draggable="false" class="absolute scale-x-[-1] rotate-[20deg] h-full top-[0.3125rem] right-[2.188rem] animate-featherLeft" style="animation-delay: -{{ rand(0,3000) }}ms">
                        <img src="{{ asset('storage/images/misc_ui/tofu_ocre_feather.png') }}" height="39" alt="Plume Tofu" draggable="false" class="absolute rotate-[-35deg] h-full top-[0.3125rem] right-[-3.125rem] animate-feather" style="animation-delay: -{{ rand(0,3000) }}ms">
                    </div>
                @elseif($skin->reward_id == 2)
                    <img src="{{ asset('storage/images/misc_ui/symbol_emeraude.png') }}" height="41" alt="Symbol Emeraude" draggable="false" class="h-full">
                    <div class="absolute h-10 w-10 left-[50%+1.25rem]">
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-200 scale-[.3] h-full top-[-15px] right-[-2px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.35] h-full top-[-9px] right-[17px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-200 scale-[.3] h-full top-[-9px] right-[-15px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -1250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-125 scale-[.3] h-full top-[2px] right-[16px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]" style="animation-delay: -1250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -3500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.4] h-full top-[4px] right-[-15px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -2250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -3500ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-150 scale-[.3] h-full top-[5px] right-[-27px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]" style="animation-delay: -2250ms">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute scale-[.4] h-full top-[8px] right-[27px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -1250ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute scale-[.5] h-full top-[14px] right-[20px] animate-slideX [--custom-translate-x:-3px] [--custom-animation-time:5s]">
                        </div>
                        <div class="absolute animate-slideY [--custom-translate-y:3px] [--custom-animation-time:5s] h-full w-full" style="animation-delay: -2750ms">
                            <img src="{{ asset('storage/images/misc_ui/symbol_emeraude_orb.png') }}" height="16" alt="Orbe" draggable="false" class="absolute brightness-125 scale-[.5] h-full top-[13px] right-[-17px] animate-slideX [--custom-translate-x:3px] [--custom-animation-time:5s]" style="animation-delay: -1500ms">
                        </div>
                    </div>
                @elseif($skin->reward_id == 3)
                    <img src="{{ asset('storage/images/misc_ui/cawotte.png') }}" height="37" alt="Cawotte" draggable="false" class="h-full origin-bottom animate-cawotte" style="animation-delay: {{ rand(0,16) }}s">
                @endif
            </div>

            {{-- Gradient border --}}
            <div class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 {{ (($skin->reward_id == 1) ? 'goldGradient' : (($skin->reward_id == 2) ? 'emeraldGradient' : 'cawotteGradient')) }}"></div>

            {{-- Les Dofus suivant les récompenses qu'on as --}}
            @if(!isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" draggable="false" width="120" alt="Dofus Ocre" class="dofus w-[20%] max-w-[119px] rotate-0 top-2 right-1 absolute cursor-pointer" >
            @endif

            @if(!isset($skin->third_reward_id) && isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.png' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" width="120" alt="Dofus" class="w-[18%] -rotate-12 top-2 right-5 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" width="120" alt="Dofus" class="dofus w-[20%] rotate-6 top-3 right-1 absolute cursor-pointer" >
            @endif


            @if(isset($skin->third_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->third_reward_id == 1) ? 'dofus_ocre.png' : (($skin->third_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" width="120" alt="Dofus" class="w-[16%] -rotate-12 top-2 right-8 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.png' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" width="120" alt="Dofus" class="w-[18%] rotate-6 top-2 right-4 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" width="120" alt="Dofus" class="dofus w-[20%] rotate-12 top-4 right-1 absolute cursor-pointer" >
            @endif
        @endif

        {{-- Skin + Background --}}
        <div class="-z-10 absolute top-0 left-0 w-full h-full rounded-md cursor-pointer {{ (!isset($showName) || $showName) ? 'bg-primary-100' : (($skin->status == 'Pending') ? 'bg-pendingBackground' : (($skin->status == 'Refused') ? 'bg-refusedBackground' : 'bg-primary-100'))}} group-hover:brightness-125 transition-all overflow-hidden">
            <div class="skinBackGround bg-[linear-gradient(0deg,rgba(255,255,255,0)36%,rgba(255,255,255,0.05)40%,rgba(255,255,255,0)100%)] w-[200%] h-full rotate-[30deg] origin-bottom-right absolute right-0 top-[-200px]"></div>
        </div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" title="Skin {{ $skin->race_name }} de {{ $skin->user_name }}" height="260" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </a>
</div>
