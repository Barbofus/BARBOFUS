
@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='{{ route('password.update') }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">

                <h1 class="text-[min(5rem,15vw)] font-normal text-center uppercase">Mot de passe oublié</h1>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8 uppercase">Réinitialise ton mot de passe</h2>

                {{-- Pseudo --}}
                <input hidden="" name="token" value="{{ request()->route('token') }}">

                {{-- Email --}}
                <x-forms.text-input :placeholder="'E-mail'" :type="'email'" :name="'email'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </x-forms.text-input>

                {{-- Password --}}
                <x-forms.text-input :placeholder="'Mot de passe'" :type="'password'" :name="'password'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                {{-- Password Confirmation --}}
                <x-forms.text-input :placeholder="'Confirmation'" :type="'password'" :name="'password_confirmation'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                <x-forms.submit>Envoyer</x-forms.submit>

                <p class="font-thin -ml-[min(200px,20vw)]">Mot de passe retrouvé ? <a href="{{ route('login') }}" class="font-normal text-goldText hover:text-goldTextLit text-lg">Se connecter</a></p>
            </div>
        </form>
    </div>
@endsection
