<div>

    {{-- La grille des skins --}}
    <div class="flex justify-center">
        <x-skins.sorter />
        <div class="grid grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 max-w-[1400px] justify-center">

            @foreach($skins as $key => $skin)
                <x-skins-presentation.skin-card :skin="$skin" :key="$key" :currentPage="$currentPage"/>
            @endforeach

        </div>
    </div>

    {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
    <x-utils.load-more/>
</div>
