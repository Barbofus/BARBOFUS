<div>
    {{-- Skin + Background --}}
    <div class="group">
        <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer bg-primary-100 group-hover:brightness-125 transition-all"></div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </div>

    {{-- Barbe --}}
    @if($skin->user_name === 'Barbe Douce')
        <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Pseudo --}}
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap" wire:click="$emit('ToggleSearchedText', '{{ addslashes($skin->user_name) }}')">
            <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
        </button>
    </div>

    <!-- Rewards -->
    @if(isset($skin->reward_id))
        <div>
            <div class="absolute flex items-end justify-center h-12 w-full -top-[52px]">
                <img id="rewardImg" src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'tofu_ocre.png' : (($skin->reward_id == 2) ? 'symbol_emeraude.png' : 'cawotte.png'))) }}" draggable="false" class="w-[60%] max-w-[118px]">
            </div>
            <div class="absolute -top-1 -left-1 w-[calc(100%+8px)] h-[calc(100%+8px)] rounded-lg -z-20 {{ (($skin->reward_id == 1) ? 'goldGradient' : (($skin->reward_id == 2) ? 'emeraldGradient' : 'cawotteGradient')) }}"></div>
            <img src="{{ asset('storage/images/misc_ui/'. (($skin->reward_id == 1) ? 'dofus_ocre.png' : (($skin->reward_id == 2) ? 'dofus_emeraude.png' : 'dofus_cawotte.png'))) }}" draggable="false" class="w-[20%] max-w-[119px] top-2 right-1 absolute peer cursor-pointer">
        </div>
    @endif
</div>
