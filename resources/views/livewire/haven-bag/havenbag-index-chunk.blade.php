<div class="grid grid-cols-1 min-[900px]:grid-cols-2 pt-[4.5rem] px-4 gap-x-8 gap-y-16 w-[min(95%,130rem)] mx-auto justify-center">
    @foreach($orderedHavenBags as $key => $havenBag)
        <button wire:key="haven-bag.{{ $havenBag->id }}"
                class="group relative opacity-0 animate-skinApparition w-full h-full shadow-sm bg-primary-100 rounded-xl overflow-hidden hover:brightness-110 transition-all duration-1000"
                style="animation-delay: {{ ($key - ($itemsPerPage * ($page - 1))) * 35 }}ms"
                @click="
                    showHavenBag = true,
                    havenBagImagePath = '{{ asset('storage/'. $havenBag->image_path) }}',
                    popocketIconPath = '{{ asset('storage/'. $havenBag->popocket_icon_path) }}',
                    username = '{{ $havenBag->user_name }}',
                    havenBagName = '{{ $havenBag->name }}',
                    havenBagThemeName = '{{ $havenBag->haven_bag_theme_name }}',
                    AddToUrl('show', {{ $havenBag->id }}),
                    $dispatch('haven-bag-change')"
        >
            <div class="flex justify-left items-center relative p-2">
                <img src="{{ asset('storage/'. $havenBag->popocket_icon_path) }}" class="h-[clamp(3rem,8vw,6rem)] min-[900px]:h-[clamp(3rem,5vw,6rem)] aspect-square invisible min-[400px]:visible" alt="Popoche du havre sac" draggable="false">

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

                            <div class="flex w-full h-fit items-end overflow-hidden font-thin whitespace-nowrap">
                                <p class="slidableTextCenter">par <span class="font-normal text-[calc(clamp(3rem,8vw,6rem)/100*25)] min-[900px]:text-[calc(clamp(3rem,5vw,6rem)/100*25)]">{{ $havenBag->user_name }}</span>&nbsp</p>
                            </div>
                        </div>

                        <div class="font-thin text-left flex w-full h-fit pt-1 items-end overflow-hidden whitespace-nowrap">
                            <p class="slidableText">Thème : <span class="italic font-light">Havre-sac {{ $havenBag->haven_bag_theme_name }}</span>&nbsp</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative w-full aspect-video overflow-hidden">
                <img src="{{ asset('storage/'. $havenBag->image_path) }}" draggable="false"
                     alt="Image du havre sac"
                     class="animate-slideY absolute top-[-12.5%] h-[125%] w-full object-cover group-hover:top-[-7.5%] group-hover:h-[115%] transition-all duration-1000"
                     style="animation-delay: -{{ rand(0,5000) }}ms">
            </div>
        </button>
    @endforeach
</div>
