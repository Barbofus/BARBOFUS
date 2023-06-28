@extends('layouts.user-page-views')

@section('content')

    <div class="grid justify-center grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 transition-all duration-300">
        @foreach($skins as $key => $skin)

            <template x-if="true">
                {{-- Gros container d'un skin --}}
                <div
                    class="mt-2 flex space-y-2 flex-col"
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
                            setTimeout(() => { this.inTransition = false }, 700);
                        }
                    }"
                    :class="open || inTransition ? 'col-span-3' : ''"
                >

                    <div class="flex space-x-2 items-center">

                        {{-- L'image --}}
                        <button
                            class="flex flex-col items-center hover:bg-gray-200 rounded-md"
                            x-on:click="SwitchOpen"
                            :class="open || inTransition ? 'bg-gray-200' : ''"
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

                            <p class="text-gray-500 italic">{{ $skin->user->name }}</p>
                        </button>

                        {{-- Détails --}}
                        <div class="flex space-x-2 items-center"
                             x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-x-full"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in delay-300 duration-300"
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
                                <p>Visage n°{{ $skin->face }}</p>

                                <x-skins-presentation.color :color="$skin->color_skin" :name="'Peau'"/>
                                <x-skins-presentation.color :color="$skin->color_hair" :name="'Cheveux'"/>
                                <x-skins-presentation.color :color="$skin->color_cloth_1" :name="'Habits 1'"/>
                                <x-skins-presentation.color :color="$skin->color_cloth_2" :name="'Habits 2'"/>
                                <x-skins-presentation.color :color="$skin->color_cloth_3" :name="'Habits 3'"/>
                            </div>
                        </div>
                    </div>

                    {{-- Bouton de validation --}}
                    <div
                        class="flex space-x-2"
                        x-show="open" x-cloak
                        x-transition:enter="transition ease-out delay-300 duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-full"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 -translate-y-1/2">

                        <form method="POST" action="{{ route('accept-skin', ['skin' => $skin]) }}">
                            @csrf
                            @method('PUT')

                            <button class="w-36 h-12 text-white bg-green-500 rounded-md text-xl hover:bg-green-400">Accepter</button>
                        </form>

                        <form method="POST" action="{{ route('refuse-skin', ['skin' => $skin]) }}" class="flex space-x-2 flex-1">
                            @csrf
                            @method('PUT')

                            <button class="w-36 h-12 text-white bg-red-500 rounded-md text-xl hover:bg-red-400">Refuser</button>
                            <textarea
                                type="text" name="reason" placeholder="Raison du refus ..." maxlength="128"
                                class="rounded-md border border-gray-400 flex-1 text-sm h-12 p-2"></textarea>
                        </form>
                    </div>
                </div>
            </template>
        @endforeach
    </div>
@endsection
