{{-- Nécessite un tableau de Skin en argument sous le nom :skin--}}
<div class="aspect-[14/19] h-full relative w-full">

    <x-skins.content :skin="$skin" :id="$skin->id" />

    {{-- Likes --}}
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
        }" x-cloak>
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
