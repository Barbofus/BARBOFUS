{{-- Nécessite un tableau de Skin en argument sous le nom :skin--}}
<div class="aspect-[14/19] relative h-full">
    {{-- Skin + Background --}}
    <div class="group">
        <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer bg-primary-100 group-hover:brightness-125 transition-all"></div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </div>

    {{-- Barbe --}}
    @if($skin->user_name === 'Barbe__Douce')
        <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Pseudo --}}
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap" wire:click="$emit('ToggleSearchedText', '{{ addslashes($skin->user_name) }}')">
            <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
        </button>
    </div>

    {{-- Likes --}}
    <div class="absolute bottom-0 right-2">
        <p>Avec</p>
        <div class="flex items-center gap-x-1">
            <p>{{ $skin->weekly_likes }}</p>
            <div class="w-7 h-7 relative" x-data="{liked: true}">
                <x-svg.heart :canLike="false" />
            </div>
        </div>
    </div>
</div>
