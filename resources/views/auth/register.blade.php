@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form id="register-form" method="POST" action='{{ route('register') }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">

                <h1 class="text-[min(5rem,15vw)] font-normal text-center uppercase">Inscription</h1>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8 uppercase">Rejoins-nous sur Barbofus !</h2>

                <h2 class="text-xl font-thin text-center -mt-10 mb-8">Attention! L'e-mail de vérification risque d'arriver dans tes spams/indésirables.</h2>

                {{-- Pseudo --}}
                <x-forms.text-input :placeholder="'Pseudo'" :type="'text'" :name="'name'" :max-size="64">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </x-forms.text-input>

                {{-- Email --}}
                <x-forms.text-input :placeholder="'E-mail'" :type="'email'" :name="'email'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </x-forms.text-input>

                {{-- Password --}}
                <x-forms.text-input autocomplete="false" :placeholder="'Mot de passe'" :type="'password'" :name="'password'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                {{-- Password Confirmation --}}
                <x-forms.text-input autocomplete="false" :placeholder="'Confirmation'" :type="'password'" :name="'password_confirmation'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                <div class="mb-8">
                    <button class="g-recaptcha block px-8 py-3 text-lg mx-auto font-normal text-primary goldGradient rounded-lg hover:brightness-110 hover:tracking-widest transition-all focus:brightness-75 uppercase"
                            data-sitekey="{{ config('services.recaptcha.site_key') }}"
                            data-callback='onSubmit'
                            data-action='register'>
                        S'enregistrer
                    </button>

                    @error('g-recaptcha-response')
                    <x-forms.requirements-error :message="$message"/>
                    @enderror
                </div>

                <p class="font-thin -ml-[min(200px,20vw)]">Déjà inscrit ? <a href="{{ route('login') }}" class="font-normal text-goldText hover:text-goldTextLit text-lg">Se connecter</a></p>
            </div>
        </form>

        <script src="https://www.google.com/recaptcha/api.js"></script>

        <script>
            function onSubmit(token) {
                document.getElementById("register-form").submit();
            }
        </script>
    </div>
@endsection
