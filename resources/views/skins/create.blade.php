@extends('layouts.basic-views')

@section('content')
    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">Création</h1>
    <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">Présente nous tes skins !</h2>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" action="{{ route('skins.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf

            <x-forms.skin-form :$races/>

        </form>
    </div>
@endsection
