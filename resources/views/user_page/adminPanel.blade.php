@extends('layouts.userPageIndex')

@section('user-page-content')
    <h1 class="w-full mt-8 text-4xl text-center text-red-500">Panel Admin</h1>

    <div class="flex justify-center w-full mt-16">

        @if($needDofusDBUpdate)
        <a href="{{ route('dofusDBApi') }}" class="w-48 p-4 text-2xl text-white bg-blue-500 rounded-lg hover:bg-blue-400">Mettre à jour l'API DofusDB</a>
        @else
        <div class="w-48 p-4 text-2xl rounded-lg bg-slate-500">API DofusDB à jour</div>
        @endif

    </div>
@endsection
