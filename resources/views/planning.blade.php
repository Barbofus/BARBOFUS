@extends('layouts.empty-views')

@section('content')
    <div class="max-w-screen min-[1301px]:min-h-[calc(100vh-2.5rem)] min-h-screen bg-gradient-to-br from-[#0f0e0d] via-[#1a1715] to-[#0f0e0d] flex items-center justify-center p-4 md:p-6 lg:p-8">
        <div class="w-full max-w-[1920px] lg:aspect-video bg-gradient-to-br from-[#292522]/20 to-[#292522]/10 backdrop-blur-sm border border-white/5 rounded-2xl lg:rounded-3xl p-4 md:p-6 lg:p-8 shadow-2xl">
            <div class="h-full flex flex-col"
                 x-data='{
                    planning: @json($planning),
                    totalHours: @json($totalHours),
                    sessions: @json($sessions)
            }'>

                {{-- Header --}}
                <header class="mb-4 md:mb-5 lg:mb-6 flex-shrink-0">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3 md:gap-5">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#fba436] to-[#faed61] rounded-xl lg:rounded-2xl blur-lg md:blur-xl opacity-60 animate-pulse"></div>
                                <div class="relative bg-gradient-to-br from-[#fba436] to-[#faed61] p-3 md:p-4 rounded-xl lg:rounded-2xl shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 md:w-8 lg:w-9 md:h-8 lg:h-9 text-[#292522]" viewBox="0 0 16 16">
                                        <path d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142z"/>
                                        <path d="M11.857 3.143h-1.143V6.57h1.143zm-3.143 0H7.571V6.57h1.143z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-transparent bg-gradient-to-r from-[#fba436] via-[#faed61] to-[#fba436] bg-clip-text leading-tight">
                                    Planning Hebdomadaire
                                </h1>
                                <div class="flex items-center gap-2 md:gap-3 mt-1 md:mt-1.5">
                                    <div class="flex items-center gap-1 md:gap-1.5 text-white/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-3 h-3 md:w-3.5 md:h-3.5" viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                        </svg>

                                        @php
                                            use Carbon\Carbon;

                                            // Début et fin de la semaine actuelle
                                            $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
                                            $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
                                        @endphp

                                        <span class="text-xs md:text-sm">
                                            Semaine du {{ $startOfWeek->locale('fr')->translatedFormat('d') }} au {{ $endOfWeek->locale('fr')->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3 w-full md:w-auto font-light">
                            <a id="twitch-live" href="https://www.twitch.tv/barbe___douce" class="flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-[#fba436]/10 to-[#faed61]/10 backdrop-blur-sm border border-[#fba436]/20 justify-center">
                                <div id="twitch-indicator" class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] animate-pulse shadow-lg shadow-[#fba436]/50"></div>
                                <p id="twitch-status" class="text-white/80 text-sm md:text-base">
                                    En direct
                                </p>
                            </a>
                            <div class="hidden md:flex items-center gap-2 px-3 md:px-5 py-2 md:py-3 rounded-full bg-white/5 backdrop-blur-sm border border-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-3.5 h-3.5 md:w-4 md:h-4 text-[#fba436]" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                                </svg>
                                <span x-cloak class="text-white/70 text-sm md:text-base" x-text="sessions + ' sessions'" />
                            </div>
                            <div class="hidden md:flex px-3 md:px-5 py-2 md:py-3 rounded-full bg-white/5 backdrop-blur-sm border border-white/10">
                                <span x-cloak class="text-white/70 text-sm md:text-base" x-text="totalHours + 'h total'" />
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Grille du planning --}}
                <div x-cloak class="flex-1 min-h-0 overflow-y-auto lg:overflow-visible">
                    <x-planning.DayProgram />
                </div>

                {{-- Footer --}}
                <footer class="mt-4 md:mt-5 pt-3 md:pt-4 border-t border-white/5 flex-shrink-0 hidden md:block">
                    <div class="flex items-center justify-end text-white/30 text-xs md:text-sm gap-3">
                        <a href="https://www.twitch.tv/barbe___douce" class="flex items-center gap-2 hover:text-white/50 transition-all">
                            <span>twitch.tv/barbe___douce</span>
                            <span>
                                <svg stroke="currentColor" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-3" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5"/>
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </footer>
            </div>
        </div>
    </div>


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
                        liveDiv.className = "flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-[#fba436]/10 to-[#faed61]/10 backdrop-blur-sm border border-[#fba436]/20 justify-center transition-all duration-300";
                        indicator.className = "w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] animate-pulse shadow-lg shadow-[#fba436]/50";
                        statusText.textContent = "En direct";
                    } else {
                        // 🚫 STREAM OFFLINE
                        liveDiv.className = "flex items-center gap-2 md:gap-2.5 px-3 md:px-5 py-2 md:py-3 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 justify-center transition-all duration-300";
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
