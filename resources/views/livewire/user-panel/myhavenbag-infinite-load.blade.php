<div x-data="{ havenBagDeleteID: null, havenBagDeleteImg: '', }">
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Mes havre-sacs'" :subtitle="'Tes propres créations'" />

        <div class="bg-primary w-full flex justify-center sticky top-12 py-8 z-10">
            <a href="{{ route('havre-sacs.create') }}" class="goldGradient px-4 py-2 rounded-md text-primary flex flex-col transition-all items-center text-lg min-[400px]:text-2xl hover:rounded-3xl group hover:brightness-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                <p class="group-hover:-translate-y-2 transition-all">Poster un havre-sac</p>
            </a>
        </div>

        <div class="grid grid-cols-1 min-[900px]:grid-cols-2 pt-[4.5rem] min-[400px]:px-4 gap-x-8 gap-y-16 w-[min(95%,130rem)] mx-auto justify-center">
            @foreach($havenBags as $key => $havenBag)
                <div class="group relative opacity-0 animate-skinApparition w-full h-full shadow-sm rounded-xl overflow-hidden {{ (($havenBag->status == 'Pending') ? 'bg-pendingBackground' : (($havenBag->status == 'Refused') ? 'bg-refusedBackground' : 'bg-primary-100')) }}">
                    <a href="{{ route('havre-sacs.index', 'show='.$havenBag->id) }}" wire:key="haven-bag.{{ $havenBag->id }}" class="cursor-pointer">
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
                                 class="absolute w-full object-cover top-[-7.5%] h-[115%]">

                            <div class="absolute w-full text-inactiveText flex justify-end space-x-2 px-2 top-2 cursor-pointer">
                                <a href="{{ route('havre-sacs.edit', $havenBag->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 hover:scale-125 group-hover:text-blue-500 transition-all">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>

                                <button @click="havenBagDeleteID = {{ $havenBag->id }}, havenBagDeleteImg = '{{ asset('storage/' . $havenBag->image_path) }}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 hover:scale-125 group-hover:text-red-500 transition-all">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </a>

                    @if($havenBag->status == 'Pending')
                        <p class="p-2 text-sm min-[400px]:text-lg text-yellow-200 italic">En attente ...</p>
                    @elseif($havenBag->status == 'Refused')
                        <p class="p-2 text-sm min-[400px]:text-lg text-red-400 italic">Havre-sac Refusé</p>
                    @else
                        <p class="p-2 text-sm min-[400px]:text-lg text-inactiveText italic">Posté {{ $havenBag->created_at->diffForHumans() }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="fixed top-0 right-0 bottom-0 left-0"
         x-show="havenBagDeleteID"  x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-full">
        <x-utils.haven-bag-delete-verification />
    </div>

    {{-- Scroll horizontalement les noms trop long, s'actualise en temps réel --}}
    @vite(['resources/js/skins/NameScroll.js', 'resources/js/skins/ScrollListeners.js'])
</div>
