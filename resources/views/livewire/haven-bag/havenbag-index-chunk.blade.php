<div class="grid grid-cols-1 min-[900px]:grid-cols-2 pt-[2rem] px-4 gap-x-8 gap-y-16 w-[min(95%,130rem)] mx-auto justify-center">
    @foreach($orderedHavenBags as $key => $havenBag)
        <button wire:key="haven-bag.{{ $havenBag->id }}"
                class="relative w-full h-full overflow-hidden transition-all duration-1000 shadow-sm opacity-0 group animate-skinApparition bg-primary-100 rounded-xl hover:brightness-110"
                style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms"
                x-on:click="
                    showHavenBag = true,
                    havenBagImagePath = '{{ asset('storage/'. $havenBag->image_path) }}',
                    popocketIconPath = '{{ asset('https://static.barbofus.com/'. $havenBag->popocket_icon_path) }}',
                    username = '{{ $havenBag->user_name }}',
                    havenBagName = '{{ addslashes($havenBag->name) }}',
                    havenBagThemeName = '{{ $havenBag->haven_bag_theme_name }}',
                    AddToUrl('show', {{ $havenBag->id }}),
                    $dispatch('haven-bag-change')"
        >
            <div class="relative flex items-center p-2 justify-left">
                <img src="{{ asset('https://static.barbofus.com/'. $havenBag->popocket_icon_path) }}" class="h-[clamp(3rem,8vw,6rem)] min-[900px]:h-[clamp(3rem,5vw,6rem)] aspect-square invisible min-[400px]:visible" alt="Popoche du havre sac" draggable="false">

                <div class="text-[calc(clamp(3rem,8vw,6rem)/100*22)] min-[900px]:text-[calc(clamp(3rem,5vw,6rem)/100*22)] text-center w-full">
                    <div class="absolute top-0 h-full px-1 pb-[2px] left-0 w-full flex flex-col justify-between
                        min-[400px]:left-[calc(0.5rem+clamp(3rem,8vw,6rem))] min-[400px]:w-[calc(100%-clamp(6rem,16vw,12rem))]
                        min-[900px]:left-[calc(0.5rem+clamp(3rem,5vw,6rem))] min-[900px]:w-[calc(100%-clamp(6rem,10vw,12rem))]">
                        <div class="w-full h-full">
                            @if($havenBag->name)
                                <div class="flex w-full h-fit items-end overflow-hidden text-[calc(clamp(3rem,8vw,6rem)/100*30)] min-[900px]:text-[calc(clamp(3rem,5vw,6rem)/100*30)] whitespace-nowrap">
                                    <p class="slidableTextCenter">{{ $havenBag->name }}&nbsp</p>
                                </div>
                            @endif

                            <div class="flex items-end w-full overflow-hidden font-thin h-fit whitespace-nowrap">
                                <p class="slidableTextCenter">{{ __('barbofus.contentBy') }} <span class="font-normal text-[calc(clamp(3rem,8vw,6rem)/100*25)] min-[900px]:text-[calc(clamp(3rem,5vw,6rem)/100*25)]">{{ $havenBag->user_name }}</span>&nbsp</p>
                            </div>
                        </div>

                        <div class="flex items-end w-full pt-1 overflow-hidden font-thin text-left h-fit whitespace-nowrap">
                            <p class="slidableText">{{ __('barbofus.contentTheme') }} : <span class="italic font-light">{{ __('barbofus.contentHS') }} {{ $havenBag->haven_bag_theme_name }}</span>&nbsp</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative w-full overflow-hidden aspect-video">
                <img src="{{ asset('storage/'. $havenBag->image_path) }}" draggable="false"
                     alt="Image du havre sac"
                     class="animate-slideY absolute top-[-12.5%] h-[125%] w-full object-cover group-hover:top-[-7.5%] group-hover:h-[115%] transition-all duration-1000"
                     style="animation-delay: -{{ rand(0,5000) }}ms">
            </div>
        </button>
    @endforeach
</div>
