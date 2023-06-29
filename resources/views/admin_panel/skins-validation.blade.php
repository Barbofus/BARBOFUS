@extends('layouts.user-page-views')

@section('content')
    <h1 class="text-[min(3.5rem,max(5vw,1.5rem))] font-normal text-center uppercase">Skins en Attente</h1>
    <h2 class="text-2xl font-thin text-center mb-8 uppercase">Accepte ou refuse les skins</h2>

    <div class="grid justify-center grid-cols-[repeat(auto-fill,200px)] p-4 gap-4">
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
                    :class="open || inTransition ? 'min-[750px]:col-span-3' : ''"
                >

                    <div class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 items-center">

                        {{-- L'image --}}
                        <button
                            class="flex flex-col items-center transition-colors rounded-md"
                            x-on:click="SwitchOpen"
                            :class="open || inTransition ? 'bg-primary-100' : 'hover:bg-primary-100 '"
                        >

                            {{-- Classe + ID --}}
                            <div class="flex items-center space-x-2 w-full">
                                <img draggable="false" width="64" src="{{ asset('storage/' . $skin->race_icon) }}">
                                <div class="flex flex-col items-baseline">
                                    <p class="text-inactiveText italic text-sm">ID#{{ $skin->id }}</p>
                                    <p class="text-xl">{{ $skin->race_name }}</p>
                                </div>
                            </div>

                            {{-- Image --}}
                            <img draggable="false" width="200" src="{{ asset('storage/' . $skin->image_path) }}">

                            <p class="text-inactiveText italic">{{ $skin->user_name }}</p>
                        </button>

                        {{-- Détails --}}
                        <div class="flex flex-col min-[750px]:flex-row min-[750px]:space-x-2 items-center min-[750px]:h-full max-[749px]:w-full"
                             x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-x-full"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in delay-300 duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0 -translate-x-1/2">

                            {{-- Items --}}
                            <div>

                                <div class="flex gap-x-8 justify-center items-center">
                                    <div class="flex gap-x-2 items-center">
                                        @if($skin->gender == 'Femme')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-6" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                                            </svg>
                                        @endif
                                        <p class="text-secondary font-thin text-lg min-[750px]:text-xl">{{ $skin->gender }}</p>
                                    </div>
                                    <p class="text-secondary font-thin text-lg min-[750px]:text-xl">Visage n°<span class="font-normal">{{ $skin->face }}</span></p>
                                </div>

                                <div>
                                    @if(isset($skin->dofus_item_hat_id))
                                        <x-skins-presentation.item :name="$skin->dofus_item_hat_name" :level="$skin->dofus_item_hat_level" :icon="$skin->dofus_item_hat_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_cloak_id))
                                        <x-skins-presentation.item :name="$skin->dofus_item_cloak_name" :level="$skin->dofus_item_cloak_level" :icon="$skin->dofus_item_cloak_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_shield_id))
                                        <x-skins-presentation.item :name="$skin->dofus_item_shield_name" :level="$skin->dofus_item_shield_level" :icon="$skin->dofus_item_shield_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_pet_id))
                                        <x-skins-presentation.item :name="$skin->dofus_item_pet_name" :level="$skin->dofus_item_pet_level" :icon="$skin->dofus_item_pet_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_costume_id))
                                        <x-skins-presentation.item :name="$skin->dofus_item_costume_name" :level="$skin->dofus_item_costume_level" :icon="$skin->dofus_item_costume_icon"/>
                                    @endif
                                </div>
                            </div>

                            {{-- Couleurs --}}
                            <div class="pl-10 min-[750px]:pl-4 flex flex-col items-start justify-between min-[750px]:h-full max-[749px]:w-full">
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
                        class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 relative"
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

                            <button class="px-4 h-12 text-primary goldGradient transition-all hover:rounded-sm rounded-md text-md min-[750px]:text-xl hover:brightness-110">Accepter</button>
                        </form>

                        <form method="POST" action="{{ route('refuse-skin', ['skin' => $skin]) }}" class="flex min-[750px]:space-x-2 flex-1">
                            @csrf
                            @method('PUT')

                            <button class="px-4 h-12 absolute top-0 right-0 text-primary transition-all hover:rounded-sm heartGradient rounded-md text-md min-[750px]:text-xl hover:brightness-110 min-[750px]:static">Refuser</button>
                            <textarea
                                type="text" name="reason" placeholder="Raison du refus ..." maxlength="128"
                                class="rounded-md text-md text-secondary placeholder:text-inactiveText bg-primary-100 flex-1 h-12 p-2"></textarea>
                        </form>
                    </div>
                </div>
            </template>
        @endforeach
    </div>
@endsection
