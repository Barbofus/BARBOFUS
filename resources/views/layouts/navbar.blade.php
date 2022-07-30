<div class="text-2xl justify-center pl-5 pt-2 pb-3 border-b">
    <ul class="flex">
        <li class="{{ Route::is('index') ? "active" : "" }}"><a href="{{ route('index') }}" class="pr-4 hover:font-bold">Accueil</a></li>
        <li class="{{ Route::is('about') ? "active" : "" }}"><a href="{{ route('about') }}" class=" pr-4 hover:font-bold">About</a></li>

        @guest
            <li class="{{ Route::is('login') ? "active" : "" }}"><a href="{{ route('login') }}" class="pr-4 hover:font-bold">Login</a></li>
            <li><a href="#" class="hover:font-bold">Register</a></li>
        @endguest

        <style>
            li.active{
                font-weight : bold;
            }
            
            li.active:hover{
                color : #5e5e5e;
            }
        </style>

        @auth
            <li><a href="#">Log out</a></li>
        @endauth
    </ul>
</div>