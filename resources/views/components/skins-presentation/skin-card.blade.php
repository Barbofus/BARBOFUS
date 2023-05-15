<div class="relative opacity-0 animate-skinApparition aspect-[14/19] h-full shadow-sm" style="animation-delay: {{ ($key - ($itemsPerPage * ($currentPage - 1))) * 25 }}ms">

    {{-- Skin + Background --}}
    <div class="group">
        <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer bg-primary-100 group-hover:brightness-125 transition-all"></div>
        <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] cursor-pointer group-hover:scale-105 transition-transform" draggable="false">
    </div>

    <p class="absolute top-4">{{ $skin->created_at }}</p>
    <p class="absolute top-8">{{ count($skin->Likes) }}</p>
    <div class="absolute top-12">
        @foreach($skin->Rewards as $reward)
            <p>{{ $reward->rank }} -- {{ $reward->value }}</p>
        @endforeach
    </div>

    {{-- Barbe --}}
    @if($skin->User->name === 'Barbe__Douce')
        <img class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Pseudo --}}
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] px-1 pb-[2px]">
        <button class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap">
            <p class="skinCardUserName">{{ $skin->User->name }}&nbsp</p>
        </button>
    </div>

    {{-- Likes --}}
    <div
        x-data="{
            clicked: false,
            liked: (@js((Auth::user()) && (count(\App\Models\Like::where('skin_id', '=', $skin->id)->where('user_id', '=', Auth::user()->id)->get()) > 0))),
            likeCount: @js(count($skin->Likes)),

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
            @if($skin->User->id === Auth::user()->id)  S'il s'agit de notre propre skin, nous empêche de le liker
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
