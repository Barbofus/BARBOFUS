@extends('layouts.app')

@section('content')
    <h1 class="text-2xl text-center text-red-500 ">Bienvenue sur l'edit des skins !</h1>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" action="{{ route('skins.update', ['skin' => $skin]) }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf
            @method('PATCH')

            @include('layouts.skin-form')

        </form>
    </div>
@endsection
