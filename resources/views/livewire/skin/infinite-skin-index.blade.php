<div>

    <div class="flex justify-center">

        {{-- Menu de trie --}}
        <x-skins.sorter />

        {{-- La grille des skins --}}
        <div>

            @for($i = 0; $i < $page && $i < $maxPage; $i++)
                <livewire:skin.skin-index-chunk :skinIds="$postIdChunks[$i]" :page="$page" :wire:key="'chunk-'.$queryCount.'-'.$i"/>
            @endfor

            {{--@foreach($skins as $key => $skin)
                <x-skins-presentation.skin-card :skin="$skin" :key="$key" :currentPage="$currentPage"/>
            @endforeach--}}

        </div>
    </div>

    @if($this->HasMorePage())
        {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
        <x-utils.load-more/>
    @endif

    {{-- Scroll horizontalement les pseudos trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/NameScroll.js'])
</div>
