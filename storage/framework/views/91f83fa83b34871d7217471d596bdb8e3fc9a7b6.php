<div id="twitch-container" class="relative w-full h-full min-h-[125px]">
    <a href="https://www.twitch.tv/barbe___douce" target="_blank" class="cursor-pointer group">
        <div id="twitch-screen"  class="absolute bottom-0 left-0 w-full aspect-video">

            <div class="bg-primary absolute flex justify-between -left-[3px] z-0 h-[calc(100%+6px+20px)] w-[calc(100%+6px)] -top-[23px] rounded-md">

                <div class="flex justify-start gap-x-1">
                    <div id="twitchOnlineCircle" class="w-4 h-4 m-0.5 bg-red-500 rounded-full"></div>
                    <p class=" font-thin text-secondary text-[0.9rem]">Stream <span id="twitchOnlineText">OFF</span></p>
                </div>

                <p class="group-hover:text-goldTextLit group-hover:-translate-y-1 font-thin text-goldText text-[0.8rem] transition-all">Rejoins-moi sur Twitch !</p>

                <div class="absolute z-10 w-full h-[calc(100%-20px)] rounded-md top-[20px] goldGradient"></div>
            </div>

            <img src="<?php echo e(asset('storage/images/misc_ui/Stream_Offlin.jpeg')); ?>" class="relative z-20 object-cover h-full rounded-[4px]">

            <!-- Embed -->
            <script src= "https://embed.twitch.tv/embed/v1.js"></script>

            <!-- Stream container -->
            <div id="twitchStreamEmbed" class="absolute top-0 left-0 z-30 w-full h-full opacity-0"></div>


            <!-- Script pour l'embed de Twitch -->
            <?php echo app('Illuminate\Foundation\Vite')(['resources/js/twitch/twitch_embed.js']); ?>
        </div>
    </a>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/utils/twitch-embed.blade.php ENDPATH**/ ?>