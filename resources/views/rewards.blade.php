@extends('layouts.empty-views')

@section('content')
    <div
        class="max-w-screen pb-16 lg:pb-0 min-[1301px]:min-h-[calc(100vh-2.5rem)] min-h-screen bg-gradient-to-br from-[#0f0e0d] via-[#1a1715] to-[#0f0e0d] flex items-center justify-center p-[min(2rem,1.5vw)]">
        <div
            class="w-full max-w-[1920px] lg:aspect-video bg-gradient-to-br from-[#292522]/20 to-[#292522]/10 backdrop-blur-sm border border-white/5 rounded-2xl lg:rounded-3xl p-[min(2rem,1.5vw)] shadow-2xl">
            <div class="flex flex-col h-full" x-data="rewardsComponent({{ auth()->check() && auth()->user()->can('admin-access') ? 'true' : 'false' }})">

                {{-- TOAST ALERT --}}
                <div x-show="toast.show" x-text="toast.message"
                    x-bind:class="toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'"
                    x-transition:enter="transition transform ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition transform ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    class="fixed z-50 px-4 py-2 text-white rounded shadow-lg bottom-6 right-6" style="display: none;"></div>

                {{-- Header --}}
                <header class="flex-shrink-0 mb-8 lg:mb-[min(1.5rem,1vw)]">
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-3 md:gap-5">
                            <div class="relative">
                                <div
                                    class="w-12 h-12 md:w-16 md:h-16 rounded-xl bg-gradient-to-br from-[#fba436] to-[#faed61] flex items-center justify-center shadow-lg text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                        <path d="M9.375 3a1.875 1.875 0 0 0 0 3.75h1.875v4.5H3.375A1.875 1.875 0 0 1 1.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0 1 12 2.753a3.375 3.375 0 0 1 5.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 1 0-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3ZM11.25 12.75H3v6.75a2.25 2.25 0 0 0 2.25 2.25h6v-9ZM12.75 12.75v9h6.75a2.25 2.25 0 0 0 2.25-2.25v-6.75h-9Z" />
                                    </svg>

                                </div>
                            </div>
                            <div>
                                <h1 class="text-xl text-white md:text-3xl">
                                    Boutique des Récompenses
                                </h1>
                                <p class="text-sm font-light text-white/60 md:text-base">
                                    Concours Miss Skin {{
                                        \Carbon\Carbon::now()->dayOfWeek === \Carbon\Carbon::TUESDAY
                                        ? 'Mardi ' . \Carbon\Carbon::now()->format('d/m')
                                        : 'Mardi ' . \Carbon\Carbon::now()->next(\Carbon\Carbon::TUESDAY)->format('d/m')
                                    }}
                                </p>
                                <div class="flex items-center gap-4 mt-2 text-xs text-white/40 md:text-sm">
                                    <span x-text="rewards.length + ' récompenses disponibles'"></span>
                                </div>
                            </div>
                        </div>


                    </div>
                </header>

                {{-- Grille des récompenses --}}
                <div x-cloak class="flex-1 min-h-0 mt-16 overflow-y-auto">
                    <div class="grid justify-center gap-4" style="grid-template-columns: repeat(auto-fit, 220px);">
                        <template x-for="(reward, index) in rewards" :key="index">
                            <div class="transition-all border bg-white/5 backdrop-blur-sm border-white/10 rounded-xl hover:border-white/20 group" style="width: 220px; height: 270px;">
                                {{-- Image de la récompense --}}
                                <div class="relative w-full h-full overflow-hidden transition-all rounded-lg bg-white/5 group-hover:bg-white/10"
                                    @dragover.prevent @dragenter.prevent="dragOverIndex = index" @dragleave.prevent="handleDragLeave($event, index)" @drop.prevent="handleDrop($event, index)">

                                    {{-- Image si elle existe --}}
                                    <img x-show="reward.image" :src="reward.image" alt="Récompense"
                                        class="object-cover w-full h-full scale-110"
                                        :class="{ 'opacity-50': dragOverIndex === index }">

                                    {{-- SVG de cadeau par défaut --}}
                                    <div x-show="!reward.image" class="flex items-center justify-center w-full h-full text-white/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                                            <path d="M9.375 3a1.875 1.875 0 0 0 0 3.75h1.875v4.5H3.375A1.875 1.875 0 0 1 1.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0 1 12 2.753a3.375 3.375 0 0 1 5.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 1 0-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3ZM11.25 12.75H3v6.75a2.25 2.25 0 0 0 2.25 2.25h6v-9ZM12.75 12.75v9h6.75a2.25 2.25 0 0 0 2.25-2.25v-6.75h-9Z" />
                                        </svg>
                                    </div>

                                    {{-- Zone de drag & drop overlay --}}
                                    <div x-show="isAdmin && dragOverIndex === index"
                                        class="absolute inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                                        <div class="text-center text-white">
                                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <p class="text-sm">Déposer l'image</p>
                                        </div>
                                    </div>

                                    {{-- Upload button admin --}}
                                    <div x-show="isAdmin"
                                        class="absolute transition-opacity opacity-0 top-2 right-2 group-hover:opacity-100">
                                        <button @click="document.getElementById('fileInput' + index).click()"
                                            class="p-2 transition-all rounded-lg bg-black/50 backdrop-blur-sm hover:bg-black/70">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                        </button>
                                        <input :id="'fileInput' + index" type="file" accept="image/*"
                                            style="display: none;" @change="handleFileUpload($event, index)">
                                    </div>

                                    {{-- Delete button admin --}}
                                    <div x-show="isAdmin" class="absolute transition-opacity opacity-0 top-2 left-2 group-hover:opacity-100">
                                        <button @click="deleteReward(index)"
                                            class="p-2 transition-all rounded-lg bg-red-500/50 backdrop-blur-sm hover:bg-red-500/70">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Bouton Ajouter dans la grille --}}
                        <div x-show="isAdmin" class="transition-all border-2 border-dashed bg-white/5 backdrop-blur-sm border-white/20 rounded-xl hover:border-white/40 hover:bg-white/10 group" style="width: 220px; height: 270px;">
                            <button @click="addReward()"
                                class="flex flex-col items-center justify-center w-full h-full">
                                <div class="flex flex-col items-center gap-3 text-white/70 group-hover:text-white/90">
                                    <div class="p-4 rounded-full bg-gradient-to-r from-green-600 to-green-700 group-hover:from-green-700 group-hover:to-green-800">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C13.1 2 14 2.9 14 4V10H20C21.1 10 22 10.9 22 12S21.1 14 20 14H14V20C14 21.1 13.1 22 12 22S10 21.1 10 20V14H4C2.9 14 2 13.1 2 12S2.9 10 4 10H10V4C10 2.9 10.9 2 12 2Z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium">Ajouter une récompense</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    {{-- Message si aucune récompense --}}
                    <div x-show="rewards.length === 0 && !isAdmin" class="py-16 text-center">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-white/5">
                            <svg class="w-8 h-8 text-white/40" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-white">Aucune récompense</h3>
                        <p class="text-white/60">Les récompenses du concours apparaîtront ici.</p>
                    </div>
                </div>

                {{-- Footer --}}
                <footer class="hidden h-10 pt-4 mt-4 border-t border-white/5 md:block">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-white/30 md:text-sm">
                            Concours Miss Skin {{
                                        \Carbon\Carbon::now()->dayOfWeek === \Carbon\Carbon::TUESDAY
                                        ? 'Mardi ' . \Carbon\Carbon::now()->format('d/m')
                                        : 'Mardi ' . \Carbon\Carbon::now()->next(\Carbon\Carbon::TUESDAY)->format('d/m')
                                    }}
                        </div>
                        <div class="flex items-center gap-3 text-xs text-white/30 md:text-sm">
                            <a href="https://www.twitch.tv/barbe___douce" target="_blank"
                                class="flex items-center gap-2 transition-all hover:text-white/50">
                                <span>twitch.tv/barbe___douce</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                                </svg>

                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script>
        function rewardsComponent(isAdmin = false) {
            return {
                rewards: @json($rewards),
                isAdmin,
                dragOverIndex: null,

                init() {
                    window.rewardsComponent = () => this;
                },

                toast: {
                    show: false,
                    message: '',
                    type: 'success',
                },

                showToast(message, type = 'success') {
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;
                    setTimeout(() => this.toast.show = false, 2000);
                },

                // Ajouter une nouvelle récompense
                async addReward() {
                    if (!this.isAdmin) return;

                    try {
                        const response = await fetch("{{ route('rewards.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.rewards = data.rewards;
                            this.showToast('Récompense ajoutée ✅', 'success');
                        } else {
                            this.showToast('Erreur ajout ⚠️', 'error');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        this.showToast('Erreur réseau ❌', 'error');
                    }
                },

                // Supprimer une récompense
                async deleteReward(index) {
                    if (!this.isAdmin) return;

                    try {
                        const response = await fetch("{{ route('rewards.delete') }}", {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                rewardIndex: index
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.rewards = data.rewards;
                            this.showToast('Récompense supprimée ✅', 'success');
                        } else {
                            this.showToast('Erreur suppression ⚠️', 'error');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        this.showToast('Erreur réseau ❌', 'error');
                    }
                },

                // Drag & drop
                handleDrop(event, index) {
                    if (!this.isAdmin) return;

                    this.dragOverIndex = null;
                    const files = event.dataTransfer.files;

                    if (files.length > 0) {
                        const file = files[0];
                        if (file.type.startsWith('image/')) {
                            this.uploadImage(file, index);
                        } else {
                            this.showToast('Veuillez déposer une image ⚠️', 'error');
                        }
                    }
                },

                // Gestion du drag leave
                handleDragLeave(event, index) {
                    if (!this.isAdmin) return;

                    // Ne reset que si on quitte vraiment la zone (pas un enfant)
                    if (!event.currentTarget.contains(event.relatedTarget)) {
                        this.dragOverIndex = null;
                    }
                },

                // Upload fichier
                async handleFileUpload(event, index) {
                    if (!this.isAdmin) return;

                    const file = event.target.files[0];
                    if (file) await this.uploadImage(file, index);
                },

                // Upload image
                async uploadImage(file, index) {
                    if (!this.isAdmin) return;

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('rewardIndex', index);

                    try {
                        const response = await fetch("{{ route('rewards.update-image') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.rewards = data.rewards;
                            this.showToast('Image mise à jour ✅', 'success');
                        } else {
                            this.showToast('Erreur upload ⚠️', 'error');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        this.showToast('Erreur réseau ❌', 'error');
                    }
                },
            }
        }

        // Gestionnaire global de drag & drop - simplifié
        document.addEventListener('DOMContentLoaded', () => {
            // Empêcher le comportement par défaut du drag & drop sur toute la page
            document.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            document.addEventListener('drop', (e) => {
                e.preventDefault();
            });
        });
    </script>
@endsection
