<!-- En-tête -->
<div id="header"
     class="w-full h-0 bg-secondary relative z-20 invisible [@media(min-height:950px)_and_(min-width:901px)]
          [@media(min-height:950px)_and_(min-width:901px)]:visible [@media(min-height:950px)_and_(min-width:901px)]:h-[15vh] [@media(min-height:950px)_and_(min-width:901px)]:min-h-[150px]">
    <div class="flex h-full justify-center z-10 relative">
        <div class="max-w-1/2 h-full flex justify-center ">
            <a href="{{ route('home') }}" target="_blank"><img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.png') }}" class="h-full" draggable="false" /></a>

            <div class="h-full -z-10 flex justify-center aspect-[665/194] absolute overflow-hidden">
                <div class="absolute h-full w-full -left-4 -top-16 animate-slideY [--custom-translate-y:20px] [--custom-animation-time:10s]" style="animation-delay: -2500ms">
                    <img src="{{ asset('storage/images/misc_ui/Barbofus_Logo_Background.jpg') }}" class="absolute top-0 left-0 animate-slideX [--custom-translate-x:20px] [--custom-animation-time:10s]">
                </div>
                <img src="{{ asset('storage/images/misc_ui/Barbofus_Logo_Mask.png') }}" class="absolute left-0 h-full">
            </div>
        </div>
    </div>
</div>
