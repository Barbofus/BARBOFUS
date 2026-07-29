@php
    $isAdmin = auth()->check() && auth()->user()->can('admin-access');
@endphp

{{-- Masquer complètement la carte si non-admin ET invisible --}}
<div x-show="{{ $isAdmin ? 'true' : 'activity.visible !== false' }}"
    class="bg-[#292522]/50 backdrop-blur-md border-white/5 border-2 overflow-hidden transition-all group relative rounded-[min(1rem,0.75vw)] h-full"
    :class="{
        'scale-[1.05] border-[#fba436]/60 shadow-2xl shadow-[#fba436]/20 animate-pulse-glow': isCurrentActivity(),
        'hover:scale-[1.02] hover:border-[#fba436]/40 hover:shadow-2xl hover:shadow-[#fba436]/20': !isCurrentActivity(),
        'opacity-0 grayscale hover:opacity-50': activity.visible === false
    }"
    x-data="activityImageUpload(activity, dayIndex, activityIndex, {{ $isAdmin ? 'true' : 'false' }})"
    @if ($isAdmin) x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="handleDrop($event)" @endif>
    <div class="relative flex flex-col h-full overflow-hidden">

        {{-- Badge LIVE pour activité en cours --}}
        <div x-show="isCurrentActivity()"
            class="absolute z-20 top-2 left-2 flex items-center gap-1.5 px-2 py-1 bg-gradient-to-r from-red-500 to-red-600 rounded-full text-white text-xs font-bold uppercase tracking-wide shadow-lg animate-pulse"
            x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
            LIVE
        </div>

        {{-- Bouton de visibilité - Seulement pour les admins --}}
        @if ($isAdmin)
            <button x-on:click="toggleVisibility()"
                class="absolute z-10 flex items-center justify-center transition-all duration-200 top-2 right-2 hover:scale-110 group/btn"
                :class="activity.visible === false ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'">
                <!-- Icône œil ouvert (visible) -->
                <svg x-show="activity.visible !== false" xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 transition-transform text-white/75 group-hover/btn:scale-110" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <!-- Icône œil fermé (masqué) -->
                <svg x-show="activity.visible === false" xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-white transition-transform group-hover/btn:scale-110" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
            </button>
        @endif

        {{-- Image Section --}}
        <div class="relative flex-1 min-h-0 overflow-hidden @if ($isAdmin) cursor-pointer @endif"
            @if ($isAdmin) x-on:click="$refs.fileInput.click()" @endif>
            <img :src="activity.Image" class="object-cover w-full h-full transition-transform duration-700 ease-out"
                :class="{
                    'scale-110': isCurrentActivity(),
                    'group-hover:scale-110': !isCurrentActivity()
                }"
                style="max-height: 100%; object-fit: cover;">

            <div class="absolute inset-0 bg-gradient-to-t from-[#292522] via-[#292522]/50 to-transparent transition-opacity duration-500"
                :class="{
                    'opacity-50': isCurrentActivity(),
                    'opacity-100 group-hover:opacity-50': !isCurrentActivity()
                }">
            </div>

            @if ($isAdmin)
                <!-- Overlay Drag & Drop -->
                <div x-show="isDragging"
                    class="absolute inset-0 flex items-center justify-center text-lg font-light transition-opacity pointer-events-none bg-black/40 text-white/75"
                    x-transition.opacity>
                    Déposez l'image ici
                </div>

                <!-- Overlay Loading Upload -->
                <div x-show="isUploadingImage"
                    class="absolute inset-0 flex flex-col items-center justify-center text-white transition-opacity pointer-events-none bg-black/60"
                    x-transition.opacity>

                    <!-- Spinner animé -->
                    <div class="w-12 h-12 border-4 rounded-full border-white/20 border-t-white animate-spin"></div>

                    <!-- Texte qui pulse -->
                    <div class="mt-3 text-sm font-medium tracking-wide animate-pulse">
                        Upload en cours...
                    </div>
                </div>
            @endif
        </div>

        {{-- Shimmer effect on hover --}}
        <div class="absolute inset-0 transition-all duration-500 pointer-events-none bg-gradient-to-br from-transparent to-transparent"
            :class="{
                'via-white/20': isCurrentActivity(),
                'via-white/0 group-hover:via-white/20': !isCurrentActivity()
            }">
        </div>

        {{-- Hidden file input - Seulement pour les admins --}}
        @if ($isAdmin)
            <input type="file" x-ref="fileInput" class="hidden" x-on:change="handleFileUpload($event)">
        @endif

        {{-- Content Section --}}
        <div
            class="absolute bottom-0 left-0 right-0 p-1 min-[400px]:p-3 lg:p-[min(0.75rem,0.35vw)] bg-gradient-to-t from-[#292522] to-transparent">
            <div class="space-y-1.5">
                <div class="flex items-center lg:gap-[min(0.5rem,0.25vw)]">
                    <div
                        class="w-1.5 h-1.5 min-[400px]:w-2 min-[400px]:h-2 mr-1 min-[400px]:mr-2 lg:mr-0 lg:w-[min(0.5rem,0.5vw)] lg:h-[min(0.5rem,0.5vw)] rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] shadow-lg shadow-[#fba436]/50">
                    </div>

                    <!-- StartTime input -->
                    @if ($isAdmin)
                        <input type="text"
                            class="bg-transparent text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider outline-none w-12 min-[400px]:w-14 lg:w-[min(3.5rem,4vw)]
                                  focus:from-white/10 focus:to-white/20 focus:text-white focus:bg-clip-border focus:rounded px-1 transition-all text-sm min-[400px]:text-base lg:text-[min(1rem,1.25vw)]"
                            x-model="activity.StartTime" x-on:focus="activity.StartTime = ''"
                            x-on:blur="activity.StartTime = window.planningComponent().validateTime(activity.StartTime); window.planningComponent().savePlanning()"
                            x-on:keydown.enter="$event.target.blur()" />
                    @else
                        <span
                            class="bg-transparent text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider text-sm min-[400px]:text-base lg:text-[min(1rem,1.25vw)] w-12 min-[400px]:w-14 lg:w-[min(3.5rem,4vw)]"
                            x-text="activity.StartTime"></span>
                    @endif

                    <span
                        class="bg-transparent text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider outline-none">-</span>

                    <!-- EndTime input -->
                    @if ($isAdmin)
                        <input type="text"
                            class="bg-transparent text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider outline-none w-12 min-[400px]:w-14 lg:w-[min(3.5rem,4vw)]
                                  focus:from-white/10 focus:to-white/20 focus:text-white focus:bg-clip-border focus:rounded px-1 transition-all text-sm min-[400px]:text-base lg:text-[min(1rem,1.25vw)]"
                            x-model="activity.EndTime" x-on:focus="activity.EndTime = ''"
                            x-on:blur="activity.EndTime = window.planningComponent().validateTime(activity.EndTime); window.planningComponent().savePlanning()"
                            x-on:keydown.enter="$event.target.blur()" />
                    @else
                        <span
                            class="bg-transparent text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider text-sm min-[400px]:text-base lg:text-[min(1rem,1.25vw)] w-12 min-[400px]:w-14 lg:w-[min(3.5rem,4vw)]"
                            x-text="activity.EndTime"></span>
                    @endif

                </div>

                <!-- Name input -->
                @if ($isAdmin)
                    <input type="text"
                        class="w-full px-1 leading-tight text-white transition-all bg-transparent outline-none text-sm min-[400px]:text-base lg:text-[min(1rem,1.2vw)] focus:bg-white/10 focus:rounded"
                        x-model="activity.Name" x-on:blur="window.planningComponent().savePlanning()"
                        x-on:keydown.enter="$event.target.blur()" />
                @else
                    <span
                        class="w-full px-1 leading-tight text-sm min-[400px]:text-base lg:text-[min(1rem,1.2vw)] text-white"
                        x-text="activity.Name"></span>
                @endif
            </div>
        </div>
    </div>

    <script>
        function activityImageUpload(activity, dayIndex, activityIndex, isAdmin = false) {
            return {
                activity,
                dayIndex,
                activityIndex,
                isAdmin,
                isDragging: false,
                isEditing: false,
                saveTimeout: null,
                currentTime: new Date(),
                isUploadingImage: false,

                init() {
                    // Mettre à jour l'heure toutes les minutes
                    setInterval(() => {
                        this.currentTime = new Date();
                    }, 60000);
                },

                // Détermine si cette activité est actuellement en cours
                isCurrentActivity() {
                    if (!window.planningComponent) return false;

                    const planningComp = window.planningComponent();
                    const planning = planningComp.planning;
                    const currentWeek = planningComp.currentWeek;
                    const currentYear = planningComp.currentYear;
                    const day = planning[this.dayIndex];

                    if (!day || !day.name) return false;

                    // Vérifier si on regarde la semaine actuelle - utiliser la même logique que le composant principal
                    const now = new Date();
                    const thisYear = now.getFullYear();

                    // Calculer la semaine ISO comme dans le composant principal
                    const jan1 = new Date(thisYear, 0, 1);
                    const dayOfWeek = jan1.getDay();
                    const daysToFirstMonday = dayOfWeek === 0 ? 1 : 8 - dayOfWeek;
                    const firstMonday = new Date(thisYear, 0, 1 + daysToFirstMonday);
                    const daysDiff = Math.floor((now - firstMonday) / (24 * 60 * 60 * 1000));
                    const thisWeek = Math.floor(daysDiff / 7) + 1;

                    // Si on regarde une autre semaine, pas d'highlight
                    if (currentWeek !== thisWeek || currentYear !== thisYear) return false;

                    // Correspondance jour de la semaine
                    const dayMapping = {
                        'LUN': 1,
                        'MAR': 2,
                        'MER': 3,
                        'JEU': 4,
                        'VEN': 5,
                        'SAM': 6,
                        'DIM': 0
                    };

                    const currentDay = this.currentTime.getDay(); // 0 = dimanche, 1 = lundi, etc.
                    const activityDay = dayMapping[day.name.toUpperCase()];

                    // Vérifier si c'est le bon jour
                    if (currentDay !== activityDay) return false;

                    // Vérifier l'heure
                    const currentHour = this.currentTime.getHours();
                    const currentMinute = this.currentTime.getMinutes();
                    const currentTimeInMinutes = currentHour * 60 + currentMinute;

                    // Parser l'heure de début et fin (format HH:mm)
                    const startTimeParts = (this.activity.StartTime || '00:00').split(':');
                    const endTimeParts = (this.activity.EndTime || '00:00').split(':');

                    const startTimeInMinutes = parseInt(startTimeParts[0]) * 60 + parseInt(startTimeParts[1]);
                    const endTimeInMinutes = parseInt(endTimeParts[0]) * 60 + parseInt(endTimeParts[1]);

                    // Vérifier si l'heure actuelle est dans la plage
                    return currentTimeInMinutes >= startTimeInMinutes && currentTimeInMinutes <= endTimeInMinutes;
                }, // Bascule la visibilité de l'activité - Seulement pour les admins
                toggleVisibility() {
                    if (!this.isAdmin) return;

                    this.activity.visible = this.activity.visible === false ? true : false;
                    // Appeler la fonction de sauvegarde du composant parent
                    if (window.planningComponent) {
                        window.planningComponent().savePlanning();
                    }
                },

                handleFileUpload(event) {
                    if (!this.isAdmin) return;

                    const file = event.target.files[0];
                    if (file) this.uploadFile(file);
                },

                handleDrop(event) {
                    if (!this.isAdmin) return;

                    const file = event.dataTransfer.files[0];
                    if (file) this.uploadFile(file);
                    this.isDragging = false;
                },

                async uploadFile(file) {
                    if (!this.isAdmin) return;

                    // Activer le loader
                    this.isUploadingImage = true;

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('dayIndex', this.dayIndex);
                    formData.append('activityIndex', this.activityIndex);

                    try {
                        const response = await fetch("{{ route('planning.update-image') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        if (!response.ok) throw new Error('Erreur réseau');

                        const data = await response.json();

                        if (data.success) {
                            // Mettre à jour l'image dans l'objet planning
                            this.activity.Image = data.imageUrl;
                            if (window.planningComponent) window.planningComponent().showToast('Image uploadée ✅',
                                'success');
                        } else {
                            if (window.planningComponent) window.planningComponent().showToast('Échec upload image ⚠️',
                                'error');
                        }

                    } catch (error) {
                        console.error('Erreur upload image:', error);
                        if (window.planningComponent) window.planningComponent().showToast('Erreur réseau ❌', 'error');
                    } finally {
                        // Désactiver le loader dans tous les cas
                        this.isUploadingImage = false;
                    }
                }
            }
        }
    </script>

    {{-- Styles CSS personnalisés pour l'animation glow --}}
    <style>
        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow:
                    0 0 20px rgba(251, 164, 54, 0.4),
                    0 0 40px rgba(251, 164, 54, 0.2),
                    0 0 60px rgba(251, 164, 54, 0.1);
            }

            50% {
                box-shadow:
                    0 0 30px rgba(251, 164, 54, 0.6),
                    0 0 60px rgba(251, 164, 54, 0.3),
                    0 0 90px rgba(251, 164, 54, 0.15);
            }
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
</div>
