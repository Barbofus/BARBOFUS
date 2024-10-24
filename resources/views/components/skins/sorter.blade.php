<!-- Sort by -->
<div class="relative max-[850px]:order-first"
     x-data="{
              sortAsc: false,
              showSort: false,
              diceAnim: false,
              selection: '',

              SetFirstSelection()
              {
                const orderID = @js($orderByID);
                const orderDir = @js($orderDirection);

                if(orderID == 0 && orderDir == 'DESC') this.selection = 'Nouveauté';
                if(orderID == 0 && orderDir == 'ASC') this.selection = 'Ancienneté';
                if(orderID == 1 && orderDir == 'DESC') this.selection = 'Plus aimé';
                if(orderID == 1 && orderDir == 'ASC') this.selection = 'Moins aimé';
                if(orderID == 2 && orderDir == 'DESC') this.selection = 'Récompenses';
                if(orderID == 3 && orderDir == 'ASC') this.selection = 'Classes';
                if(orderID == 4 && orderDir == 'DESC') this.selection = 'Miss\'skin en cours';
                if(orderID == 5 && orderDir == 'ASC') this.selection = 'Aléatoire';
              }
            }" x-init="SetFirstSelection()">
    <div class="flex items-center justify-around gap-x-2"
         x-on:mousedown.outside="if(showSort) showSort = false">

        {{-- Randomizer --}}
        <button aria-label="Skins Aléatoire" class="h-10 w-10 mr-4 max-[400px]:hidden" :class="diceAnim ? 'animate-dice [--custom-animation-time:0.7s]' : ''" wire:ignore wire:key="dice"
                @click.throttle.700ms="diceAnim = true; setTimeout(() => {diceAnim = false},700); selection = 'Aléatoire'; sortAsc = true; showSort = false; $wire.SortBy(5, 'ASC'), AddParamToUrl('sort', '5,ASC'), window.scrollTo(0,0)">
            <img src="{{ asset('storage/images/misc_ui/simple_dice.png') }}" alt="Skin Aléatoire" height="40" width="40" draggable="false" class="h-full hover:scale-90 transition-all">
        </button>

        <!-- Icone -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-cloak
             class="w-6 h-6 transition-all duration-100 stroke-secondary"
             :class="sortAsc ? '' : 'rotate-90'">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
        </svg>

        <!-- Trier par: Texte -->
        <p class="text-secondary font-thin text-[1rem]">Trier par: </p>
        <p class="cursor-pointer rounded-t-md w-48 px-4 text-[1.15rem] font-normal transition-all duration-200 border-t border-primary"
           :class="showSort ? 'text-primary bg-secondary' : 'text-secondary hover:bg-primary-100 '"
           x-on:mousedown="showSort = !showSort" x-text="selection"></p>

        <!-- Menu déroulant -->
        <div class="w-48 right-0 top-[2.25rem] overflow-hidden rounded-b-md absolute bg-secondary-100 text-[1rem] text-primary font-light transition-all duration-200 cursor-pointer"
             x-show="showSort" x-transition.opacity x-cloak>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Nouveauté'; sortAsc = false; showSort = false; $wire.SortBy(0, 'DESC'), AddParamToUrl('sort', '0,DESC'), window.scrollTo(0,0)">Nouveauté</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Ancienneté'; sortAsc = true; showSort = false; $wire.SortBy(0, 'ASC'), AddParamToUrl('sort', '0,ASC'), window.scrollTo(0,0)">Ancienneté</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Plus aimé'; sortAsc = false; showSort = false; $wire.SortBy(1, 'DESC'), AddParamToUrl('sort', '1,DESC'), window.scrollTo(0,0)">Plus aimé</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Moins aimé'; sortAsc = true; showSort = false; $wire.SortBy(1, 'ASC'), AddParamToUrl('sort', '1,ASC'), window.scrollTo(0,0)">Moins aimé</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Récompenses'; sortAsc = false; showSort = false; $wire.SortBy(2, 'DESC'), AddParamToUrl('sort', '2,DESC'), window.scrollTo(0,0)">Récompenses</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Classes'; sortAsc = true; showSort = false; $wire.SortBy(3, 'ASC'), AddParamToUrl('sort', '3,ASC'), window.scrollTo(0,0)">Classes</button>
            <button class="w-full h-full px-4 py-1 hover:bg-secondary"
                    x-on:mousedown="selection = 'Miss\'skin en cours'; sortAsc = true; showSort = false; $wire.SortBy(4, 'DESC'), AddParamToUrl('sort', '4,DESC'), window.scrollTo(0,0)">Miss'skin en cours</button>
        </div>
    </div>
</div>
