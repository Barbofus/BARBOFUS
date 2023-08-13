@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='{{ route('login') }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">

                <h1 class="text-[min(5rem,15vw)] font-normal text-center uppercase">Connexion</h1>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8 uppercase">Bienvenue sur Barbofus !</h2>

                @if (session('status'))
                    <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600">Ton mot de passe a bien été réinitilisé</p>
                @endif

                {{-- Email --}}
                <x-forms.text-input :placeholder="'E-mail'" :type="'email'" :name="'email'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </x-forms.text-input>

                {{-- Password --}}
                <x-forms.text-input :placeholder="'Mot de passe'" :type="'password'" :name="'password'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                <x-forms.submit>Se connecter</x-forms.submit>

                <div class="relative flex gap-x-2 items-center -mt-12 -ml-16 hover:text-secondary transition-all text-inactiveText text-lg font-light cursor-pointer">
                    <input class="border rounded-md w-5 h-5 appearance-none border-inactiveText hover:border-secondary bg-opacity-0 accent-goldText transition-all cursor-pointer checked:border-secondary peer" type="checkbox" id="remember" name="remember" />
                    <label class="peer-checked:text-secondary cursor-pointer" for="remember">Se souvenir de moi</label>
                    <img src="{{ asset('storage/images/misc_ui/checkmark.png') }}" class="absolute min-w-[1.875rem] h-[1.875rem] -z-10 -left-1 -top-1 transition-all opacity-0 invisible peer-checked:visible peer-checked:opacity-100">
                </div>

                <div class="flex flex-col gap-y-4 items-start -ml-[min(200px,20vw)]">
                    <a href="{{ route('password.request') }}" class="font-normal text-goldText hover:text-goldTextLit text-lg">Mot de passe oublié ?</a>
                    <p class="font-thin">Aucun compte ? <a href="{{ route('register') }}" class="font-normal text-goldText hover:text-goldTextLit text-lg">S'enregistrer</a></p>
                </div>
            </div>
        </form>
    </div>
@endsection
