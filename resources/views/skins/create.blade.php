@extends('layouts.basic-views')

@section('content')
    <h1 class="text-2xl text-center text-red-500 ">Bienvenue sur le create des skins !</h1>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" action="{{ route('skins.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf

            <x-forms.skin-form :$races/>

        </form>
    </div>
@endsection
