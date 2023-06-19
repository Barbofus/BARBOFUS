<div class="relative mt-2"
    x-data="{ focusinput: false, focusbutton: false }"
    x-id="['dropdown-search']"
>
    <div class="flex items-center h-6 space-x-2 text-inactiveText">
        @if ($existentItem && count($existentItem) > 0)
            <img class="h-full" src="{{ asset('storage\\'.$existentItem['sub_icon_path']) }}" draggable="false">
            <p>{{ $existentItem['sub_name'] }}</p>
            <p>Lvl. {{ $existentItem['level'] }}</p>
        @endif
    </div>

    <div class="w-[min(90vw,300px)]">

        {{-- Résultat --}}
        <div class="relative w-full h-12">
            <label for="{{ $name }}">
                <img class="absolute h-full" src="{{ ($existentItem && count($existentItem) > 0) ? asset('storage/'.$existentItem['icon_path']) : '' }}" draggable="false">
                <input
                    maxlength="30" id="{{ $name }}" type="text" placeholder="{{ $placeholder }}"
                    class="w-full h-full rounded-md pl-14 focus:outline-none placeholder-inactiveText bg-primary-100 @error($name) err-border @enderror"
                    value="{{ $value }}"
                    :aria-expanded="focusinput || focusbutton"
                    :aria-controls="$id('dropdown-search')"
                    wire:model="query"
                    wire:keydown.arrow-down.prevent="incrementSelection"
                    wire:keydown.arrow-up.prevent="decrementSelection"
                    wire:keydown.enter="{{ count($items) > 0 ? 'useSelectionAsValue' : ''}}"
                    x-on:focus="focusinput = true" x-on:blur="focusinput = false" />
                <input type="hidden" name="{{ $name }}" value="{{ ($existentItem && count($existentItem) > 0) ? $existentItem['id'] : null }}" />
            </label>
        </div>

        {{-- Menu déroulant --}}
        <div
            class="absolute z-50 w-full bg-primary-100 max-h-60 overflow-y-auto"
            x-show="focusinput || focusbutton"
            :id="$id('dropdown-search')">
            @foreach ($items as $key => $item)
                <button
                    type="button"
                    class="flex w-full rounded-md items-center text-inactiveText font-light transition-all border-2 border-primary-100 h-12 space-x-2 cursor-pointer {{ ($selectedItem === $key) ? 'border-secondary text-secondary font-normal' : 'hover:border-inactiveText'}}"
                    wire:click="setSelection({{$key}})"
                    x-on:focus="focusbutton = true" x-on:blur="focusbutton = false">

                    <img draggable="false" class="h-full select-none" src="{{ asset('storage\\'. $item->icon_path) }}" alt="">
                    <p class="select-none">{{ $item->name }}</p>
                </button>

            @endforeach
        </div>

        @error($name)
            <x-forms.requirements-error :$message />
        @enderror
    </div>
</div>
