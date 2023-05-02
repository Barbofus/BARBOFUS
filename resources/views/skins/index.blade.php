@extends('layouts.basic-views')

@section('content')

    <div class="flex justify-center">
        <div class="grid grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 max-w-[1400px] justify-center">
        @foreach($skins as $skin)
            <div>
                <img src="{{ asset('storage\/') . $skin->image_path }}">
                <p>{{ $skin->User->name }}</p>
            </div>
        @endforeach
        </div>
    </div>
@endsection
