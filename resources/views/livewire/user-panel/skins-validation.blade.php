<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Skins en Attente'" :subtitle="'Accepte ou refuse les skins'" />


        <div class="grid justify-center grid-cols-[repeat(auto-fill,40rem)] p-4 gap-4">
            @foreach($skins as $key => $skin)

                {{-- Gros container d'un skin --}}
                <div
                    wire:key="'skins-validation-{{ $skin->id }}-{{ rand() }}'"
                    class="mt-2 flex space-y-2 flex-col">

                    <div class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 items-center">

                        {{-- L'image --}}
                        <div class="flex flex-col items-center rounded-md">

                            {{-- Classe + ID --}}
                            <div class="flex items-center space-x-2 w-full">
                                <img draggable="false" width="64" src="{{ asset('storage/' . $skin->race_icon) }}">
                                <div class="flex flex-col items-baseline">
                                    <p class="text-inactiveText italic text-sm">
                                        @if(isset($skin->name))
                                            {{ $skin->name }}
                                        @else
                                            ID#{{ $skin->id }}
                                        @endif
                                    </p>
                                    <p class="text-xl">{{ $skin->race_name }}</p>
                                </div>
                            </div>

                            {{-- Image --}}
                            <img draggable="false" width="200" src="{{ asset('storage/' . $skin->image_path) }}">

                            <p class="text-inactiveText italic">{{ $skin->user_name }}</p>
                        </div>

                        {{-- Détails --}}
                        <div class="flex flex-col min-[750px]:flex-row min-[750px]:space-x-2 items-center min-[750px]:h-full max-[749px]:w-full">

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

                                    <div class="flex items-center justify-center space-x-4">
                                        <p class="text-secondary font-thin text-md min-[750px]:text-lg">Visage n°<span class="font-normal">{{ $skin->face }}</span></p>
                                        <img src="{{  asset(sprintf("storage/images/icons/classes/faces/%s%d_%s.png", $skin->race_dofus_id, $skin->gender === 'Homme' ? 0 : 1, $skin->face)) }}"
                                             alt="Visage {{ $skin->race_name }} n° {{ $skin->face }}" draggable="false" class="h-12">
                                    </div>
                                </div>

                                <div>
                                    @if(isset($skin->dofus_item_hat_id))
                                        <x-skins-presentation.item-validation :name="$skin->dofus_item_hat_name" :icon="$skin->dofus_item_hat_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_cloak_id))
                                        <x-skins-presentation.item-validation :name="$skin->dofus_item_cloak_name" :icon="$skin->dofus_item_cloak_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_shield_id))
                                        <x-skins-presentation.item-validation :name="$skin->dofus_item_shield_name" :icon="$skin->dofus_item_shield_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_pet_id))
                                        <x-skins-presentation.item-validation :name="$skin->dofus_item_pet_name" :icon="$skin->dofus_item_pet_icon"/>
                                    @endif

                                    @if(isset($skin->dofus_item_costume_id))
                                        <x-skins-presentation.item-validation :name="$skin->dofus_item_costume_name" :icon="$skin->dofus_item_costume_icon"/>
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
                    <div class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 relative pb-8">

                        <button wire:click="acceptSkin({{ $skin->id }})"
                                class="px-4 h-12 text-primary goldGradient transition-all hover:rounded-3xl hover:tracking-widest rounded-md text-md min-[750px]:text-xl hover:brightness-110">Accepter</button>

                        <div class="flex min-[750px]:space-x-2 flex-1" x-data="{ refused_reason: '' }">

                            <button @click="$wire.refuseSkin(refused_reason, {{ $skin->id }}), refused_reason = ''" class="px-4 h-12 absolute top-0 right-0 text-primary transition-all hover:rounded-3xl hover:tracking-widest heartGradient rounded-md text-md min-[750px]:text-xl hover:brightness-110 min-[750px]:static">Refuser</button>
                            <textarea
                                type="text" name="reason" placeholder="Raison du refus ..." maxlength="128"
                                class="rounded-md text-md text-secondary placeholder:text-inactiveText bg-primary-100 flex-1 h-12 p-2"
                                x-model="refused_reason"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
