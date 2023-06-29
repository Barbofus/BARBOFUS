<div>
    <div class="flex gap-x-2 items-center justify-start">
        <img src="{{ asset('storage/' . $subicon) }}" class="h-7">
        <p class="text-inactiveText text-md font-light">{{ $subname }}</p>
        <p class="text-inactiveText text-md font-light">Lv. {{ $level }}</p>
    </div>
    <div class="flex space-x-2 items-center bg-primary-100 rounded-md pr-4">
        <img class="w-14" draggable="false" src="{{ asset('storage/' . $icon )}}">
        <p class="font-light italic text-secondary text-md min-[750px]:text-lg">{{ $name }}</p>
    </div>
</div>
