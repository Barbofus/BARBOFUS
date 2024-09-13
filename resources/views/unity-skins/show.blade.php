@extends('layouts.basic-views')

@section('meta-image')
    {{ asset('storage/' . $skin->image_path) }}
@endsection

@section('content')

    <div
        class="relative mb-24 flex flex-col gap-y-1 min-[950px]:gap-y-4 h-[100rem] min-[950px]:h-fit py-4 w-[min(95rem,95vw)] mx-auto overflow-hidden min-[950px]:mt-4 min-[950px]:rounded-lg min-[950px]:bg-black min-[950px]:bg-opacity-[0.09] min-[950px]:shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)]"
        x-data="{ skinDeleteID: null, skinDeleteImg:''}">

        @can('validate-skin')
            <div class="flex absolute gap-x-2 top-2 right-2">
                {{-- Modification --}}
                <a class="scale-90 hover:scale-110 text-inactiveText hover:text-blue-500 transition-all"
                   href="{{ route('unity-skins.edit', $skin->id) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>

                {{-- Suppression --}}
                <button class="scale-90 hover:scale-110 text-inactiveText hover:text-red-500 transition-all"
                        @click="skinDeleteID = {{ $skin->id }}, skinDeleteImg='{{ asset('storage/'. $skin->image_path) }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </button>
            </div>


            <div class="fixed top-0 right-0 bottom-0 left-0 z-50"
                 x-show="skinDeleteID" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-full"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-y-full">
                <x-utils.unity-skin-delete-verification :use-controller="true" :$skin/>
            </div>
        @endcan

        {{-- User --}}
        <div class="flex gap-x-4 items-center justify-center mt-11 min-[950px]:mt-4">

            <h2 class="bg-gradient-to-r from-[var(--goldDark)] to-[var(--goldLit)] bg-clip-text inline-block font-normal italic text-[min(6vw,1.5rem)] text-transparent">{{ $skin->name }}</h2>
            <h2 class="text-[min(5vw,1.25rem)] font-thin text-center">Par <span
                    class="text-[min(6vw,1.5rem)] font-light">{{ $skin->user_name }}</span></h2>

            @can('admin-access')
                @if(isset($discord))
                    <x-utils.small-discord-card :$discord/>
                @endif
            @endcan
        </div>

        {{-- Classe --}}
        <div class="grid grid-cols-2 gap-x-4 min-[420px]:gap-x-8 items-center justify-center">
            <div
                class="flex rounded-md justify-self-end items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary">{{ $skin->race_name }}</p>
            </div>

            {{-- Gender --}}
            <div
                class="flex rounded-md justify-self-start items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                @if($skin->gender == 'Homme')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[950px]:h-full"
                         viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                    </svg>
                @endif
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary">{{ $skin->gender }}</p>
            </div>
        </div>

        <div class="flex justify-center items-center space-x-4">
            <p class="font-thin text-[min(5vw,1.25rem)] text-center text-secondary">Visage N°{{ $skin->face }}</p>
            <img src="{{  asset(sprintf("storage/images/icons/classes/faces/%s%d_%s.png", $skin->race_dofus_id, $skin->gender === 'Homme' ? 0 : 1, $skin->face)) }}"
                alt="Visage {{ $skin->race_name }} n° {{ $skin->face }}" draggable="false" class="h-12">
        </div>

        <div class="flex flex-col gap-y-4 items-center min-[950px]:pt-24 relative h-full">
            {{-- Skin image + icon classe --}}
            <img src="{{ asset('storage/' . $skin->image_path) }}" draggable="false"
                 class="max-[949px]:h-[min(50vh,25rem)] min-[950px]:w-[18.75rem]">
            <img src="{{ asset('storage/' . $skin->race_icon) }}" draggable="false" class="absolute -z-10 opacity-40">

            {{-- Button Copy Link --}}
            <button
                class="uppercase px-2 min-[950px]:px-4 py-1 min-[950px]:py-2 goldGradient rounded-md hover:rounded-3xl group-hover:brightness-110 group transition-all"
                x-data="{
                        copied: 'Copy Link',

                        CopyLink() {
                            if(!navigator.clipboard) return;

                            navigator.clipboard.writeText('{{ url()->current() }}');
                            this.copied = 'Copié';
                        }
                    }"
                x-on:mousedown="CopyLink">
                <p class="text-primary font-medium text-[min(4.5vw,1.125rem)] group-hover:tracking-widest transition-all"
                   x-text="copied"></p>
            </button>

            <div class="flex flex-row min-[420px]:flex-col items-center gap-x-4 gap-y-4 mt-4">
                {{-- Colors --}}

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div
                        class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[19.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[7.5rem]">
                        <x-skins-presentation.color name="Peau" color="{{ $skin->color_skin }}"/>
                    </div>

                    <div
                        class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[11.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[0.5rem]">
                        <x-skins-presentation.color name="Cheveux" color="{{ $skin->color_hair }}"/>
                    </div>
                </div>

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div>
                        <div
                            class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[3.25rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[15rem]">
                            <x-skins-presentation.color name="Habits 1" color="{{ $skin->color_cloth_1 }}"/>
                        </div>

                        <div
                            class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[4.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[7rem]">
                            <x-skins-presentation.color name="Habits 2" color="{{ $skin->color_cloth_2 }}"/>
                        </div>
                    </div>

                    <div>
                        <div
                            class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[11rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[0rem]">
                            <x-skins-presentation.color name="Habits 3" color="{{ $skin->color_cloth_3 }}"/>
                        </div>

                        <div
                            class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[18.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[8rem]">
                            <x-skins-presentation.color name="Habits 4" color="{{ $skin->color_cloth_4 }}"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-y-4 mt-4">
                {{-- Items --}}
                @if(isset($skin->dofus_item_costume_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%+10rem)] top-[21rem] order-6 w-[31.25rem] flex justify-center min-[950px]:justify-start">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-start">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_costume_subicon"
                                                       :subname="$skin->dofus_item_costume_subname"
                                                       :name="$skin->dofus_item_costume_name"
                                                       :level="$skin->dofus_item_costume_level"
                                                       :icon="$skin->dofus_item_costume_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_wing_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%-37rem)] top-[6rem] order-3 w-[31.25rem] flex justify-center min-[950px]:justify-end">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_wing_subicon"
                                                       :subname="$skin->dofus_item_wing_subname"
                                                       :name="$skin->dofus_item_wing_name"
                                                       :level="$skin->dofus_item_wing_level"
                                                       :icon="$skin->dofus_item_wing_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_shield_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%-41rem)] top-[12rem] order-5 w-[31.25rem] flex justify-center min-[950px]:justify-end">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_shield_subicon"
                                                       :subname="$skin->dofus_item_shield_subname"
                                                       :name="$skin->dofus_item_shield_name"
                                                       :level="$skin->dofus_item_shield_level"
                                                       :icon="$skin->dofus_item_shield_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_pet_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%-43.5rem)] top-[24rem] order-7 w-[31.25rem] flex justify-center min-[950px]:justify-end">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_pet_subicon"
                                                       :subname="$skin->dofus_item_pet_subname"
                                                       :name="$skin->dofus_item_pet_name"
                                                       :level="$skin->dofus_item_pet_level"
                                                       :icon="$skin->dofus_item_pet_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_hat_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%+11.5rem)] top-[6rem] order-1 w-[31.25rem] flex justify-center min-[950px]:justify-start">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-start">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_hat_subicon"
                                                       :subname="$skin->dofus_item_hat_subname"
                                                       :name="$skin->dofus_item_hat_name"
                                                       :level="$skin->dofus_item_hat_level"
                                                       :icon="$skin->dofus_item_hat_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_shoulder_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%+8.5rem)] top-[13.5rem] order-2 w-[31.25rem] flex justify-center min-[950px]:justify-start">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-start">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_shoulder_subicon"
                                                       :subname="$skin->dofus_item_shoulder_subname"
                                                       :name="$skin->dofus_item_shoulder_name"
                                                       :level="$skin->dofus_item_shoulder_level"
                                                       :icon="$skin->dofus_item_shoulder_icon"/>
                        </div>
                    </div>
                @endif

                @if(isset($skin->dofus_item_cloak_level))
                    <div
                        class="min-[950px]:absolute left-[calc(50%-40rem)] top-[18rem] order-4 w-[31.25rem] flex justify-center min-[950px]:justify-end">
                        <div
                            class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <x-skins-presentation.item :subicon="$skin->dofus_item_cloak_subicon"
                                                       :subname="$skin->dofus_item_cloak_subname"
                                                       :name="$skin->dofus_item_cloak_name"
                                                       :level="$skin->dofus_item_cloak_level"
                                                       :icon="$skin->dofus_item_cloak_icon"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
