{{-- MissSkin Contest Popup Component --}}
<div x-data="{
    showPopup: false,
    init() {
        // Vérifier si c'est mardi et dans les heures du concours (6h-11h30)
        const now = new Date();
        const utcHour = now.getUTCHours();
        const utcDay = now.getUTCDay();

        // Convertir en heure française (UTC+1 ou UTC+2 selon la saison)
        // Pour simplifier, on assume UTC+1 (hiver)
        const frenchHour = (utcHour + 1) % 24;
        const isTuesday = utcDay === 2; // 2 = Mardi
        const isMissSkinTime = isTuesday && frenchHour >= 6 && (frenchHour < 11 || (frenchHour === 11 && now.getUTCMinutes() <= 30));

        if (isMissSkinTime) {
            // Créer un identifiant unique pour cette semaine
            const year = now.getFullYear();
            const weekNumber = Math.ceil((now - new Date(year, 0, 1)) / (7 * 24 * 60 * 60 * 1000));
            const weekId = `${year}-${weekNumber}`;

            // Vérifier si le popup a déjà été montré cette semaine
            const lastShown = localStorage.getItem('misskin_popup_week');
            if (lastShown !== weekId) {
                this.showPopup = true;
            }
        }
    },
    closePopup() {
        // Enregistrer qu'on a montré le popup cette semaine
        const now = new Date();
        const year = now.getFullYear();
        const weekNumber = Math.ceil((now - new Date(year, 0, 1)) / (7 * 24 * 60 * 60 * 1000));
        const weekId = `${year}-${weekNumber}`;
        localStorage.setItem('misskin_popup_week', weekId);
        this.showPopup = false;
    },
    get misskinTheme() {
        return {{ Js::from(json_decode(\Storage::disk('local')->get('json/missskin.json'), true)['theme'] ?? 'A définir') }};
    }
}" x-show="showPopup" x-cloak>
    {{-- Overlay --}}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 font-light bg-black bg-opacity-50 text-secondary" x-on:click="closePopup()">
        {{-- Popup Container --}}
        <div class="w-full max-w-md mx-auto rounded-lg shadow-xl bg-primary" @click.stop>
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-normal">
                    {{ __('barbofus.popupMissSkinTitle') }}<span x-text="misskinTheme"></span>
                </h3>
                <button x-on:click="closePopup()" class="text-red-400 transition-colors hover:text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <div class="mb-6 leading-relaxed text-gray-7000">
                    {!! __('barbofus.popupMissSkinContent') !!}
                </div>

                {{-- Twitch Link --}}
                <div class="p-3 mb-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z"/>
                        </svg>
                        <a href="https://www.twitch.tv/barbe___douce" target="_blank" class="font-medium text-purple-600 hover:underline">
                            twitch.tv/barbe___douce
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
