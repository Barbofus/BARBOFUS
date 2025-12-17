<div class="absolute flex items-center pr-1 bottom-1 group right-1 h-7">
    {{-- <p class="text-lg font-normal text-secondary" x-text="likeCount"></p> --}}

    <div class="h-full w-7">
        <x-svg.star :canLike="$canLike" />
        @if ($canLike)
            <div x-ref="heartPing" class="w-full h-full scale-0" :class="(clicked) ? 'animate-onePing' : ''">
                <x-svg.star :canLike="'false'" />
            </div>
        @endif
    </div>
</div>
