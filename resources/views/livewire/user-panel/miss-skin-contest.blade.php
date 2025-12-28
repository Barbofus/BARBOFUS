<div>

    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]" x-data="{
        favorites: JSON.parse(localStorage.getItem('missSkinFavorites') || '[]'),
        selectedTops: {
            top1: null,
            top2: null,
            top3: null
        },
        init() {
            // Synchroniser avec les valeurs Livewire au chargement
            this.selectedTops.top1 = $wire.selectedTop3?.top1 || null;
            this.selectedTops.top2 = $wire.selectedTop3?.top2 || null;
            this.selectedTops.top3 = $wire.selectedTop3?.top3 || null;
        },
        toggleFavorite(skinId) {
            const id = skinId.toString();
            if (this.favorites.includes(id)) {
                this.favorites = this.favorites.filter(f => f !== id);
            } else {
                this.favorites.push(id);
            }
            localStorage.setItem('missSkinFavorites', JSON.stringify(this.favorites));
            this.favorites = [...this.favorites]; // Force reactivity
        },
        isInFavorites(skinId) {
            return this.favorites.includes(skinId.toString())
        },
        setTop(skinId, position) {
            // Toggle logic: si déjà sélectionné à cette position, le retirer
            if (this.selectedTops[position] === skinId) {
                this.selectedTops[position] = null;
                return;
            }
    
            // Retirer ce skin de toutes les autres positions
            Object.keys(this.selectedTops).forEach(key => {
                if (this.selectedTops[key] === skinId) {
                    this.selectedTops[key] = null;
                }
            });
            // Définir la nouvelle position
            this.selectedTops[position] = skinId;
        },
        isInTop(skinId, position) {
            return this.selectedTops[position] === skinId;
        },
        hasAllTops() {
            return this.selectedTops.top1 && this.selectedTops.top2 && this.selectedTops.top3;
        },
        syncTopsWithLivewire() {
            $wire.call('syncTops', this.selectedTops);
        }
    }">

        {{-- Header with theme management --}}
        <div class="mb-8">
            <h1 class="mb-6 text-3xl font-thin text-center text-secondary">Concours MissSkin</h1>

            <div class="flex items-center justify-center gap-6">
                <div class="p-6 rounded-lg bg-primary-100">
                    <h2 class="mb-4 text-xl font-light text-secondary">Thème du concours</h2>
                    <div class="flex items-center gap-4 w-96">
                        <input type="text" wire:model.defer="currentTheme"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary"
                            placeholder="Définir le thème du concours...">
                        <button wire:click="updateTheme"
                            class="px-6 py-2 transition-colors rounded-md bg-secondary text-primary hover:bg-secondary-600">
                            Mettre à jour
                        </button>
                    </div>
                </div>

                {{-- Finalize contest button --}}
                <div x-show="hasAllTops()" x-transition>
                    @if ($showConfirmFinalize)
                        <div class="p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                            <p class="mb-3 text-yellow-800">⚠️ Voulez-vous finaliser le concours ?</p>
                            <button @click="syncTopsWithLivewire(); $wire.finalizeContest()"
                                class="px-6 py-2 text-white transition-colors bg-green-600 rounded-md hover:bg-green-700">
                                Finaliser le concours
                            </button>
                        </div>
                    @else
                        <button @click="syncTopsWithLivewire(); $wire.showConfirmFinalize = true"
                            class="px-6 py-2 text-white transition-colors bg-green-600 rounded-md hover:bg-green-700">
                            Finaliser le concours
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top 3 favorites section --}}
        <div class="mb-8">

            {{-- Favorites display --}}
            <div class="mb-8">
                <h3 class="mb-4 text-xl font-light text-secondary">Skins favoris</h3>
                <div class="grid grid-cols-[repeat(auto-fill,15rem)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,93rem)] justify-center"
                    x-show="favorites.length > 0" x-transition>
                    <template x-for="skinId in favorites" :key="skinId">
                        <div class="aspect-[14/19] h-full relative w-full group">
                            @foreach ($contestSkins as $skin)
                                <div x-show="'{{ $skin->id }}' === skinId.toString()">
                                    {{-- Skin image with background --}}
                                    <a class="absolute w-full h-full slidingCard group"
                                        title="Skin dofus {{ $skin->race_name ?? '' }}"
                                        href="{{ route('unity-skins.show', $skin->id) }}">

                                        <div
                                            class="absolute top-0 left-0 w-full h-full overflow-hidden transition-all rounded-md cursor-pointer -z-10 bg-primary-100 group-hover:brightness-125">
                                            <div
                                                class="skinBackGround bg-[linear-gradient(0deg,rgba(255,255,255,0)36%,rgba(255,255,255,0.05)40%,rgba(255,255,255,0)100%)] w-[200%] h-full rotate-[30deg] origin-bottom-right absolute right-0 top-[-12.5rem]">
                                            </div>
                                        </div>

                                        <div class="absolute top-[1.5rem] w-full h-[calc(100%-3rem)] cursor-pointer">
                                            <img src="{{ asset('storage/' . $skin->image_path) }}"
                                                title="Skin dofus {{ $skin->race_name ?? '' }}" loading="lazy"
                                                class="h-full mx-auto transition-transform group-hover:scale-105"
                                                draggable="false">
                                        </div>
                                    </a>

                                    {{-- Pseudo du joueur --}}
                                    <div class="absolute bottom-0 z-10 left-0 w-[calc(100%-3.75rem)] px-1 pb-[2px]">
                                        <p
                                            class="flex w-full h-12 items-end overflow-hidden font-light text-goldText text-[0.75rem] whitespace-nowrap">
                                            {{ $skin->user->name ?? 'Utilisateur' }}&nbsp
                                        </p>
                                    </div>

                                    {{-- Controls overlay --}}
                                    <div class="absolute z-20 flex justify-between w-full px-2 text-inactiveText top-6">
                                        {{-- Heart favorite button --}}
                                        <button @click.stop="toggleFavorite({{ $skin->id }})"
                                            class="p-1 text-red-500 transition-all hover:scale-125">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Top buttons on hover --}}
                                    <div
                                        class="absolute top-0 bottom-0 left-0 z-10 p-2 transition-opacity opacity-0 bg-gradient-to-r from-black/20 to-transparent group-hover:opacity-100">
                                        <div class="flex flex-col items-center justify-center h-full gap-6 pl-2">

                                            {{-- TOP 1 Button --}}
                                            <button type="button" @click.stop="setTop({{ $skin->id }}, 'top1')"
                                                class="relative px-3 py-2 text-sm text-white rounded group/top1 bg-primary">
                                                <div :class="selectedTops.top1 === {{ $skin->id }} ? 'opacity-100' : 'opacity-0'"
                                                    class="absolute transition-all group-hover/top1:opacity-100 -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 goldGradient">
                                                </div>
                                                TOP 1
                                            </button>

                                            {{-- TOP 2 Button --}}
                                            <button type="button" @click.stop="setTop({{ $skin->id }}, 'top2')"
                                                class="relative px-3 py-2 text-sm text-white rounded group/top2 bg-primary">
                                                <div :class="selectedTops.top2 === {{ $skin->id }} ? 'opacity-100' : 'opacity-0'"
                                                    class="absolute opacity-0 transition-all group-hover/top2:opacity-100 -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 emeraldGradient">
                                                </div>
                                                TOP 2
                                            </button>

                                            {{-- TOP 3 Button --}}
                                            <button type="button" @click.stop="setTop({{ $skin->id }}, 'top3')"
                                                class="relative px-3 py-2 text-sm text-white rounded group/top3 bg-primary">
                                                <div :class="selectedTops.top3 === {{ $skin->id }} ? 'opacity-100' : 'opacity-0'"
                                                    class="absolute opacity-0 transition-all group-hover/top3:opacity-100 -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 cawotteGradient">
                                                </div>
                                                TOP 3
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Skin name --}}
                                    <p
                                        class="absolute italic transition-all top-1 text-inactiveText group-hover:text-secondary text-md left-2">
                                        {{ $skin->name ?? 'ID#' . $skin->id }}&nbsp
                                    </p>

                                    {{-- Top gradient borders --}}
                                    <div x-show="isInTop({{ $skin->id }}, 'top1')"
                                        class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 goldGradient">
                                    </div>
                                    <div x-show="isInTop({{ $skin->id }}, 'top2')"
                                        class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 emeraldGradient">
                                    </div>
                                    <div x-show="isInTop({{ $skin->id }}, 'top3')"
                                        class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 cawotteGradient">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </template>
                </div>
                <div x-show="favorites.length === 0" class="py-8 text-center text-gray-500">
                    Aucun skin en favori. Ajoutez des skins ci-dessous.
                </div>
            </div>
        </div>

        {{-- Contest skins grid --}}
        <div class="mb-8">
            <h2 class="mb-4 text-2xl font-light text-secondary">Skins en concours</h2>

            <div
                class="grid grid-cols-[repeat(auto-fill,15rem)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,93rem)] justify-center">

                @forelse($contestSkins as $skin)
                    <div class="aspect-[14/19] h-full relative w-full group">
                        {{-- Skin image with background --}}
                        <a class="absolute w-full h-full slidingCard group"
                            title="Skin dofus {{ $skin->race_name ?? '' }}"
                            href="{{ route('unity-skins.show', $skin->id) }}">

                            <div
                                class="absolute top-0 left-0 w-full h-full overflow-hidden transition-all rounded-md cursor-pointer -z-10 bg-primary-100 group-hover:brightness-125">
                                <div
                                    class="skinBackGround bg-[linear-gradient(0deg,rgba(255,255,255,0)36%,rgba(255,255,255,0.05)40%,rgba(255,255,255,0)100%)] w-[200%] h-full rotate-[30deg] origin-bottom-right absolute right-0 top-[-12.5rem]">
                                </div>
                            </div>

                            <div class="absolute top-[1.5rem] w-full h-[calc(100%-3rem)] cursor-pointer">
                                <img src="{{ asset('storage/' . $skin->image_path) }}"
                                    title="Skin dofus {{ $skin->race_name ?? '' }}" loading="lazy"
                                    class="h-full mx-auto transition-transform group-hover:scale-105" draggable="false">
                            </div>
                        </a>

                        {{-- Pseudo du joueur --}}
                        <div class="absolute bottom-0 z-10 left-0 w-[calc(100%-3.75rem)] px-1 pb-[2px]">
                            <p
                                class="flex w-full h-12 items-end overflow-hidden font-light text-goldText text-[0.75rem] whitespace-nowrap">
                                {{ $skin->user->name ?? 'Utilisateur' }}&nbsp
                            </p>
                        </div>

                        {{-- Controls overlay --}}
                        <div class="absolute z-20 flex justify-between w-full px-2 text-inactiveText top-6">
                            {{-- Heart favorite button --}}
                            <button @click.stop="toggleFavorite({{ $skin->id }})"
                                :class="isInFavorites({{ $skin->id }}) ? 'text-red-500' : 'text-gray-400'"
                                class="p-1 transition-all hover:scale-125">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </button>

                            {{-- Delete button --}}
                            <button wire:click="deleteSkin({{ $skin->id }})"
                                onclick="return confirm('Êtes-vous sûr de vouloir retirer ce skin du concours ?')"
                                class="p-1 text-red-500 transition-all hover:scale-125">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- Skin name --}}
                        <p
                            class="absolute top-0 italic transition-all text-inactiveText group-hover:text-secondary text-md left-2">
                            {{ $skin->name ?? 'ID#' . $skin->id }}&nbsp
                        </p>

                        {{-- Top gradient borders --}}
                        <div x-show="isInTop({{ $skin->id }}, 'top1')"
                            class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 goldGradient">
                        </div>
                        <div x-show="isInTop({{ $skin->id }}, 'top2')"
                            class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 emeraldGradient">
                        </div>
                        <div x-show="isInTop({{ $skin->id }}, 'top3')"
                            class="absolute -top-1 -left-1 w-[calc(100%+0.5rem)] h-[calc(100%+0.5rem)] rounded-lg -z-20 cawotteGradient">
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 col-span-full">
                        <p class="mb-2 text-lg">Aucun skin en concours</p>
                        <p>Les skins avec le statut "MissSkin" apparaîtront ici.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Toast notifications --}}
    <div x-data="{ show: false, message: '' }"
        x-on:theme-updated.window="message = 'Thème mis à jour'; show = true; setTimeout(() => show = false, 3000)"
        x-on:skin-deleted.window="message = 'Skin retiré du concours'; show = true; setTimeout(() => show = false, 3000)"
        x-on:contest-finalized.window="message = 'Concours finalisé !'; show = true; setTimeout(() => show = false, 5000)">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed z-50 px-6 py-3 text-white bg-green-500 rounded-lg shadow-lg top-4 right-4">
            <span x-text="message"></span>
        </div>
    </div>
</div>
