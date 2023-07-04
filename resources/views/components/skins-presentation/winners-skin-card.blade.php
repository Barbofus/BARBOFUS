{{-- Nécessite un tableau de Skin en argument sous le nom :skin--}}
<div class="aspect-[14/19] relative h-full">

    <x-skins.content :skin="$skin" :id="$skin->skin_id" />

    {{-- Likes --}}
    <div class="absolute bottom-0 right-2">
        <p>Avec</p>
        <div class="flex items-center gap-x-1">
            <p>{{ $skin->weekly_likes }}</p>
            <div class="w-7 h-7 relative" x-data="{liked: true}">
                <x-svg.heart :canLike="false" />
            </div>
        </div>
    </div>
</div>
