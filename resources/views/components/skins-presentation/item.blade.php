<div>
    <div class="flex items-center justify-start gap-x-2">
        <img src="{{ asset('https://static.barbofus.com/images/icons/items/subcategories/'. $subname .'.png') }}" class="h-7">
        <p class="font-light text-inactiveText text-md">{{ __('barbofus.labelSkinItem'.$subname) }}</p>
        <p class="font-light text-inactiveText text-md">Lv. {{ $level }}</p>
    </div>
    <div class="flex items-center pr-4 space-x-2 rounded-md bg-primary-100">
        <img class="w-14" draggable="false" src="{{ asset('https://static.barbofus.com/' . $icon )}}">
        <p class="font-light italic text-secondary text-md min-[750px]:text-lg">{{ $name }}</p>
    </div>
</div>
