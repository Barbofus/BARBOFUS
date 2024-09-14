{{-- Nécessite un tableau de Skin en argument sous le nom :skin--}}
<div class="aspect-[14/19] h-full relative w-full z-10">



    <x-skins.content :skin="$skin" :id="$skin->id" />

    {{-- Likes --}}
    @if(!isset($skin->is_unity_skin))
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
                    <button aria-label="Aimer un skin" @click="SwitchLike">
                        <x-skins.likes :skin="$skin" :canLike="true" />
                    </button>
                @endif
            @endauth

            @guest

                <a href="{{ route('login') }}" title="Page de connexion">
                    <div class="absolute bottom-0 group right-0 flex items-center h-7 pr-1">
                        <p class="text-secondary font-normal text-lg" x-text="likeCount"></p>

                        <div class="h-full w-7">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-full text-heartLit">
                                <defs>
                                    <linearGradient x1="100%" y1="0%" x2="0%" y2="90%" id="a">
                                        <stop offset="0%" stop-color="currentColor" />
                                        <stop offset="100%" stop-color="var(--heartDark)" />
                                    </linearGradient>
                                </defs>
                                <path fill="var(--heartGray)"  d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endguest
        </div>
    @endif
</div>
