@extends('layouts.basic-views')

@section('content')

    {{-- User --}}
    <h2 class="text-xl font-thin text-center mt-8">Par <span class="text-2xl font-light">{{ $skin->user_name }}</span></h2>
    {{-- Classe --}}
    <div class="grid grid-cols-2 gap-x-8 items-center justify-center mt-4">
        <div class="flex rounded-md justify-self-end items-center gap-x-2 border-2 text-secondary border-goldText px-3 h-12 bg-primary-100 py-2">
            <p class="font-thin text-xl text-secondary">{{ $skin->race_name }}</p>
        </div>

        {{-- Gender --}}
        <div class="flex rounded-md justify-self-start items-center gap-x-2 border-2 text-secondary border-goldText px-3 h-12 bg-primary-100 py-2">
            @if($skin->gender == 'Homme')
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                </svg>
            @endif
            <p class="font-thin text-xl text-secondary">{{ $skin->gender }}</p>
        </div>
    </div>

    <p class="font-thin text-xl text-center text-secondary mt-4">Visage N°{{ $skin->face }}</p>

    <div class="flex flex-col gap-y-4 items-center pt-24 relative h-full overflow-hidden mt-4 min-[1100px]:pb-24">
        {{-- Skin image + icon classe --}}
        <img src="{{ asset('storage/' . $skin->image_path) }}" draggable="false" class="w-[300px]">
        <img src="{{ asset('storage/' . $skin->race_icon) }}" draggable="false" class="absolute -z-10 opacity-40">

        {{-- Button Copy Link --}}
        <button class="uppercase px-4 py-2 goldGradient rounded-md hover:rounded-sm group-hover:brightness-110 group transition-all">
            <p class="text-primary font-medium text-lg group-hover:-translate-y-0.5 transition-all">Copy Link</p>
        </button>

        {{-- Colors --}}
        <div class="absolute -translate-y-20 -translate-x-64 min-[1100px]:-translate-x-16">
            <x-skins-presentation.color name="Peau" color="{{ $skin->color_skin }}" />
        </div>

        <div class="absolute -translate-y-20 -translate-x-32 min-[1100px]:translate-x-16">
            <x-skins-presentation.color name="Cheveux" color="{{ $skin->color_hair }}" />
        </div>

        <div class="absolute -translate-y-20 translate-x-0 min-[1100px]:translate-y-[475px] min-[1100px]:-translate-x-32">
            <x-skins-presentation.color name="Habits 1" color="{{ $skin->color_cloth_1 }}" />
        </div>

        <div class="absolute -translate-y-20 translate-x-32 min-[1100px]:translate-y-[475px] min-[1100px]:translate-x-0">
            <x-skins-presentation.color name="Habits 2" color="{{ $skin->color_cloth_2 }}" />
        </div>

        <div class="absolute -translate-y-20 translate-x-64 min-[1100px]:translate-y-[475px] min-[1100px]:translate-x-32">
            <x-skins-presentation.color name="Habits 3" color="{{ $skin->color_cloth_3 }}" />
        </div>

        {{-- Items --}}
        @if(isset($skin->dofus_item_costume_level))
            <div class="absolute translate-y-6 -translate-x-[30rem] w-[500px] flex justify-end">
                <div class="w-[clamp(25vw,200px,500px)] flex justify-end">
                    <x-skins-presentation.item :subicon="$skin->dofus_item_costume_subicon" :subname="$skin->dofus_item_costume_subname" :name="$skin->dofus_item_costume_name" :level="$skin->dofus_item_costume_level" :icon="$skin->dofus_item_costume_icon"/>
                </div>
            </div>
        @endif

        @if(isset($skin->dofus_item_shield_level))
            <div class="absolute translate-y-40 -translate-x-96 w-[500px] flex justify-end">
                <div class="w-[clamp(25vw,200px,500px)] flex justify-end">
                    <x-skins-presentation.item :subicon="$skin->dofus_item_shield_subicon" :subname="$skin->dofus_item_shield_subname" :name="$skin->dofus_item_shield_name" :level="$skin->dofus_item_shield_level" :icon="$skin->dofus_item_shield_icon"/>
                </div>
            </div>
        @endif

        @if(isset($skin->dofus_item_pet_level))
            <div class="absolute translate-y-72 -translate-x-[28rem] w-[500px] flex justify-end">
                <div class="w-[clamp(25vw,200px,500px)] flex justify-end">
                        <x-skins-presentation.item :subicon="$skin->dofus_item_pet_subicon" :subname="$skin->dofus_item_pet_subname" :name="$skin->dofus_item_pet_name" :level="$skin->dofus_item_pet_level" :icon="$skin->dofus_item_pet_icon"/>
                </div>
            </div>
        @endif

        @if(isset($skin->dofus_item_hat_level))
            <div class="absolute translate-y-10 translate-x-[27rem] w-[500px] flex justify-start">
                <div class="w-[clamp(25vw,200px,500px)] flex justify-start">
                    <x-skins-presentation.item :subicon="$skin->dofus_item_hat_subicon" :subname="$skin->dofus_item_hat_subname" :name="$skin->dofus_item_hat_name" :level="$skin->dofus_item_hat_level" :icon="$skin->dofus_item_hat_icon"/>
                </div>
            </div>
        @endif

        @if(isset($skin->dofus_item_cloak_level))
            <div class="absolute translate-y-52 translate-x-[30rem] w-[500px] flex justify-start">
                <div class="w-[clamp(25vw,200px,500px)] flex justify-start">
                    <x-skins-presentation.item :subicon="$skin->dofus_item_cloak_subicon" :subname="$skin->dofus_item_cloak_subname" :name="$skin->dofus_item_cloak_name" :level="$skin->dofus_item_cloak_level" :icon="$skin->dofus_item_cloak_icon"/>
                </div>
            </div>
        @endif
    </div>

    <div class="h-8"></div>
@endsection
