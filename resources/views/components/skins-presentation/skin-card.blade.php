<div class="relative opacity-0 animate-skinApparition aspect-[14/19] h-full shadow-sm" style="animation-delay: {{ ($key - (Self::ITEMS_PER_PAGE * ($currentPage - 1))) * 35 }}ms">

    <!-- Barbe -->
    @if($skin->User->name === 'Barbe__Douce')
        <img id="barbeLogo" class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Skin + Background --}}
    <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] peer cursor-pointer" draggable="false">
    <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer -z-10 bg-primary-100 peer-hover:brightness-125 hover:brightness-125"></div>

    <!-- Pseudo -->
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap">
            <p class="skinCardUserName">{{ $skin->User->name }}&nbsp;</p>
        </button>
    </div>

    <!-- Likes -->
    @auth
        @if($skin->User->id === Auth::user()->id) {{-- S'il s'agit de notre propre skin, nous empêche de le liker --}}
            <x-skins.likes :skin="$skin" :canLike="false"/>
        @else
            <button wire:click="SwitchHeart({{ $skin->id }})">
                <x-skins.likes :skin="$skin" :canLike="true"/>
            </button>
        @endif
    @endauth

    @guest
        <a href="{{ route('login') }}">
            <x-skins.likes :skin="$skin" :canLike="false"/>
        </a>
    @endguest
</div>
