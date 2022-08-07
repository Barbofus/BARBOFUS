@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page des builds !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="mt-[15px]">
        @foreach ($builds as $build)
        <div class="border border-r-2 w-[350px] h-[512px]">
            <div class="flex justify-between">
                <p>{{ $build->title }}</p>
                <div class="flex w-[100px] justify-between">
                    <p>PA : {{ $build->ap_nbr }}</p>
                    <p>PM : {{ $build->mp_nbr }}</p>
                </div>
            </div>
            <img src="{{ asset('/storage/' .$build->image_path) }}" alt="{{ $build->build_link }}" href="{{ $build->build_link }}" width="476" height="476">
        </div>
        @endforeach
    </div>

@endsection