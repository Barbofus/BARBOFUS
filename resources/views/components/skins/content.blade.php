<div>

    {{-- Pseudo --}}
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap" wire:click="$emit('ToggleSearchedText', '{{ addslashes($skin->user_name) }}')">
            <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
        </button>
    </div>

    <div class="group">
        {{-- Barbe --}}
        @if($skin->user_name === 'Barbe Douce')
            <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
        @endif

        {{-- Rewards --}}
        @if(isset($skin->reward_id))

            {{-- Décoration de la carte --}}
            <div class="absolute flex items-end justify-center h-12 w-full -top-[52px]">
                @if($skin->reward_id == 1)
                    <img id="rewardImg" src="{{ asset('storage/images/misc_ui/tofu_ocre.png') }}" draggable="false" class="w-[60%] max-w-[118px]">
                @elseif($skin->reward_id == 2)
                    <img id="rewardImg" src="{{ asset('storage/images/misc_ui/symbol_emeraude.png') }}" draggable="false" class="w-[60%] max-w-[118px]">
                @elseif($skin->reward_id == 3)
                    <img id="rewardImg" src="{{ asset('storage/images/misc_ui/cawotte.png') }}" draggable="false" class="w-[60%] max-w-[118px] origin-bottom animate-cawotte" style="animation-delay: {{ rand(0,16) }}s">
                @endif
            </div>

            {{-- Gradient border --}}
            <div class="absolute -top-1 -left-1 w-[calc(100%+8px)] h-[calc(100%+8px)] rounded-lg -z-20 {{ (($skin->reward_id == 1) ? 'goldGradient' : (($skin->reward_id == 2) ? 'emeraldGradient' : 'cawotteGradient')) }}"></div>

            {{-- Les Dofus suivant les récompenses qu'on as --}}
            @if(!isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" draggable="false" class="dofus w-[20%] max-w-[119px] rotate-0 top-2 right-1 absolute cursor-pointer" >
            @endif

            @if(!isset($skin->third_reward_id) && isset($skin->second_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.png' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" class="w-[18%] -rotate-12 top-2 right-5 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" class="dofus w-[20%] rotate-6 top-3 right-1 absolute cursor-pointer" >
            @endif


            @if(isset($skin->third_reward_id))
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->third_reward_id == 1) ? 'dofus_ocre.png' : (($skin->third_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" class="w-[16%] -rotate-12 top-2 right-8 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->second_reward_id == 1) ? 'dofus_ocre.png' : (($skin->second_reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" class="w-[18%] rotate-6 top-2 right-4 absolute cursor-pointer">
                <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" class="dofus w-[20%] rotate-12 top-4 right-1 absolute cursor-pointer" >
            @endif
        @endif

        {{-- Skin + Background --}}
        <div class="-z-10 absolute top-0 left-0 w-full h-full rounded-md cursor-pointer bg-primary-100 group-hover:brightness-125 transition-all overflow-hidden">
            <div class="skinBackGround bg-[linear-gradient(0deg,rgba(255,255,255,0)36%,rgba(255,255,255,0.05)40%,rgba(255,255,255,0)100%)] w-[200%] h-full rotate-[30deg] origin-bottom-right absolute right-0 top-[-200px]"></div>
        </div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </div>
</div>
