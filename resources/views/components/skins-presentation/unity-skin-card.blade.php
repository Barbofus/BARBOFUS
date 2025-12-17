{{-- Nécessite un tableau de Skin en argument sous le nom :skin --}}
<div class="aspect-[14/19] h-full relative w-full z-10">



    <x-skins.content :skin="$skin" :id="$skin->id" />

    {{-- Likes --}}
    <div x-data="{
        clicked: false,
        liked: (@js($skin->is_liked)),
        likeCount: @js($skin->likes_count),
    
        SwitchLike() {
            this.clicked = false;
            $wire.SwitchHeart({{ $skin->id }}, {{ $skin->is_unity_skin }});
    
            this.liked = !this.liked;
    
            if (this.liked) this.likeCount++;
            else this.likeCount--;
    
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
                <div class="absolute flex items-center pr-1 bottom-1 right-1 group h-7">
                    {{-- <p class="text-lg font-normal text-secondary" x-text="likeCount"></p> --}}

                    <div class="h-full w-7">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="h-full text-goldLit">
                            <defs>
                                <linearGradient x1="100%" y1="0%" x2="0%" y2="90%" id="a">
                                    <stop offset="0%" stop-color="currentColor" />
                                    <stop offset="100%" stop-color="var(--goldDark)" />
                                </linearGradient>
                            </defs>
                            <path fill="var(--heartGray)"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                        </svg>

                    </div>
                </div>
            </a>
        @endguest
    </div>
</div>
