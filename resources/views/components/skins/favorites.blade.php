<div class="absolute flex items-center pr-1 top-2 group left-2 h-7" :class="liked ? '' : 'opacity-0 group-hover:opacity-100 transition-all'">
    <div class="h-full w-7">
        <x-svg.star :canLike="$canLike" />
        @if ($canLike)
            <div x-ref="heartPing" class="w-full h-full scale-0" :class="(clicked) ? 'animate-onePing' : ''">
                <x-svg.star :canLike="'false'" />
            </div>
        @endif
    </div>
</div>
