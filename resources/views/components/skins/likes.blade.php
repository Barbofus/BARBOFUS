<div class="absolute bottom-0 group right-0 flex items-center h-7 pr-1">
    <p class="text-secondary font-normal text-[0.9rem]">{{ count($skin->Likes) }}</p>

    <div class="h-full w-7">
        <x-svg.heart :fill="($canLike && count(\App\Models\Like::where('skin_id', '=', $skin->id)->where('user_id', '=', Auth::user()->id)->get()) > 0) ? 'url(#a)' : 'var(--heartGray)'" :canLike="$canLike" />
        @if($canLike)
            <div class="scale-0 h-full w-full" :class="(liked) ? 'animate-onePing' : ''">
                <x-svg.heart :fill="'url(#a)'" :canLike="'false'" />
            </div>
        @endif
    </div>
</div>
