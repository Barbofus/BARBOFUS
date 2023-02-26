@extends('layouts.userPageIndex')

@section('user-page-content')
    <h1 class="w-full mt-8 text-4xl text-center text-red-500">Panel Admin</h1>

    <form action="{{ route('dofusDBApi.update') }}" method="post" class="flex justify-center w-full mt-16">
        @method('PUT')
        @csrf

        <button class="w-48 p-4 text-2xl text-white bg-blue-500 rounded-lg hover:bg-blue-400">Mettre à jour l'API DofusDB</button>
    </form>
@endsection
