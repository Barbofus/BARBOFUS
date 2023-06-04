<div class="absolute bottom-0 group right-0 flex items-center h-7 pr-1">
    <p class="text-secondary font-normal text-[0.9rem]" x-text="likeCount"></p>

    <div class="h-full w-7">
        <x-svg.heart :canLike="$canLike" />
        @if($canLike)
            <div x-ref="heartPing" class="scale-0 h-full w-full" :class="(clicked) ? 'animate-onePing' : ''">
                <x-svg.heart :canLike="'false'" />
            </div>
        @endif
    </div>
</div>
