<div class="relative mt-2"
    x-data="{ focusinput: false, focusbutton: false }"
    x-id="['dropdown-search']"
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
                x-ref="input"
                    maxlength="30" id="{{ $name }}" type="text" placeholder="{{ $placeholder }}"
                    class="w-full h-full rounded-md pl-14 focus:outline-none bg-slate-100 @error($name) err-border @enderror"
                    value="{{ $value }}"
                    :aria-expanded="focusinput || focusbutton"
                    :aria-controls="$id('dropdown-search')"
                    wire:model="query"
                    wire:keydown.arrow-down.prevent="incrementSelection"
                    wire:keydown.arrow-up.prevent="decrementSelection"
                    wire:keydown.enter="useSelectionAsValue"
                    x-on:focus="focusinput = true" x-on:blur="focusinput = false" />
                <input type="hidden" name="{{ $name }}" value="{{ ($existentItem) ? $existentItem->id : null }}" />
            </label>
        </div>

        <div
            class="absolute z-50 w-full bg-slate-50"
            x-show="focusinput || focusbutton"
            :id="$id('dropdown-search')">
            @foreach ($items as $key => $item)

                <button
                    type="button"
                    class="flex w-full items-center h-12 space-x-2 cursor-pointer {{ ($selectedItem === $key) ? 'bg-blue-500 hover:bg-blue-400' : 'hover:bg-slate-200'}}"
                    wire:click="setSelection({{$key}})"
                    x-on:focus="focusbutton = true" x-on:blur="focusbutton = false">

                    <img draggable="false" class="h-full select-none" src="{{ asset('storage\\'.$item->icon_path) }}" alt="">
                    <p class="{{ ($selectedItem === $key) ? 'font-bold text-white' : ''}} select-none">{{ $item->name }}</p>
                </button>

            @endforeach
        </div>

        @error($name)
            <x-requirements-error message={{$message}} />
        @enderror
    </div>
</div>
