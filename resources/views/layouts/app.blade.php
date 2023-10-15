<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="theme-color" content="#fcb943">

    <!-- Primary Meta Tags -->
    <title>Barbofus - Découverte et partage de skin dofus</title>
    <meta name="title" content="Barbofus - Découverte et partage de skin dofus" />
    <meta name="description" content="Tu cherches un skin dofus, ou tu préfères partager les tiens ? Toutes les classes, tous les items, tous les familiers t'attendent !" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://barbofus.com/" />
    <meta property="og:title" content="Barbofus - Découverte et partage de skin dofus" />
    <meta property="og:description" content="Tu cherches un skin dofus, ou tu préfères partager les tiens ? Toutes les classes, tous les items, tous les familiers t'attendent !" />
    <meta property="og:image" content="@yield('app-meta-image')" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://barbofus.com/" />
    <meta property="twitter:title" content="Barbofus - Découverte et partage de skin dofus" />
    <meta property="twitter:description" content="Tu cherches un skin dofus, ou tu préfères partager les tiens ? Toutes les classes, tous les items, tous les familiers t'attendent !" />
    <meta property="twitter:image" content="@yield('app-meta-image')" />

    <!-- Meta Tags Generated with https://metatags.io -->

    <script src="https://www.google.com/recaptcha/api.js"></script>

    {{--<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>--}}
    <style>
        [x-cloak] {
            display: none;
        }

        input:-webkit-autofill {
            background: var(--anthraciteLit);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('/storage/images/icons/favicon.ico') }}">

    @livewireStyles
</head>
<body class="bg-primary text-secondary min-h-screen max-w-screen"
    x-data="{
        alertMessage: '',
        showAlert: false,
        timeoutID: null,

        sessionAlert: {{ session()->has('alert-message') ? 'true' : 'false' }},

        newAlert(msg) {
            clearTimeout(this.timeoutID);

            this.closeAlert();

            setTimeout(() => this.createAlert(msg), 300);
        },
        createAlert(msg) {
            this.showAlert = true;
            this.alertMessage = msg;

            this.timeoutID = setTimeout(() => this.closeAlert(), 5000)
        },
        closeAlert() {
            this.showAlert = false;
        },
    }"
    x-init="if(sessionAlert) setTimeout(() => newAlert('{{ session('alert-message') }}'), 300)"
    x-on:alert-event="newAlert($event.detail.message)">
    @yield('app-content')

    <x-utils.custom-alert />

    @livewireScripts
</body>
</html>
