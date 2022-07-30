<a href="{{ route('index') }}">Accueil</a>
<a href="{{ route('about') }}">About</a>

@guest
    <a href="{{ route('login') }}">Login</a>
    <a href="#">Register</a>
@endguest

@auth
    <a href="#">Log out</a>
@endauth