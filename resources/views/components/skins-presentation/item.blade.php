<div>
    <div class="flex space-x-2 items-center mt-2">
        <img class="w-12" draggable="false" src="{{ asset('storage/' . $item->icon_path )}}">
        <div>

            <p>{{ $item->name }}</p>

            <div class="flex space-x-2 items-center">
                <img draggable="false" width="24" height="24" src="{{ asset('storage/' . $item->DofusItemsSubCategorie->icon_path) }}">
                <p class="text-sm italic text-gray-500">{{ $item->DofusItemsSubCategorie->name }}</p>
                <p class="text-sm italic text-gray-500">Lv. {{ $item->level }}</p>
            </div>
        </div>
    </div>
</div>
