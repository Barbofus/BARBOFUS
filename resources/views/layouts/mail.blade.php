<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barbofus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="w-[35rem] rounded-md bg-primary text-secondary font-light text-md overflow-hidden mx-auto pb-4">
        <img src="{{ asset('storage/images/misc_ui/Barbofus_Logo_Full.png') }}" class="w-full">
        <div class="px-8">
            <h1 class="font-normal text-[3rem] mt-6 mb-4">
                @yield('mail-subject')
            </h1>
            <p class="mb-4">Salut <span class="italic">{{ $user->name }}</span>,</p>
            <p class="text-secondary mb-4">
                @yield('mail-sentence')
            </p>

            @yield('mail-body')

            <div class="flex justify-center">
                <button class="px-8 py-4 rounded-md text-primary goldGradient font-normal italic my-12">
                    @yield('mail-button')
                </button>
            </div>

            <p class="text-sm">Si le bouton ne fonctionne pas, copie colle ce lien dans ta barre de recherche:
                <span class="text-blue-500 break-all">
                    @yield('mail-url')
                </span>
            </p>

            <p class="mt-8">Cordialement,</p>
            <span class="font-medium">{{ config('app.name') }}</span>
        </div>
    </div>
    <p class="text-center text-sm text-black font-light">© {{ date('Y') }} {{ config('app.name') }}. @lang('Tous droits réservés.')</p>
</body>
</html>
