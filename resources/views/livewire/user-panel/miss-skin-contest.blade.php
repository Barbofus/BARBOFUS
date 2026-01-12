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

            @if ($contestFinalized)
                {{-- Contest finalized - Show restart button --}}
                <div class="flex items-center justify-center gap-6">
                    <div class="p-6 border border-[var(--emeraldLit)] rounded-lg">
                        <h2 class="mb-4 text-xl text-center font-light text-[var(--emeraldLit)]">🏆 Concours terminé !</h2>
                        <p class="mb-4 text-center text-[var(--emeraldLit)]">Les vainqueurs ont été sélectionné.</p>
                    </div>
                </div>
            @else
                {{-- Contest in progress - Theme management --}}
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
                            <div class="p-4 bg-primary-100 border border-[var(--emeraldLit)] rounded-lg">
                                <p class="mb-3 text-inactiveText">⚠️ Voulez-vous finaliser le concours ?</p>
                                <button @click="syncTopsWithLivewire(); $wire.finalizeContest()"
                                    class="px-6 py-2 transition-colors rounded-md text-primary emeraldGradient hover:brightness-110">
                                    Finaliser le concours
                                </button>
                            </div>
                        @else
                            <button @click="syncTopsWithLivewire(); $wire.showConfirmFinalize = true"
                                class="px-6 py-2 transition-colors rounded-md text-primary emeraldGradient hover:brightness-110">
                                Finaliser le concours
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if ($contestFinalized)
            {{-- Winners Display --}}
            <div class="mb-8">
                <h2 class="mb-6 text-2xl font-light text-center text-secondary">🏆 Vainqueurs du Concours</h2>

                <div class="flex justify-center gap-8">
                    @foreach ($finalizedWinners as $winner)
                        <div class="text-center">
                            {{-- Rank badge --}}
                            <div class="mb-4">
                                @if ($winner['position'] === 'top1')
                                    <div class="inline-flex items-center justify-center w-16 h-16 mx-auto rounded-full goldGradient">
                                        <span class="text-2xl font-bold text-primary">1</span>
                                    </div>
                                @elseif ($winner['position'] === 'top2')
                                    <div class="inline-flex items-center justify-center w-16 h-16 mx-auto rounded-full emeraldGradient">
                                        <span class="text-2xl font-bold text-primary">2</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center justify-center w-16 h-16 mx-auto rounded-full cawotteGradient">
                                        <span class="text-2xl font-bold text-primary">3</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Skin image --}}
                            <div class="aspect-[14/19] w-48 relative mb-4 mx-auto">
                                <div class="absolute w-full h-full overflow-hidden transition-all rounded-md bg-primary-100">
                                    @php
                                        $skin = $winner['skin'];
                                        $raceName = is_array($skin) ? ($skin['race_name'] ?? '') : ($skin->race_name ?? '');
                                        $imagePath = is_array($skin) ? ($skin['image_path'] ?? '') : ($skin->image_path ?? '');
                                        $skinName = is_array($skin) ? ($skin['name'] ?? '') : ($skin->name ?? '');
                                        $userName = is_array($skin) ? ($skin['user']['name'] ?? '') : ($skin->user->name ?? '');
                                    @endphp
                                    <div class="absolute top-0 left-0 w-full h-full bg-center bg-cover opacity-25 bg-dofus-classes"
                                         style="background-image: url('{{ asset('storage/images/misc_ui/bg_' . strtolower($raceName) . '.png') }}');">
                                    </div>
                                </div>
                                <div class="absolute top-[1.5rem] w-full h-[calc(100%-3rem)]">
                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                         alt="Skin {{ $skinName }}"
                                         class="object-contain w-full h-full drop-shadow-lg">
                                </div>
                            </div>

                            {{-- Winner info --}}
                            <h3 class="mb-2 text-lg font-medium text-secondary">{{ $skinName }}</h3>
                            <p class="mb-4 text-sm text-goldText">{{ $userName }}</p>

                            {{-- Reward (only for top1) --}}
                            @if ($winner['position'] === 'top1')
                                @php
                                    // Récupérer la récompense actuelle du vainqueur depuis la DB (en temps réel)
                                    $skinId = is_array($skin) ? $skin['id'] : $skin->id;
                                    $userId = is_array($skin) ? $skin['user_id'] : $skin->user_id;
                                    $currentWinner = \App\Models\User::find($userId);
                                    $currentReward = $currentWinner ? $currentWinner->getSelectedRewardData() : null;
                                @endphp
                                <div class="p-6 border-2 border-yellow-400 rounded-lg bg-primary-100">
                                    <h4 class="mb-4 text-lg font-medium text-secondary">🎁 Récompense</h4>
                                    @if ($currentReward)
                                        <div class="flex items-center justify-center">
                                            <div class="relative overflow-hidden rounded-lg shadow-lg" style="width: 220px; height: 270px;">
                                                <img src="{{ $currentReward['image'] }}"
                                                     alt="Récompense sélectionnée"
                                                     class="object-cover w-full h-full scale-110">
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center mx-auto rounded-lg bg-white/5" style="width: 220px; height: 270px;">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto mb-4 text-white/30" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9.375 3a1.875 1.875 0 0 0 0 3.75h1.875v4.5H3.375A1.875 1.875 0 0 1 1.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0 1 12 2.753a3.375 3.375 0 0 1 5.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 1 0-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3ZM11.25 12.75H3v6.75a2.25 2.25 0 0 0 2.25 2.25h6v-9ZM12.75 12.75v9h6.75a2.25 2.25 0 0 0 2.25-2.25v-6.75h-9Z" />
                                                </svg>
                                                <p class="text-sm italic text-inactiveText">Aucune récompense sélectionnée</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Contest in progress content --}}
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
                <div x-show="favorites.length === 0" class="py-8 text-center text-inactiveText">
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
                    <div class="py-12 text-center text-inactiveText col-span-full">
                        <p class="mb-2 text-lg">Aucun skin en concours</p>
                        <p>Les skins avec le statut "MissSkin" apparaîtront ici.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>

    {{-- Toast notifications --}}
    <div x-data="{ show: false, message: '' }"
        x-on:theme-updated.window="message = 'Thème mis à jour'; show = true; setTimeout(() => show = false, 3000)"
        x-on:skin-deleted.window="message = 'Skin retiré du concours'; show = true; setTimeout(() => show = false, 3000)"
        x-on:contest-finalized.window="
            message = 'Concours finalisé !';
            show = true;
            setTimeout(() => show = false, 5000);
            localStorage.removeItem('missSkinFavorites');
        "
        x-on:new-contest-started.window="
            message = 'Nouveau concours commencé !';
            show = true;
            setTimeout(() => show = false, 3000);
            localStorage.removeItem('missSkinFavorites');
        ">
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
