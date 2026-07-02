@extends('layouts.basic-views')

@section('content')

    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">{{ __('barbofus.buttonTools') }}</h1>
    <p class="mb-16 -mt-3 text-2xl font-thin text-center uppercase">{{ __('barbofus.descriptionTools') }}</p>

    <div class="w-[calc(100%-1rem)] min-[800px]:w-[80%] flex flex-col space-y-16 mx-auto my-24 text-md min-[800px]:text-lg">

        {{-- Tougli - All Dofus --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/logo_Tougli.webp') }}" alt="Logo Tougli" class="h-40">
            <div>
                <h2 class="text-xl min-[800px]:text-4xl mb-4 font-light">{{ __('barbofus.titleToolsTougli') }}</h2>
                <p class="font-thin">{!! __('barbofus.descriptionToolsTougli') !!}</p>
                <a href="https://tougli.barbofus.com/" title="Tougli - Dofus Opti" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonToolsTougli') }}</a>
            </div>
        </div>

        {{-- Bolgrot - Emmathie --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/bolgrot.png') }}" alt="Logo Bolgrot Solver par Emmathie" class="h-40">
            <div>
                <div class="flex items-end mb-4 space-x-8">
                    <h2 class="text-xl min-[800px]:text-4xl font-light">{{ __('barbofus.titleToolsBolgrot') }}</h2>
                    <a href="https://emmathie.fr/" title="Site web d'Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">par Emmathie</a>
                </div>
                <p class="font-thin">{!! __('barbofus.descriptionToolsBolgrot') !!}</p>
                <a href="https://solver.barbofus.com/bolgrot" title="Bolgrot Solver par Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonToolsBolgrot') }}</a>
            </div>
        </div>

        {{-- Minogolem - Emmathie --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/minogolem.png') }}" alt="Logo Minogolem Solver par Emmathie" class="h-40">
            <div>
                <div class="flex items-end mb-4 space-x-8">
                    <h2 class="text-xl min-[800px]:text-4xl font-light">{{ __('barbofus.titleToolsMinigolem') }}</h2>
                    <a href="https://emmathie.fr/" title="Site web d'Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">par Emmathie</a>
                </div>
                <p class="font-thin">{!! __('barbofus.descriptionToolsMinigolem') !!}</p>
                <a href="https://solver.barbofus.com/minogolem" title="Minogolem Solver par Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonToolsMinigolem') }}</a>
            </div>
        </div>

        {{-- Rainikrone - Emmathie --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/rainikrone.png') }}" alt="Logo Rainikrone Solver par Emmathie" class="h-40">
            <div>
                <div class="flex items-end mb-4 space-x-8">
                    <h2 class="text-xl min-[800px]:text-4xl font-light">{{ __('barbofus.titleToolsRainikrone') }}</h2>
                    <a href="https://emmathie.fr/" title="Site web d'Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">par Emmathie</a>
                </div>
                <p class="font-thin">{!! __('barbofus.descriptionToolsRainikrone') !!}</p>
                <a href="https://solver.barbofus.com/rainikrone" title="Rainikrone Solver par Emmathie" target="_blank" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonToolsRainikrone') }}</a>
            </div>
        </div>

        {{-- Skins 2.0 --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/Dofus_Logo-2_0.png') }}" alt="Logo Tougli" class="h-40">
            <div>
                <h2 class="text-xl min-[800px]:text-4xl mb-4 font-light">{{ __('barbofus.titleToolsSkin2.0') }}</h2>
                <p class="font-thin">{!! __('barbofus.descriptionToolsSkin2.0') !!}</p>
                <a href="{{ route('skins.index') }}" title="Galleri de skins" class="italic font-light underline transition-all text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonToolsSkin2.0') }}</a>
            </div>
        </div>

    </div>

@endsection
