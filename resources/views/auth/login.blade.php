@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='{{ route('login') }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="flex flex-col items-center w-full px-5 py-10 gap-y-8">

                <h1 class="text-[min(5rem,15vw)] font-normal text-center uppercase">{{ __('barbofus.titleLogin') }}</h1>
                <h2 class="mb-8 -mt-10 text-2xl font-thin text-center uppercase">{{ __('barbofus.descriptionLogin') }}</h2>

                @if (session('status'))
                    <p class="px-8 py-4 mb-8 font-light text-center text-green-600 bg-green-200 border-2 border-green-600 rounded-md text-md">{{ __('barbofus.alertPasswordSaved') }}</p>
                @endif

                @if (session('sso_source') === 'tougli')
                    <p class="px-8 py-4 mb-8 font-light text-center text-blue-600 bg-blue-200 border-2 border-blue-600 rounded-md text-md">Connexion requise pour accéder à Tougli</p>
                @endif

                {{-- Email --}}
                <x-forms.text-input :placeholder="__('barbofus.inputEmail')" :type="'email'" :name="'email'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </x-forms.text-input>

                {{-- Password --}}
                <x-forms.text-input :placeholder="__('barbofus.inputPassword')" :type="'password'" :name="'password'">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </x-forms.text-input>

                <x-forms.submit>{{ __('barbofus.buttonLogin') }}</x-forms.submit>

                <input type="hidden" name="redirect" value="{{ session('sso_redirect') }}">
                <input type="hidden" name="source" value="{{ session('sso_source') }}">

                <div class="relative flex items-center -mt-12 -ml-16 text-lg font-light transition-all cursor-pointer gap-x-2 hover:text-secondary text-inactiveText">
                    <input class="w-5 h-5 transition-all bg-opacity-0 border rounded-md appearance-none cursor-pointer border-inactiveText hover:border-secondary accent-goldText checked:border-secondary peer" type="checkbox" id="remember" name="remember" />
                    <label class="cursor-pointer peer-checked:text-secondary" for="remember">{{ __('barbofus.inputRememberMe') }}</label>
                    <img src="{{ asset('storage/images/misc_ui/checkmark.png') }}" class="absolute min-w-[1.875rem] h-[1.875rem] -z-10 -left-1 -top-1 transition-all opacity-0 invisible peer-checked:visible peer-checked:opacity-100">
                </div>

                <div class="flex flex-col gap-y-4 items-start -ml-[min(200px,20vw)]">
                    <a href="{{ route('password.request') }}" class="text-lg font-normal text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonForgotPassword') }}</a>
                    <p class="font-thin">{{ __('barbofus.descriptionNoAccount') }} <a href="{{ route('register') }}" class="text-lg font-normal text-goldText hover:text-goldTextLit">{{ __('barbofus.buttonRegister') }}</a></p>
                </div>
            </div>
        </form>

        <script>
            // On ne touche que si query params redirect/source existent
            const url = new URL(window.location.href);
            if (url.searchParams.has('redirect') || url.searchParams.has('source')) {
                // Supprime les params
                url.searchParams.delete('redirect');
                url.searchParams.delete('source');
                // Remplace l’URL actuelle sans recharger la page
                window.history.replaceState({}, '', url.pathname + url.search);
            }
        </script>
    </div>
@endsection
