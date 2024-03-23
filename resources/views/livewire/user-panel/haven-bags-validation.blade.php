<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Skins en Attente'" :subtitle="'Accepte ou refuse les skins'" />


        <div class="p-4">
            @foreach($havenBags as $key => $havenBag)

                {{-- Gros container d'un skin --}}
                <div wire:key="'haven-bags-validation-{{ $havenBag->id }}-{{ rand() }}'">

                    <div class="mt-2 flex space-x-4 w-full">
                        <div class="w-1/3">
                            <div class="flex space-x-2">
                                <img src="{{ asset('storage/' . $havenBag->popocket_icon_path) }}" alt="" draggable="false" class="h-[5rem]">
                                <div>
                                    <p class="text-xl italic">{{ $havenBag->name }}</p>
                                    <p class="text-lg font-thin">par <span class="text-xl font-normal">{{ $havenBag->user_name }}</span></p>
                                    <p class="italic text-inactiveText">Thème : Havre-sac {{ $havenBag->haven_bag_theme_name }}</p>
                                </div>
                            </div>
                            <img src="{{ asset('storage/' . $havenBag->haven_bag_theme_image_path) }}" alt="" draggable="false" class="w-full">
                        </div>

                        <div class="flex-1 bg-green-400 overflow-hidden">
                            <img src="{{ asset('storage/' . $havenBag->image_path) }}" draggable="false" alt="">
                        </div>
                    </div>

                    {{-- Bouton de validation --}}
                    <div class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 relative pb-8 mt-6">

                        <button wire:click="acceptHavenBag({{ $havenBag->id }})"
                                class="px-4 h-12 text-primary goldGradient transition-all hover:rounded-3xl hover:tracking-widest rounded-md text-md min-[750px]:text-xl hover:brightness-110">Accepter</button>

                        <div class="flex min-[750px]:space-x-2 flex-1" x-data="{ refused_reason: '' }">

                            <button @click="$wire.refuseHavenBag(refused_reason, {{ $havenBag->id }}), refused_reason = ''" class="px-4 h-12 absolute top-0 right-0 text-primary transition-all hover:rounded-3xl hover:tracking-widest heartGradient rounded-md text-md min-[750px]:text-xl hover:brightness-110 min-[750px]:static">Refuser</button>
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
