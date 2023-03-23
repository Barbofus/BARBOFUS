@extends('layouts.user-page-views')

@section('content')

    <div class="grid grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 transition-all duration-300">
        @foreach($skins as $skin)

            {{-- Gros container d'un skin --}}
            <div
                class="mt-2 flex space-x-2 items-center"
                x-data="{
                    open: false,
                    inTransition: false,
                    SwitchOpen(){
                        if(!this.open) {
                            this.open = true;
                            return;
                        }

                        this.open = false;
                        this.inTransition = true;
                        setTimeout(() => { this.inTransition = false }, 400);
                    }
                }"
                :class="open || inTransition ? 'col-span-3' : ''"
            >

                {{-- L'image --}}
                <button
                    class="flex flex-col items-center hover:bg-gray-200 rounded-md"
                    x-on:click="SwitchOpen"
                >

                    {{-- Classe + ID --}}
                    <div class="flex items-center space-x-2">
                        <img draggable="false" width="64" src="{{ asset('storage/images/icons/classes/' . $skin->Race->icon_path) }}">
                        <div class="flex flex-col items-baseline">
                            <p class="text-gray-400 italic text-sm">ID#{{ $skin->id }}</p>
                            <p class="text-xl">{{ $skin->Race->name }}</p>
                        </div>
                    </div>

                    {{-- Image --}}
                    <img draggable="false" width="200" src="{{ asset('storage/' . $skin->image_path) }}">
                </button>

                {{-- Détails --}}
                <div class="flex space-x-2 items-center"
                     x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-x-full"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0 -translate-x-1/2">

                    {{-- Items --}}
                    <div>
                        @if(isset($skin->dofus_item_hat_id))
                            <x-skins-presentation.item :item="$skin->DofusItemHat"/>
                        @endif

                        @if(isset($skin->dofus_item_cloak_id))
                            <x-skins-presentation.item :item="$skin->DofusItemCloak"/>
                        @endif

                        @if(isset($skin->dofus_item_shield_id))
                            <x-skins-presentation.item :item="$skin->DofusItemShield"/>
                        @endif

                        @if(isset($skin->dofus_item_pet_id))
                            <x-skins-presentation.item :item="$skin->DofusItemPet"/>
                        @endif

                        @if(isset($skin->dofus_item_costume_id))
                            <x-skins-presentation.item :item="$skin->DofusItemCostume"/>
                        @endif
                    </div>

                    {{-- Sexe / Visage / Couleurs --}}
                    <div class="pl-4 flex flex-col space-y-2">
                        <p>{{ $skin->gender }}</p>
                        <p>Visage: {{ $skin->face }}</p>

                        <x-skins-presentation.color :color="$skin->color_skin"/>
                        <x-skins-presentation.color :color="$skin->color_hair"/>
                        <x-skins-presentation.color :color="$skin->color_cloth_1"/>
                        <x-skins-presentation.color :color="$skin->color_cloth_2"/>
                        <x-skins-presentation.color :color="$skin->color_cloth_3"/>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
