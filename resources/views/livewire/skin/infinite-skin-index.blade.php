<div>

    <div class="bg-red-400 p-4 flex flex-col items-center">
        <p>Actual Skin count: <span>{{ count($skins) }}</span> </p>
        <button class="p-4 rounded-md bg-red-800 mt-4 text-white hover:bg-red-700"
                wire:click="LoadMore()">
            Load more
        </button>
        <button class="p-4 rounded-md bg-red-800 mt-4 text-white hover:bg-red-700"
                wire:click="SortByID()">
            Sort by ID
        </button>
    </div>

    <div class="flex justify-center">
        <div class="grid grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 max-w-[1400px] justify-center">

            @foreach($skins as $skin)
                <div>
                    <p>{{ $skin->id }}</p>
                    <img src="{{ asset('storage\/') . $skin->image_path }}">
                    <p>{{ $skin->User->name }}</p>
                </div>
            @endforeach

        </div>
    </div>

    <div class="bg-red-400 p-4 flex flex-col items-center">
        <p>Actual Skin count: <span>{{ count($skins) }}</span> </p>
        <button class="p-4 rounded-md bg-red-800 mt-4 text-white hover:bg-red-700"
                wire:click="LoadMore()">
            Load more
        </button>
    </div>
</div>
