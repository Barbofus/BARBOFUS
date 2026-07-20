<div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
    <x-utils.userpage-title :title="'SkinsID manquant'" :subtitle="'Trouve l\'item lié à l\'image, ou supprime là si on n\'en a pas besoin'" />

    @foreach($remainingItems as $item)
        <div class="flex h-16 p-2 my-6 space-x-8 w-fit" x-data="{id: null,}">
            <img src="{{ asset('https://static.barbofus.com/'.$item->icon_path) }}" alt="">
            <div>
                <p>{{ $item->name }}</p>
                <p>{{ $item->dofus_id }}</p>
            </div>

            <input x-model="id" type="text" class="h-12 rounded-lg bg-primary-100">

            <button @click="$wire.useSkinId(id, {{$item->dofus_id}}, 2), id = null" class="h-12 p-2 rounded-lg w-fit text-primary goldGradient">
                Valider
            </button>
        </div>
    @endforeach

    <p class="my-16">Costume</p>

    @foreach($remainingCostume as $item)
        <div class="flex h-16 p-2 my-6 space-x-8 w-fit" x-data="{idM: null, idF: null,}">
            <img src="{{ asset('https://static.barbofus.com/'.$item->icon_path) }}" alt="">
            <div>
                <p>{{ $item->name }}</p>
                <p>{{ $item->dofus_id }}</p>
            </div>

            <input x-model="idM" placeholder="Skin Mâle" type="text" class="h-12 pl-4 rounded-lg placeholder-inactiveText bg-primary-100">
            <input x-model="idF" placeholder="Skin Femelle" type="text" class="h-12 pl-4 rounded-lg placeholder-inactiveText bg-primary-100">

            <button @click="$wire.useSkinIdCostume({{$item->dofus_id}}, idM, idF), idF = null, idM = null" class="h-12 p-2 rounded-lg w-fit text-primary goldGradient">
                Valider
            </button>
        </div>
    @endforeach
</div>
