<div class="text-[1.15rem]">
    <p class="font-thin text-ivory">{{ __('barbofus.labelSearchItemUsername') }}</p>

    <div
        class="w-[90%] -ml-1 relative"
        x-data="{
            selection: 0,
            items: @entangle('itemToShow'),


            EnterPressedOnSearchBar(isUser, id)
            {
                window.scrollTo({top: 0, behavior: 'smooth'});

                ToggleArrayParamToUrl('search', isUser + '' + id);
            },

            incrementSelection()
            {
                this.selection++;

                if(this.selection > @js(count($itemToShow) - 1)) {
                    this.selection = 0;
                }

                // Puis l'ajoute et scroll sur la classe choisie
                const toGo = document.getElementById('skin-filter-search-bar-result-' + this.selection);
                goScrollToo(toGo);
            },

            decrementSelection()
            {
                this.selection--;

                if(this.selection < 0) {
                    this.selection = @js(count($itemToShow) - 1);
                }

                // Puis l'ajoute et scroll sur la classe choisie
                const toGo = document.getElementById('skin-filter-search-bar-result-' + this.selection);
                goScrollToo(toGo);
            }
        }"
        x-on:click.away="{{ (count($itemToShow) > 0) ? '$wire.emptyQuery(), selection = 0' : '' }}">

        {{-- La barre de recherche --}}
        <input type="text"
               id="main-filter-search"
               class="border-transparent py-2 pl-4 focus:outline-none rounded-[2.25px] w-full mt-1 bg-primary-100 px-1 placeholder-inactiveText font-thin text-inactiveText"
               placeholder="{{ __('barbofus.inputSearchItemUsername') }}"
               maxlength="45"
               autocomplete="off"
               x-on:keydown.enter="@if(count($itemToShow) > 0)
                    $wire.emit('ToggleSearchedText', items[selection].is_user + '' + items[selection].id), EnterPressedOnSearchBar(items[selection].is_user, items[selection].id)
               @endif"
               wire:model="query"
               x-on:keydown.arrow-down.prevent="@if(count($itemToShow) > 0)
                    incrementSelection
               @endif"
               x-on:keydown.arrow-up.prevent="@if(count($itemToShow) > 0)
                    decrementSelection
               @endif">

        {{-- Liste des résultats de la recherche --}}
        <div class="absolute bg-primary-100 max-h-[18.75rem] w-full rounded-sm z-50 overflow-auto">
            @foreach($itemToShow as $key => $item)
                <button
                    id="skin-filter-search-bar-result-{{$key}}"
                    class="flex items-center w-full p-1 transition-all group"
                    :class="(selection == {{$key}} ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-10')"
                    wire:click="$emit('ToggleSearchedText', '{{$item['is_user'].$item['id'] }}')"
                    x-on:click="EnterPressedOnSearchBar('{{ $item['is_user'] }}','{{ $item['id'] }}')"
                    wire:key="{{ addslashes($item['id']) . rand() }}">
                    @if(@isset($item['icon_path']))
                        <img class="h-10 transition-all {{ ($key == $selectionKey) ? 'scale-110' : 'group-hover:scale-110' }}" src="{{ asset('https://static.barbofus.com/'. $item['icon_path']) }}">
                    @else
                        <svg class="h-10 fill-inactiveText transition-all {{ ($key == $selectionKey) ? 'scale-110' : 'group-hover:scale-110' }}" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="-10 -10 80 80" xml:space="preserve">
                            <g><g><ellipse cx="30.336" cy="12.097" rx="11.997" ry="12.097"/><path d="M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9 C48.354,35.818,42.661,30.079,35.64,30.079z"/></g></g>
                        </svg>
                    @endif
                    <p class="font-thin transition-all text-[1rem] ml-2 text-left {{ ($key == $selectionKey) ? '-translate-y-1' : 'group-hover:-translate-y-1' }}">{{ $item['name'] }}</p>
                </button>
            @endforeach
        </div>

        {{-- Affichage des filtres actuels --}}
        <div class="flex flex-wrap justify-start w-full max-h-[7rem] overflow-auto items-center gap-2 mt-2">
            @foreach($itemResults as $result)
                <button wire:click="$emit('ToggleSearchedText', {{ \Illuminate\Support\Js::from($result[0]) }})"
                        x-on:click="window.scrollTo({top: 0, behavior: 'smooth'}), ToggleArrayParamToUrl('search', {{ \Illuminate\Support\Js::from($result[0]) }})"                        class="flex justify-between items-center px-2 py-1 bg-black bg-opacity-[0.2] rounded-[2.25px] group hover:bg-opacity-100 hover:bg-primary-100 transition-colors">
                    <p class="font-light text-[1rem] text-inactiveText">{{ $result[1] }}</p>

                    <!-- Croix -->
                    <svg class="w-4 ml-2 text-red-500 group-hover:text-red-400"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endforeach
        </div>
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
