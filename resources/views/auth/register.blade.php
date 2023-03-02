@extends('layouts.app')

@section('content')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page de création de compte !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <form method="POST" action='{{ route('register') }}' class="flex justify-center">
      @csrf
      <div class="w-full px-5 py-10 md:w-1/2 md:px-10">

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="px-1 font-semibold text-l">Pseudo</label>
                <div class="flex">
                    <div class="z-10 flex items-center justify-center w-10 pl-1 text-center pointer-events-none"><i class="text-lg text-gray-400 mdi mdi-email-outline"></i></div>
                    <input id="name" name="name" type="text" class="w-full py-2 pl-10 pr-3 -ml-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500" placeholder="RoxxorDu92">
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
                <label for="" class="px-1 font-semibold text-l">Email</label>
                <div class="flex">
                    <div class="z-10 flex items-center justify-center w-10 pl-1 text-center pointer-events-none"><i class="text-lg text-gray-400 mdi mdi-email-outline"></i></div>
                    <input id="email" name="email" type="email" class="w-full py-2 pl-10 pr-3 -ml-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500" placeholder="theroxxordu92@gmiel.com">
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
                <label for="" class="px-1 font-semibold text-l">Mot de passe</label>
                <div class="flex">
                    <div class="z-10 flex items-center justify-center w-10 pl-1 text-center pointer-events-none"><i class="text-lg text-gray-400 mdi mdi-lock-outline"></i></div>
                    <input id="password" name="password" type="password" class="w-full py-2 pl-10 pr-3 -ml-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500" placeholder="************">
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
                <label for="" class="px-1 font-semibold text-l">Confirmation du mot de passe</label>
                <div class="flex">
                    <div class="z-10 flex items-center justify-center w-10 pl-1 text-center pointer-events-none"><i class="text-lg text-gray-400 mdi mdi-lock-outline"></i></div>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full py-2 pl-10 pr-3 -ml-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500" placeholder="************">
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
                <button type="submit" class="block w-full max-w-xs px-3 py-3 mx-auto font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-700 focus:bg-yellow-700">VALIDER</button>
            </div>
        </div>
      </div>
    </form>
@endsection
