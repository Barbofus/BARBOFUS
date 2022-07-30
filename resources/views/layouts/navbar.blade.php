<div class="text-2xl justify-center pl-5 pt-2 pb-3 border-b">
    <ul class="flex">
        <li><a href="{{ route('index') }}" class="pr-4 hover:font-bold focus:font-bold focus:hover:text-gray-600">Accueil</a></li>
        <li><a href="{{ route('about') }}" class=" pr-4 hover:font-bold focus:font-bold focus:hover:text-gray-600">About</a></li>

        @guest
            <li class="active"><a href="{{ route('login') }}" class="pr-4 hover:font-bold focus:font-bold focus:hover:text-gray-600 active:text-red-600">Login</a></li>
            <li><a href="#" class="hover:font-bold focus:font-bold focus:hover:text-gray-600">Register</a></li>
        @endguest

        @auth
            <li><a href="#">Log out</a></li>
        @endauth
    </ul>
</div>