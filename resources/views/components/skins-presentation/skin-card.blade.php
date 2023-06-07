{{-- Nécessite un tableau de Skin en argument sous le nom :skin--}}
<div class="aspect-[14/19] relative w-full">
    {{-- Skin + Background --}}
    <div class="group">
        <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer bg-primary-100 group-hover:brightness-125 transition-all"></div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </div>

    <div class="absolute top-2 bg-primary z-50">

        @if(isset($skin->DofusItemHat))
            <p> Hat -> {{ $skin->DofusItemHat->DofusItemsSubCategorie->name }}</p>
        @endif

        @if(isset($skin->DofusItemCloak))
            <p> Cloak -> {{ $skin->DofusItemCloak->DofusItemsSubCategorie->name }}</p>
        @endif

        @if(isset($skin->DofusItemShield))
            <p> Shield -> {{ $skin->DofusItemShield->DofusItemsSubCategorie->name }}</p>
        @endif

        @if(isset($skin->DofusItemPet))
            <p> Pet -> {{ $skin->DofusItemPet->DofusItemsSubCategorie->name }}</p>
        @endif

        @if(isset($skin->DofusItemCostume))
            <p> Costume -> {{ $skin->DofusItemCostume->DofusItemsSubCategorie->name }}</p>
        @endif
        <p>ID: {{ $skin->id }}</p>
        <p>Points: {{ $skin->Rewards->sum('points') }}</p>
        <p>Class: {{ $skin->Race->name }}</p>
        <p>Genre: {{ $skin->gender }}</p>
    </div>

    {{-- Barbe --}}
    @if($skin->user_name === 'Barbe__Douce')
        <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Pseudo --}}
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap">
            <p class="skinCardUserName">{{ $skin->user_name }}&nbsp</p>
        </button>
    </div>

    {{-- Likes @js(Auth::check() && $skin->Likes->where('user_id', Auth::user()->id)->first()) --}}
    <div
        x-data="{
            clicked: false,
            liked: (@js($skin->is_liked)),
            likeCount: @js($skin->likes_count),

            SwitchLike(){
                this.clicked = false;
                $wire.SwitchHeart({{ $skin->id }});

                this.liked = !this.liked;

                if(this.liked) this.likeCount++;
                else this.likeCount--;

                setTimeout(() => this.clicked = true, 50)
            }
        }">
        @auth
            @if($skin->user_id === Auth::user()->id)  {{--S'il s'agit de notre propre skin, nous empêche de le liker--}}
                <x-skins.likes :skin="$skin" :canLike="false"/>
            @else
                <button @click="SwitchLike">
                    <x-skins.likes :skin="$skin" :canLike="true" />
                </button>
            @endif
        @endauth

        @guest
            <a href="{{ route('login') }}">
                <x-skins.likes :skin="$skin" :canLike="false"/>
            </a>
        @endguest
    </div>
</div>
