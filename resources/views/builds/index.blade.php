@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page des builds !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="mt-[15px] ml-[150px] mr-[150px] flex justify-between">
        @foreach ($builds as $build)
        <div class="border border-r-2">
            <div class="h-[64px] pl-2 pr-2">
                <div class="flex justify-between">
                    <p>{{ $build->title }}</p>
                    <div class="flex w-[100px] justify-between">
                        <p>PA : {{ $build->ap_nbr }}</p>
                        <p>PM : {{ $build->mp_nbr }}</p>
                    </div>
                </div>
                @foreach ($build->Element as $element)
                    <span>{{ $element->name }}</span>
                @endforeach
            </div>
            <a href="{{ $build->build_link }}" target="_blank">
                <img src="{{ asset('/storage/' .$build->image_path) }}" alt="{{ $build->title }}" width="400" height="400">
            </a>
        </div>
        @endforeach
    </div>

@endsection