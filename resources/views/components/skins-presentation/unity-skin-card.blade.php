{{-- Nécessite un tableau de Skin en argument sous le nom :skin --}}
<div class="aspect-[14/19] h-full relative w-full z-10 group">



    <x-skins.content :skin="$skin" :id="$skin->id" />

    {{-- Likes --}}
    <div x-data="{
        clicked: false,
        liked: (@js($skin->is_liked)),

        SwitchLike() {
            this.clicked = false;
            $wire.SwitchHeart({{ $skin->id }}, {{ $skin->is_unity_skin }});

            this.liked = !this.liked;

            setTimeout(() => this.clicked = true, 50)
        }
    }" x-cloak>
        @auth
            @if ($skin->user_id === Auth::user()->id)
                {{-- S'il s'agit de notre propre skin, nous empêche de le liker --}}
                <x-skins.favorites :skin="$skin" :canLike="false" />
            @else
                <button aria-label="Aimer un skin" @click="SwitchLike">
                    <x-skins.favorites :skin="$skin" :canLike="true" />
                </button>
            @endif
        @endauth

        @guest

            <a href="{{ route('login') }}" title="Page de connexion">
                <x-skins.favorites :skin="$skin" :canLike="false" />
            </a>
        @endguest
    </div>
</div>
