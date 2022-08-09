@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page des builds !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="mt-[32px] border-t pt-[16px] flex justify-center space-x-4">
        @foreach ($races as $race)
            <img src="{{ asset('/storage/images/icons/classes/' .$race->icon_path) }}" alt="{{ $race->name }}" width="100" height="100" class="hover:grayscale hover:opacity-95 transition ease-in duration-100">
        @endforeach
    </div>

    <div class="mt-[32px] border-t pt-[16px] flex justify-center space-x-4">
        @foreach ($elements as $element)
            <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="100" height="100" class="hover:grayscale hover:opacity-95 transition ease-in duration-100">
        @endforeach
    </div>

    <div class="mt-[48px] ml-[150px] mr-[150px] grid grid-cols-5 gap-y-8 mb-[128px] border-t pt-[16px]">
        @foreach ($builds as $build)
        <a href="{{ $build->build_link }}" target="_blank" class="group">
            <div class="border rounded-xl w-[400px] overflow-hidden">
                <div class="relative">
                    <img src="{{ asset('/storage/images/banner/classes/' .$build->Race->banner_path) }}" alt="{{ $build->Race->name }}" class="brightness-[45%] contrast-[120%] group-hover:brightness-[100%] group-hover:contrast-[100%] transition duration-150">
                    <div class=" absolute text-white top-0 w-full h-full">
                        <div class=" h-[40%] w-full flex items-center justify-center">
                            <span class=" text-3xl font-bold">{{ $build->title }}</span>
                        </div>
                        <div class=" h-[60%] w-full flex">
                            <div class=" h-full w-[50%]">
                                <div class="flex justify-center h-full p-4">
                                    <div class="relative w-[50%] h-full flex items-center justify-center">
                                        <img src="{{ asset('/storage/images/icons/elements/icon_pa.png') }}" alt="Icone PA" width="70">
                                        <span class="absolute text-xl font-bold">{{ $build->ap_nbr }}</span>
                                    </div>
                                    
                                    <div class="relative w-[50%] h-full flex items-center justify-center">
                                        <img src="{{ asset('/storage/images/icons/elements/icon_pm.png') }}" alt="Icone PM" width="60">
                                        <span class="absolute text-xl font-bold">{{ $build->mp_nbr }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class=" h-full w-[50%] bg-white bg-opacity-[35%]">
                                <div class=" w-full h-[50%] flex items-center justify-end">
                                    @foreach ($build->Element as $element)
                                        @if ($element->is_elemental == 1)
                                            <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="50" height="50">
                                        @endif
                                    @endforeach
                                </div>
                                <div class=" w-full h-[50%] border-t flex items-center justify-end">
                                    @foreach ($build->Element as $element)
                                        @if ($element->is_elemental == 0)
                                            <img src="{{ asset('/storage/images/icons/elements/' .$element->icon_path) }}" alt="{{ $element->name }}" width="50" height="50">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- 
                            
                         --}}
                    </div>
                </div>
                <img src="{{ asset('/storage/images/' .$build->image_path) }}" alt="{{ $build->title }}" width="400" height="400" class="group-hover:grayscale group-hover:opacity-95 transition ease-in duration-150">
            </div>
        </a>
        @endforeach
    </div>

@endsection