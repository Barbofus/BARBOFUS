<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Mes likes'" :subtitle="'Ton historique de likes'" />

        <div class="flex-1 flex flex-col items-center mb-10">
            @if(count($postIdChunks) > 0)
                @for($i = 0; $i < $page && $i < $maxPage; $i++)
                    <livewire:user-panel.mylikes-chunk :skinIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$queryCount.'-'.$i"/>
                @endfor
            @else
                <img class="mt-8 h-[256px]" src="{{ asset('storage/images/misc_ui/Barbe_pleure.png') }}">
                <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Tu n'as encore rien aimé !</span></p>
            @endif

            {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
            @if($this->HasMorePage())
                <x-utils.load-more/>
            @endif
        </div>
    </div>

</div>
