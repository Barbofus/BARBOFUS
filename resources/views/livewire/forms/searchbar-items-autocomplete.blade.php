<div class="relative">
    <div class="flex items-center h-6 space-x-2 text-inactiveText">
        @if ($existentItem && count($existentItem) > 0)
            <img class="h-full" src="{{ asset('storage\\'.$existentItem['sub_icon_path']) }}" draggable="false">
            <p>{{ $existentItem['sub_name'] }}</p>
            <p>Lvl. {{ $existentItem['level'] }}</p>
        @endif
    </div>

    <div class="w-[min(90vw,300px)]">

        {{-- Résultat --}}
        <div class="relative w-full h-12"
            x-data="{show: false}"
            @mousedown.away="show = false">
            <label for="{{ $name }}">
                <img class="absolute h-full" src="{{ ($existentItem && count($existentItem) > 0) ? asset('storage/'.$existentItem['icon_path']) : '' }}" draggable="false">
                <input x-ref="input"
                    maxlength="30" id="{{ $name }}" type="text" placeholder="{{ $placeholder }}"
                    class="w-full h-full rounded-md pl-14 focus:outline-none placeholder-inactiveText bg-primary-100 @error($name) err-border @enderror"
                    value="{{ $value }}"
                    wire:model="query"
                    wire:keydown.arrow-down.prevent="{{ (count($items) > 0) ? 'incrementSelection' : '' }}"
                    wire:keydown.arrow-up.prevent="{{ (count($items) > 0) ? 'decrementSelection' : '' }}"
                    wire:keydown.enter="{{ count($items) > 0 ? 'useSelectionAsValue' : ''}}"
                    wire:keydown.tab.prevent="{{ (count($items) > 0) ? 'incrementSelection' : '' }}"
                    @mousedown="show = true"
                    @focusin="show = true"
                    @keydown.enter.prevent="show = false, $refs.input.blur()"/>
                <input type="hidden" name="{{ $name }}" value="{{ ($existentItem && count($existentItem) > 0) ? $existentItem['id'] : null }}" />
            </label>

            {{-- Menu déroulant --}}
            <div class="max-h-72 w-full absolute bg-red-500" x-show="show">

                <div class="absolute bg-primary-100 z-50 w-full max-h-60 overflow-y-auto">
                    @foreach ($items as $key => $item)
                        <button
                            type="button"
                            class="flex w-full rounded-md items-center transition-all border-2 h-12 space-x-2 cursor-pointer {{ ($selectedItem === $key) ? 'border-secondary text-secondary font-normal' : 'hover:border-inactiveText border-primary-100 text-inactiveText font-light'}}"
                            wire:click="setSelection({{$key}})"
                            @click="show = false">

                            <img draggable="false" class="h-full select-none" src="{{ asset('storage\\'. $item->icon_path) }}" alt="">
                            <p class="select-none">{{ $item->name }}</p>
                        </button>

                    @endforeach
                </div>
            </div>
        </div>

        @error($name)
            <x-forms.requirements-error :$message />
        @enderror
    </div>
</div>
