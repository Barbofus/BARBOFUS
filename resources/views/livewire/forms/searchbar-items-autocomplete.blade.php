<div class="relative mt-2"
    x-data="{ open: true }"
    x-on:click="open = true"
    x-on:click.away="open = false"
>
    <div class="flex items-center h-6 space-x-2 text-slate-600">
        @if ($existentItem)
            <img class="h-full" src="{{ asset('storage\\'.$existentItem->DofusItemsSubCategorie->icon_path) }}" draggable="false">
            <p>{{ $existentItem->DofusItemsSubCategorie->name }}</p>
            <p>Lvl. {{ $existentItem->level }}</p>
        @endif
    </div>

    <div class="w-[300px]">
        <div class="relative w-full h-12">
            <label for="{{ $name }}">
                @if ($existentItem)
                    <img class="absolute h-full" src="{{ asset('storage\\'.$existentItem->icon_path) }}" draggable="false">
                @endif
                <input
                    maxlength="30" id="{{ $name }}" type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                    class="w-full h-full rounded-md pl-14 focus:outline-none bg-slate-100 @error($name) err-border @enderror"
                    value="{{ $value }}"
                    wire:model="query"
                    wire:keydown.arrow-down.prevent="incrementSelection"
                    wire:keydown.arrow-up.prevent="decrementSelection"
                    wire:keydown.enter="useSelectionAsValue">
            </label>
        </div>

        <div class="absolute z-50 w-full bg-slate-50" x-show="open">
            @foreach ($items as $key => $item)

                <div class="flex items-center h-12 space-x-2 cursor-pointer {{ ($selectedItem === $key) ? 'bg-blue-500 hover:bg-blue-400' : 'hover:bg-slate-200'}}" wire:click="setSelection({{$key}})">
                    <img draggable="false" class="h-full select-none" src="{{ asset('storage\\'.$item->icon_path) }}" alt="">
                    <p class="{{ ($selectedItem === $key) ? 'font-bold text-white' : ''}} select-none">{{ $item->name }}</p>
                </div>

            @endforeach
        </div>

        @error($name)
            <x-requirements-error message={{$message}} />
        @enderror
    </div>
</div>
