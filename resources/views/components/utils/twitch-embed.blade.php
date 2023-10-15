<div id="twitch-container" class="relative w-full h-full min-h-[125px]" x-data="{ open: true, }">


    <div id="twitch-screen"  class="absolute bottom-0 left-0 w-full aspect-video group"
         x-show="open"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0">

        @if(isset($canClose) && $canClose)
            <button aria-label="Ferme le live" class="opacity-0 group-hover:opacity-100 absolute top-0 right-0 p-2 h-12 w-12 bg-primary z-40 rounded-bl-xl hover:bg-primary-100 transition-all group"
                @click="open = false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif

        <div class="bg-primary absolute flex justify-between -left-[3px] z-0 h-[calc(100%+6px+20px)] w-[calc(100%+6px)] -top-[23px] rounded-md">

            <div class="flex justify-start gap-x-1">
                <div id="twitchOnlineCircle" class="w-4 h-4 m-0.5 bg-red-500 rounded-full"></div>
                <p class=" font-thin text-secondary text-[0.9rem]">Stream <span id="twitchOnlineText">OFF</span></p>
            </div>

            <a href="https://www.twitch.tv/barbe___douce" title="Page Twitch de Barbe Douce" target="_blank" class="hover:text-goldTextLit hover:-translate-y-1 font-thin text-goldText text-[0.8rem] transition-all">Rejoins-moi sur Twitch !</a>

            <div class="absolute z-10 w-full h-[calc(100%-20px)] rounded-md top-[20px] goldGradient"></div>
        </div>

        <img src="{{ asset('storage/images/misc_ui/Stream_Offlin.avif') }}" alt="Live Offline" class="relative z-20 object-cover h-full rounded-[4px]">

        <!-- Embed -->
        <script src= "https://embed.twitch.tv/embed/v1.js"></script>

        <!-- Stream container -->
        <div id="twitchStreamEmbed" class="absolute top-0 left-0 z-30 w-full h-full opacity-0"></div>


        <!-- Script pour l'embed de Twitch -->
        @vite(['resources/js/twitch/twitch_embed.js'])
    </div>
</div>
