@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page de création de builds !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <form method="POST" action='{{ route('builds.create') }}' class="flex justify-center">
      @csrf
      <div class="w-full md:w-1/2 py-10 px-5 md:px-10">

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Pseudo</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-email-outline text-gray-400 text-lg"></i></div>
                    <input id="name" name="name" type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="RoxxorDu92">
                </div>
            </div>
            @error('name')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Email</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-email-outline text-gray-400 text-lg"></i></div>
                    <input id="email" name="email" type="email" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="theroxxordu92@gmiel.com">
                </div>
            </div>
            @error('email')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Mot de passe</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                    <input id="password" name="password" type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="************">
                </div>
            </div>
            @error('password')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="-mx-3 mb-12 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Confirmation du mot de passe</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="************">
                </div>
            </div>
            @error('password_confirmation')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="flex justify-center -mx-3">
            <div class="w-full px-3 mb-5">
                <button type="submit" class="block w-full max-w-xs mx-auto bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white rounded-lg px-3 py-3 font-semibold">VALIDER</button>
            </div>
        </div>
      </div>
    </form>
@endsection