@extends('layouts.empty-views')

@section('content')
    <div
        class="max-w-screen pb-16 lg:pb-0 min-[1301px]:min-h-[calc(100vh-2.5rem)] min-h-screen bg-gradient-to-br from-[#0f0e0d] via-[#1a1715] to-[#0f0e0d] flex items-center justify-center p-[min(2rem,1.5vw)]">
        <div
            class="w-full max-w-[1920px] lg:aspect-video bg-gradient-to-br from-[#292522]/20 to-[#292522]/10 backdrop-blur-sm border border-white/5 rounded-2xl lg:rounded-3xl p-[min(2rem,1.5vw)] shadow-2xl">
            <div class="flex flex-col h-full" x-data="planningComponent({{ auth()->check() && auth()->user()->can('admin-access') ? 'true' : 'false' }}, {{ $currentWeek }}, {{ $currentYear }})"> {{-- TOAST ALERT --}}
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
                                    class="absolute inset-0 bg-gradient-to-r from-[#fba436] to-[#faed61] rounded-xl lg:rounded-2xl blur-lg md:blur-xl opacity-60 animate-pulse">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-[#fba436] to-[#faed61] p-4 rounded-xl lg:rounded-2xl shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="w-9 h-9 text-[#292522]" viewBox="0 0 16 16">
                                        <path
                                            d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142z" />
                                        <path d="M11.857 3.143h-1.143V6.57h1.143zm-3.143 0H7.571V6.57h1.143z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1
                                    class="text-transparent bg-gradient-to-r from-[#fba436] via-[#faed61] to-[#fba436] bg-clip-text leading-tight">
                                    Planning Hebdomadaire
                                </h1>
                                <div class="flex items-center gap-2 md:gap-3 mt-1 md:mt-1.5">
                                    <div class="relative flex items-center gap-1 md:gap-1.5 text-white/50 group">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            class="w-3 h-3 md:w-3.5 md:h-3.5" viewBox="0 0 16 16">
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                        </svg>

                                        <span class="text-xs md:text-sm" x-text="displayWeekText"></span>

                                        <!-- Bouton semaine précédente (Admin seulement) -->
                                        @if (auth()->check() && auth()->user()->can('admin-access'))
                                            <button @click="changeWeek('prev')"
                                                class="flex items-center justify-center w-6 h-6 ml-1 transition-opacity duration-200 rounded-full opacity-0 group-hover:opacity-100 bg-white/10 hover:bg-white/20 text-white/70 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 12H6m6 6l-6-6 6-6" />
                                                </svg>
                                            </button>
                                        @endif

                                        <!-- Bouton semaine suivante (Admin seulement) -->
                                        @if (auth()->check() && auth()->user()->can('admin-access'))
                                            <button @click="changeWeek('next')"
                                                class="flex items-center justify-center w-6 h-6 mr-1 transition-opacity duration-200 rounded-full opacity-0 group-hover:opacity-100 bg-white/10 hover:bg-white/20 text-white/70 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 12h12m-6-6l6 6-6 6" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center w-full gap-2 font-light sm:gap-3 sm:w-auto">
                            <a id="twitch-live" href="https://www.twitch.tv/barbe___douce"
                                class="flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-[#fba436]/10 to-[#faed61]/10 backdrop-blur-sm border border-[#fba436]/20 justify-center">
                                <div id="twitch-indicator"
                                    class="w-2 sm:w-2.5 h-2 sm:h-2.5 rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] animate-pulse shadow-lg shadow-[#fba436]/50">
                                </div>
                                <p id="twitch-status" class="text-sm text-white/80 md:text-base">
                                    En direct
                                </p>
                            </a>
                            <div
                                class="items-center hidden gap-2 px-3 py-2 border rounded-full lg:flex lg:px-5 lg:py-3 bg-white/5 backdrop-blur-sm border-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="w-3.5 h-3.5 md:w-4 md:h-4 text-[#fba436]" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                                </svg>
                                <span x-cloak class="text-sm text-white/70 md:text-base" x-text="sessions + ' sessions'" />
                            </div>
                            <div
                                class="hidden px-3 py-2 border rounded-full md:flex md:px-5 md:py-3 bg-white/5 backdrop-blur-sm border-white/10">
                                <span x-cloak class="text-sm text-white/70 md:text-base" x-text="totalHours + 'h total'" />
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Grille du planning --}}
                <div x-cloak class="flex-1 min-h-0 overflow-y-auto lg:overflow-visible">
                    <x-planning.DayProgram />
                </div>

                {{-- Footer --}}
                <footer class="hidden h-10 pt-4 mt-4 border-t border-white/5 md:block">
                    <div class="flex items-center justify-end gap-3 text-xs text-white/30 md:text-sm">
                        <a href="https://www.twitch.tv/barbe___douce"
                            class="flex items-center gap-2 transition-all hover:text-white/50">
                            <span>twitch.tv/barbe___douce</span>
                            <span>
                                <svg stroke="currentColor" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="h-3" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                    <path fill-rule="evenodd"
                                        d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script>
        function planningComponent(isAdmin = false, initialWeek = null, initialYear = null) {
            return {
                planning: @json($planning),
                totalHours: @json($totalHours),
                sessions: @json($sessions),
                selectedFile: null,
                isAdmin,
                currentWeek: initialWeek || (() => {
                    // Calculer le numéro de semaine ISO (équivalent à Carbon::week)
                    const now = new Date();
                    const startOfYear = new Date(now.getFullYear(), 0, 1);
                    const days = Math.floor((now - startOfYear) / (24 * 60 * 60 * 1000));
                    return Math.ceil((days + startOfYear.getDay() + 1) / 7);
                })(),
                currentYear: initialYear || new Date().getFullYear(),

                init() {
                    // Exposer le composant globalement pour les sous-composants
                    window.planningComponent = () => this;
                },

                get displayWeekText() {
                    // Calculer les dates de début et fin de semaine en JavaScript
                    const year = this.currentYear;
                    const week = this.currentWeek;

                    // Calculer le premier lundi de l'année
                    const jan1 = new Date(year, 0, 1);
                    const dayOfWeek = jan1.getDay(); // 0 = dimanche, 1 = lundi, etc.
                    const daysToFirstMonday = dayOfWeek === 0 ? 1 : 8 - dayOfWeek;

                    // Premier lundi de l'année
                    const firstMonday = new Date(year, 0, 1 + daysToFirstMonday);

                    // Calculer le lundi de la semaine cible
                    const targetMonday = new Date(firstMonday);
                    targetMonday.setDate(firstMonday.getDate() + (week - 1) * 7);

                    // Calculer le dimanche correspondant
                    const targetSunday = new Date(targetMonday);
                    targetSunday.setDate(targetMonday.getDate() + 6);

                    // Formatage en français
                    const optionsDay = {
                        day: 'numeric'
                    };
                    const optionsFullDate = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };

                    const startDay = targetMonday.toLocaleDateString('fr-FR', optionsDay);
                    const endDate = targetSunday.toLocaleDateString('fr-FR', optionsFullDate);

                    return `Semaine du ${startDay} au ${endDate}`;
                },

                async changeWeek(direction) {
                    if (!this.isAdmin) return;

                    try {
                        const response = await fetch("{{ route('planning.change-week') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                direction
                            })
                        });

                        if (!response.ok) throw new Error('Erreur réseau');

                        const data = await response.json();

                        if (data.success) {
                            // Mettre à jour les données localement sans rechargement
                            this.currentWeek = data.week;
                            this.currentYear = data.year;
                            this.showToast(`Semaine ${direction === 'next' ? 'suivante' : 'précédente'} ✅`, 'success');
                        } else {
                            this.showToast('Erreur changement de semaine ⚠️', 'error');
                        }

                    } catch (error) {
                        console.error('Erreur lors du changement de semaine:', error);
                        this.showToast('Erreur réseau ❌', 'error');
                    }
                },
                toast: {
                    show: false,
                    message: '',
                    type: 'success', // 'success' | 'error'
                },

                showToast(message, type = 'success') {
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;
                    setTimeout(() => this.toast.show = false, 2000);
                },

                handleFileUpload(event) {
                    this.selectedFile = event.target.files[0];
                },

                normalizePlanning(planning) {
                    if (!Array.isArray(planning)) return [];

                    return planning.map(day => ({
                        name: day.name ?? 'Jour inconnu',
                        activities: Array.isArray(day.activities) ?
                            day.activities.map(activity => ({
                                name: activity.name ?? activity.Name ?? 'Activité',
                                startTime: activity.startTime ?? activity.StartTime ?? '00:00',
                                endTime: activity.endTime ?? activity.EndTime ?? '00:00',
                                image: activity.image ?? activity.Image ?? '',
                                visible: activity.visible ?? true, // Par défaut visible
                            })) : []
                    }));
                },

                // Valide le format HH:MM
                validateTime(value) {
                    // Supprimer les espaces et caractères non numériques
                    value = value.trim().replace(/[^\d:]/g, '');

                    // Si vide → retour par défaut
                    if (value === '') return '00:00';

                    // Cas 1 : format déjà correct (HH:mm)
                    const fullMatch = /^([01]?\d|2[0-3]):([0-5]\d)$/.exec(value);
                    if (fullMatch) {
                        const [, hours, minutes] = fullMatch;
                        return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
                    }

                    // Cas 2 : seulement heures (ex: "7" ou "07" ou "23")
                    const hourOnly = /^([0-9]|1\d|2[0-3])$/.exec(value);
                    if (hourOnly) {
                        const hours = hourOnly[1].padStart(2, '0');
                        return `${hours}:00`;
                    }

                    // Cas 3 : heures + minutes collés (ex: "730" → "07:30")
                    const compact = /^(\d{3,4})$/.exec(value);
                    if (compact) {
                        const raw = compact[1].padStart(4, '0');
                        const hours = raw.slice(0, 2);
                        const minutes = raw.slice(2);
                        if (parseInt(hours) <= 23 && parseInt(minutes) <= 59) {
                            return `${hours}:${minutes}`;
                        }
                    }

                    // Sinon valeur invalide
                    return '00:00';
                },


                // Envoie le planning au back
                async savePlanning() {

                    // Vérifier que l'utilisateur est admin
                    if (!this.isAdmin) {
                        this.showToast('Accès non autorisé ❌', 'error');
                        return;
                    }

                    try {
                        const response = await fetch("{{ route('planning.update-all') }}", {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                planning: this.planning
                            })
                        });

                        if (!response.ok) throw new Error('Erreur réseau');

                        const data = await response.json();

                        if (data.success) {
                            this.totalHours = data.totalHours;
                            this.sessions = data.sessions;
                            this.showToast('Planning mis à jour avec succès ✅', 'success');
                        } else {
                            this.showToast('Échec de la mise à jour ⚠️', 'error');
                        }

                    } catch (error) {
                        console.error('Erreur lors de la mise à jour du planning:', error);
                        this.showToast('Erreur réseau lors de la mise à jour ❌', 'error');
                    }
                },
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const channel = 'barbe___douce';
            const liveDiv = document.getElementById('twitch-live');
            const indicator = document.getElementById('twitch-indicator');
            const statusText = document.getElementById('twitch-status');

            async function checkTwitchLive() {
                try {
                    const res = await fetch(`https://decapi.me/twitch/uptime?channel=${channel}`);
                    const text = await res.text();

                    const isLive = !text.toLowerCase().includes('offline');

                    if (isLive) {
                        // 💡 STREAM EN DIRECT
                        liveDiv.className =
                            "flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-[#fba436]/10 to-[#faed61]/10 backdrop-blur-sm border border-[#fba436]/20 justify-center transition-all duration-300";
                        indicator.className =
                            "w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] animate-pulse shadow-lg shadow-[#fba436]/50";
                        statusText.textContent = "En direct";
                    } else {
                        // 🚫 STREAM OFFLINE
                        liveDiv.className =
                            "flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 justify-center transition-all duration-300";
                        indicator.className = "w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-gray-400";
                        statusText.textContent = "Hors ligne";
                    }

                } catch (error) {
                    console.error("Erreur lors de la vérification Twitch :", error);
                }
            }

            // Vérifie toutes les 30 secondes
            checkTwitchLive();
            setInterval(checkTwitchLive, 30000);
        });
    </script>
@endsection
