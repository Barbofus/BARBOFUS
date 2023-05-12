<!-- Sort by -->
<div class="relative max-[500px]:order-first"
     x-data="{
              sortAsc: true,
              showSort: false,
              selection: 'Nouveauté'
            }">
    <div class="flex items-center justify-around gap-x-2"
         x-on:mousedown.outside="if(showSort) showSort = false">

        <!-- Icone -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-6 h-6 transition-all duration-100 stroke-secondary"
             :class="sortAsc ? '' : 'rotate-90'">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
        </svg>

        <!-- Trier par: Texte -->
        <p class="text-secondary font-thin text-[1rem]">Trier par: </p>
        <p class="cursor-pointer rounded-t-md w-40 px-4 text-[1.15rem] font-normal transition-all duration-200"
           :class="showSort ? 'text-primary bg-secondary' : 'text-secondary hover:bg-primary-100 '"
           x-on:mousedown="showSort = !showSort" x-text="selection"></p>

        <!-- Menu déroulant -->
        <div class="w-40 right-0 top-[30px] overflow-hidden rounded-b-md z-50 absolute bg-secondary-100 text-[1rem] text-primary font-light transition-all duration-200 cursor-pointer "
             x-show="showSort" x-transition.opacity>
            <p class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Nouveauté'; sortAsc = true; showSort = false; $wire.SortBy('updated_at', 'DESC')">Nouveauté</p>
            <p class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Ancienneté'; sortAsc = false; showSort = false; $wire.SortBy('updated_at', 'ASC')">Ancienneté</p>
            <p class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Plus aimé'; sortAsc = false; showSort = false">Plus aimé</p>
            <p class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Moins aimé'; sortAsc = true; showSort = false">Moins aimé</p>
            <p class="w-full h-full px-4 py-1 hover:bg-secondary"
               x-on:mousedown="selection = 'Récompenses'; sortAsc = false; showSort = false">Récompenses</p>
        </div>
    </div>
</div>
