<div class="grid grid-cols-[repeat(auto-fill,200px)] pt-4 px-4 gap-4 max-w-[1400px] justify-center">
    @foreach($skins as $key => $skin)
        <x-skins-presentation.skin-card :skin="$skin" :key="$key" :currentPage="$page" :itemsPerPage="$itemsPerPage"/>
    @endforeach
</div>
