
<div class="relative">
    <div class="flex items-center h-6 space-x-2 text-inactiveText">
        @if ($selectedItem)
            <img class="h-full" src="{{ asset(asset('https://static.barbofus.com/images/icons/items/subcategories/'. $selectedItem->subcategory .'.png')) }}" draggable="false">
            <p>{{ __('barbofus.labelSkinItem'.$selectedItem->subcategory) }}</p>
            <p>Lvl. {{ $selectedItem->level }}</p>
        @endif
    </div>

    <div class="w-[min(90vw,300px)]">

        {{-- Résultat --}}
        <div class="relative w-full h-12"
            x-data="{
                show: false,
                selection: 0,

                incrementSelection()
                {
                    this.selection++;

                    if(this.selection > @js(count($items) - 1)) {
                        this.selection = 0;
                    }

                    // Puis l'ajoute et scroll sur la classe choisie
                    const toGo = document.getElementById('item-result-{{$category}}-' + this.selection);
                    goScrollToo(toGo);
                },

                decrementSelection()
                {
                    this.selection--;

                    if(this.selection < 0) {
                        this.selection = @js(count($items) - 1);
                    }

                    // Puis l'ajoute et scroll sur la classe choisie
                    const toGo = document.getElementById('item-result-{{$category}}-' + this.selection);
                    goScrollToo(toGo);
                }
            }"
            @mousedown.away="show = false">
            <label for="{{ $name }}">
                <img class="absolute h-full" src="{{ $selectedItem ? asset('https://static.barbofus.com/'. $selectedItem->icon_path) : '' }}" draggable="false">
                <input x-ref="input"
                    maxlength="30" id="{{ $name }}" type="text" placeholder="{{ $placeholder }}"
                    class="w-full h-full rounded-md pl-14 focus:outline-none placeholder-inactiveText bg-primary-100 @error($name) err-border @enderror"
                    value=""
                    wire:model="query"
                    @keydown.arrow-down.prevent="{{ (count($items) > 0) ? 'incrementSelection' : '' }}"
                    @keydown.arrow-up.prevent="{{ (count($items) > 0) ? 'decrementSelection' : '' }}"
                    @keydown.enter="{{ count($items) > 0 ? '$wire.setSelection(selection)' : ''}}"
                    @mousedown="show = true"
                    @focusin="show = true"
                    @keydown.enter.prevent="show = false, $refs.input.blur()"/>
                <input type="hidden" name="{{ $name }}" value="{{ $selectedItem ? $selectedItem->dofus_id : null }}" />
            </label>

            {{-- Menu déroulant --}}
            <div class="absolute w-full max-h-72" x-show="show">

                <div class="absolute z-50 w-full overflow-y-auto bg-primary-100 max-h-60">
                    @foreach ($items as $key => $item)
                        <button
                            type="button"
                            id="item-result-{{$category}}-{{$key}}"
                            class="flex w-full rounded-md items-center transition-all duration-75 border-2 h-12 space-x-2 cursor-pointer}"
                            :class="(selection === @js($key) ? 'border-secondary text-secondary font-normal' : 'hover:border-inactiveText border-primary-100 text-inactiveText font-light')"
                            wire:click="setSelection({{$key}})"
                            @click="show = false">

                            <img draggable="false" class="h-full select-none" src="{{ asset('https://static.barbofus.com\\'. $item->icon_path) }}" alt="">
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

    <script>
        function goScrollToo(el)
        {
            if(!el) return;

            const container = el.parentElement;

            //if (!el || !container) return;

            const elemRect = el.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            // Vérifie si l'élément est complètement visible dans le conteneur
            const isVisible =
                elemRect.top >= containerRect.top &&
                elemRect.bottom <= containerRect.bottom;

            if (!isVisible) {
                el.parentElement.scrollTo({ behavior: 'smooth', top: el.offsetTop});
            }
        }
    </script>
</div>
