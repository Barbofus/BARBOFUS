@extends('layouts.basic-views')

@section('content')

    <div class="flex flex-col gap-y-1 min-[950px]:gap-y-4 h-[1450px] min-[950px]:h-[850px] overflow-hidden">
        {{-- User --}}
        <h2 class="text-[min(5vw,1.25rem)] font-thin text-center mt-11 min-[950px]:mt-8">Par <span class="text-[min(6vw,1.5rem)] font-light">{{ $skin->user_name }}</span></h2>
        {{-- Classe --}}
        <div class="grid grid-cols-2 gap-x-8 items-center justify-center">
            <div class="flex rounded-md justify-self-end items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary">{{ $skin->race_name }}Eniripsa</p>
            </div>

            {{-- Gender --}}
            <div class="flex rounded-md justify-self-start items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                @if($skin->gender == 'Homme')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[950px]:h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                    </svg>
                @endif
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary">{{ $skin->gender }}</p>
            </div>
        </div>

        <p class="font-thin text-[min(5vw,1.25rem)] text-center text-secondary">Visage N°{{ $skin->face }}</p>

        <div class="flex flex-col gap-y-4 items-center min-[950px]:pt-24 relative h-full">
            {{-- Skin image + icon classe --}}
            <img src="{{ asset('storage/' . $skin->image_path) }}" draggable="false" class="max-[949px]:h-[min(50vh,390px)] min-[950px]:w-[300px]">
            <img src="{{ asset('storage/' . $skin->race_icon) }}" draggable="false" class="absolute -z-10 opacity-40">

            {{-- Button Copy Link --}}
            <button class="uppercase px-2 min-[950px]:px-4 py-1 min-[950px]:py-2 goldGradient rounded-md hover:rounded-sm group-hover:brightness-110 group transition-all">
                <p class="text-primary font-medium text-[min(4.5vw,1.125rem)] group-hover:-translate-y-0.5 transition-all">Copy Link</p>
            </button>

            <div class="flex flex-row min-[420px]:flex-col items-center gap-x-4 gap-y-4 mt-4">
                {{-- Colors --}}

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[19.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[7.5rem]">
                        <x-skins-presentation.color name="Peau" color="{{ $skin->color_skin }}" />
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[11.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[0.5rem]">
                        <x-skins-presentation.color name="Cheveux" color="{{ $skin->color_hair }}" />
                    </div>
                </div>

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[3.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[11.5rem]">
                        <x-skins-presentation.color name="Habits 1" color="{{ $skin->color_cloth_1 }}" />
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[4.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[3.5rem]">
                        <x-skins-presentation.color name="Habits 2" color="{{ $skin->color_cloth_2 }}" />
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[12.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[4.5rem]">
                        <x-skins-presentation.color name="Habits 3" color="{{ $skin->color_cloth_3 }}" />
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-y-4 mt-4">
                {{-- Items --}}
                @if(isset($skin->dofus_item_costume_level))
                    <div class="min-[950px]:absolute top-0 order-4 min-[950px]:translate-y-[7.5rem] min-[950px]:-translate-x-[45.5rem] w-[500px] flex justify-center min-[950px]:justify-end">
                        <div class="w-[clamp(90vw,200px,500px)] min-[950px]:w-[clamp(25vw,200px,500px)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_costume_subicon" :subname="$skin->dofus_item_costume_subname" :name="$skin->dofus_item_costume_name" :level="$skin->dofus_item_costume_level" :icon="$skin->dofus_item_costume_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_shield_level))
                    <div class="min-[950px]:absolute top-0 order-3 min-[950px]:translate-y-[16rem] min-[950px]:-translate-x-[39.5rem] w-[500px] flex justify-center min-[950px]:justify-end">
                        <div class="w-[clamp(90vw,200px,500px)] min-[950px]:w-[clamp(25vw,200px,500px)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_shield_subicon" :subname="$skin->dofus_item_shield_subname" :name="$skin->dofus_item_shield_name" :level="$skin->dofus_item_shield_level" :icon="$skin->dofus_item_shield_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_pet_level))
                    <div class="min-[950px]:absolute top-0 order-5 min-[950px]:translate-y-[24rem] min-[950px]:-translate-x-[43.5rem] w-[500px] flex justify-center min-[950px]:justify-end">
                        <div class="w-[clamp(90vw,200px,500px)] min-[950px]:w-[clamp(25vw,200px,500px)] flex justify-center min-[950px]:justify-end">
                                <x-skins-presentation.item :subicon="$skin->dofus_item_pet_subicon" :subname="$skin->dofus_item_pet_subname" :name="$skin->dofus_item_pet_name" :level="$skin->dofus_item_pet_level" :icon="$skin->dofus_item_pet_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_hat_level))
                    <div class="min-[950px]:absolute top-0 order-1 min-[950px]:translate-y-[8.5rem] min-[950px]:translate-x-[11.5rem] w-[500px] flex justify-center min-[950px]:justify-start">
                        <div class="w-[clamp(90vw,200px,500px)] min-[950px]:w-[clamp(25vw,200px,500px)] flex justify-center min-[950px]:justify-start">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_hat_subicon" :subname="$skin->dofus_item_hat_subname" :name="$skin->dofus_item_hat_name" :level="$skin->dofus_item_hat_level" :icon="$skin->dofus_item_hat_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_cloak_level))
                    <div class="min-[950px]:absolute top-0 order-2 min-[950px]:translate-y-[19rem] min-[950px]:translate-x-[14.5rem] w-[500px] flex justify-center min-[950px]:justify-start">
                        <div class="w-[clamp(90vw,200px,500px)] min-[950px]:w-[clamp(25vw,200px,500px)] flex justify-center min-[950px]:justify-start">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_cloak_subicon" :subname="$skin->dofus_item_cloak_subname" :name="$skin->dofus_item_cloak_name" :level="$skin->dofus_item_cloak_level" :icon="$skin->dofus_item_cloak_icon"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
