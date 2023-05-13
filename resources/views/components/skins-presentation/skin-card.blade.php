<div class="relative opacity-0 animate-skinApparition aspect-[14/19] h-full shadow-sm" style="animation-delay: {{ ($key - (Self::ITEMS_PER_PAGE * ($currentPage - 1))) * 35 }}ms">

    <!-- Barbe -->
    @if($skin->User->name === 'Barbe__Douce')
        <img id="barbeLogo" class="absolute top-0 left-0 h-[25%] max-h-[64px] peer cursor-pointer" src="{{ asset('storage/images/misc_ui/logo_barbe.png') }}" draggable="false">
    @endif

    {{-- Skin + Background --}}
    <img src="{{ asset('storage\/') . $skin->image_path }}" class="absolute top-[10%] left-[5%] h-[80%] peer cursor-pointer" draggable="false">
    <div class="absolute top-0 left-0 w-full h-full rounded-md cursor-pointer -z-10 bg-primary-100 peer-hover:brightness-125"></div>

    <!-- Pseudo -->
    <div class="absolute bottom-0 left-0 max-w-[calc(100%-60px)] cursor-pointer px-1 pb-[2px]">
        <div class="flex w-full overflow-hidden font-light text-goldText text-[0.75rem] hover:text-goldTextLit whitespace-nowrap">
            <p class="skinCardUserName">{{ $skin->User->name }}&nbsp;</p>
        </div>
    </div>

    <!-- Likes -->
    <div class="absolute bottom-0 right-0 flex items-center h-[10%] pr-1">
        <p class="text-ivory font-normal text-[0.9rem]">{{ count($skin->Likes) }}</p>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-full cursor-pointer text-heartLit hover:brightness-125">
            <defs>
                <linearGradient x1="100%" y1="0%" x2="0%" y2="90%" id="a">
                    <stop offset="0%" stop-color="currentColor" />
                    <stop offset="100%" stop-color="var(--heartDark)" />
                </linearGradient>
            </defs>
            <path fill="{{ (count(\App\Models\Like::where('skin_id', '=', $skin->id)->where('user_id', '=', Auth::user()->id)->get()) > 0) ? "url('#a')" : 'var(--heartGray)' }}"  d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>

    </div>
</div>
