<div x-data="{ skinDeleteID: null, skinDeleteImg: '', }">
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Mes skins'" :subtitle="'Tes propres créations'" />

        <div class="bg-primary w-full flex justify-center sticky top-12 py-8 z-10">
            <a href="{{ route('skins.create') }}" class="goldGradient px-4 py-2 rounded-md text-primary flex flex-col transition-all items-center text-2xl hover:rounded-3xl group hover:brightness-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                <p class="group-hover:-translate-y-2 transition-all">Poster un skin</p>
            </a>
        </div>

        <div class="flex-1 flex flex-col items-center mb-10">
            @if(count($postIdChunks) > 0)
                @for($i = 0; $i < $page && $i < $maxPage; $i++)
                    <livewire:user-panel.myskins-chunk :skinIds="$postIdChunks[$i]" :page="$page" :itemsPerPage="Self::ITEMS_PER_PAGE" :wire:key="'chunk-'.$queryCount.'-'.$i"/>
                @endfor
            @else
                <img class="mt-8 h-[256px]" src="{{ asset('storage/images/misc_ui/Barbe_pleure.png') }}">
                <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Encore aucun skin posté !</span></p>
            @endif

            {{-- Utils qui permet de charger plus de skins, nécessite une fonction LoadMore() dans le ficher Livewire --}}
            @if($this->HasMorePage())
                <x-utils.load-more/>
            @endif
        </div>
    </div>

    <div class="fixed top-0 right-0 bottom-0 left-0"
         x-show="skinDeleteID"  x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-full">
        <x-utils.skin-delete-verification />
    </div>
</div>
