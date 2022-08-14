<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- The "defer" attribute is important to make sure Alpine waits for Livewire to load first. -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('/storage/images/icons/favicon.ico') }}">

    
    <title>Barbofus</title>

    @livewireStyles
</head>
<body>
    @include('layouts.header')
    @yield('content')

    @livewireScripts
</body>
</html>