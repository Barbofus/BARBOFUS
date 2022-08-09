<div>
    <div class="mt-[32px] border-t pt-[16px] flex justify-center items-center space-x-4">
        @foreach ($races as $race)
            <button wire:click="SelectRaces({{ $race->id }})">
                <img src="{{ asset('/storage/images/icons/classes/' .$race->icon_path) }}" alt="{{ $race->name }}" width="100" height="100" 
                @if (array_keys($selectedRaces, $race->id))
                    class="grayscale-0 brightness-100 transition ease-in duration-[50ms] hover:brightness-110 hover:-translate-y-2 active:scale-90"
                @else
                    class="grayscale brightness-75 transition ease-in duration-[50ms] hover:brightness-100 hover:-translate-y-2 active:scale-90"
                @endif>
            </button>
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <button wire:click="UnselectAllRaces()" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Deselectionner toutes les classes</button>
    </div>

    <div class="mt-[32px] border-t pt-[16px] flex justify-center items-center space-x-4">
        @foreach ($elements as $element)
            <button wire:click="SelectElements({{ $element->id }})">
                <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="100" height="100" 
                @if (array_keys($selectedElements, $element->id))
                class="grayscale-0 brightness-100 transition ease-in duration-[50ms] hover:brightness-110 hover:-translate-y-2 active:scale-90"
            @else
                class="grayscale brightness-75 transition ease-in duration-[50ms] hover:brightness-100 hover:-translate-y-2 active:scale-90"
            @endif>
            </button>
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <button wire:click="UnselectAllElements()" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">Deselectionner tous les élements</button>
    </div>
</div>
