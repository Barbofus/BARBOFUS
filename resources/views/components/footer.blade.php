<!-- Footer -->
<footer id="footer" class="fixed bottom-0 z-50 w-full h-2 transition-all duration-200 group hover:bottom-12">
    <div class="relative w-full h-16 p-2 bg-secondary">

        <!-- Hovered extension -->
        <div class="flex justify-between absolute w-36 h-4 -top-4 left-[calc(50%-4.5rem)]">
            <div class="w-8 h-full rotate-180 bg-secondary clip-path-triangle-down"></div>
            <div class="w-8 h-full rotate-180 bg-secondary clip-path-triangle-down"></div>
            <div class="absolute h-full rotate-180 bg-secondary w-28 left-4">
                <div class="transition-transform duration-200 group-hover:rotate-180 absolute top-0 left-[calc(50%-0.5rem)] w-4 h-3 bg-primary clip-path-triangle-down"></div>
            </div>
        </div>

        <!-- Footer content -->
        <div class="flex items-center justify-center h-10 gap-x-4">

            <!-- Réseaux sociaux -->
            <div class="relative w-48 h-full">
                <a href="https://www.tiktok.com/@barbe___douce" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_TikTok.png') }}" class="absolute left-0 h-8 transition-all duration-100 top-1 hover:top-0 hover:-left-1 hover:h-10"></a>
                <a href="https://www.instagram.com/barbe.douce.twitch/" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Instagram.webp') }}" class="absolute left-[25%] h-8 transition-all duration-100 top-1 hover:top-0 hover:left-[calc(25%-4px)] hover:h-10"></a>
                <a href="https://twitter.com/DouceBarbe" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Twitter.png') }}" class="absolute left-[50%] h-8 transition-all duration-100 top-1 hover:top-0 hover:left-[calc(50%-4px)] hover:h-10"></a>
                <a href="https://www.youtube.com/channel/UCJIBwLWxtdrVCwuX-F3W9bA?view_as=subscriber" target="_blank"><img src="{{ asset('storage/images/misc_ui/Logo_Youtube.png') }}" class="absolute right-0 h-8 transition-all duration-100 top-1 hover:top-0 hover:-right-1 hover:h-10"></a>
            </div>
        </div>
    </div>
</footer>
