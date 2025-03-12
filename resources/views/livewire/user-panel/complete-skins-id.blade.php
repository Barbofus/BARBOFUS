<div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
    <x-utils.userpage-title :title="'SkinsID manquant'" :subtitle="'Trouve l\'item lié à l\'image, ou supprime là si on n\'en a pas besoin'" />

    @foreach($remainingItems as $item)
        <div class="flex space-x-8 h-16 my-6 w-fit p-2" x-data="{id: null,}">
            <img src="{{ asset('storage/'.$item->icon_path) }}" alt="">
            <div>
                <p>{{ $item->name }}</p>
                <p>{{ $item->dofus_id }}</p>
            </div>

            <input x-model="id" type="text" class="h-12 bg-primary-100 rounded-lg">

            <button @click="$wire.useSkinId(id, {{$item->dofus_id}}, 2), id = null" class="h-12 w-fit p-2 text-primary goldGradient rounded-lg">
                Valider
            </button>
        </div>
    @endforeach

    <p class="my-16">Costume</p>

    @foreach($remainingCostume as $item)
        <div class="flex space-x-8 h-16 my-6 w-fit p-2" x-data="{idM: null, idF: null,}">
            <img src="{{ asset('storage/'.$item->icon_path) }}" alt="">
            <div>
                <p>{{ $item->name }}</p>
                <p>{{ $item->dofus_id }}</p>
            </div>

            <input x-model="idM" placeholder="Skin Mâle" type="text" class="h-12 pl-4 placeholder-inactiveText bg-primary-100 rounded-lg">
            <input x-model="idF" placeholder="Skin Femelle" type="text" class="h-12 pl-4 placeholder-inactiveText bg-primary-100 rounded-lg">

            <button @click="$wire.useSkinIdCostume({{$item->dofus_id}}, idM, idF), idF = null, idM = null" class="h-12 w-fit p-2 text-primary goldGradient rounded-lg">
                Valider
            </button>
        </div>
    @endforeach
</div>
