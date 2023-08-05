<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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

    <title>Barbofus</title>
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
