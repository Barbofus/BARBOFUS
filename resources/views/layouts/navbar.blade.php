<ul class="flex justify-between text-2xl border-b h-[50px]">
    <div class="flex ml-[15%] h-full items-center pb-1">
        <li class="{{ Route::is('home') ? "active" : "" }}"><a href="{{ route('home') }}" class="pr-4 hover:font-bold">Accueil</a></li>
        <li class="{{ Route::is('skins.index') ? "active" : "" }}"><a href="{{ route('skins.index') }}" class="pr-4 hover:font-bold">Les skins</a></li>
        {{-- <li class="{{ Route::is('builds.index') ? "active" : "" }}"><a href="{{ route('builds.index') }}" class="pr-4 hover:font-bold">Les builds</a></li> --}}
    </div>

    <div class="flex mr-[5%] h-full items-center pb-1">
        @guest
            <li class="{{ Route::is('login') ? "active" : "" }}"><a href="{{ route('login') }}" class="pr-4 hover:font-bold">Se connecter</a></li>
            <li class="{{ Route::is('register') ? "active" : "" }}"><a href="{{ route('register') }}" class="hover:font-bold">S'enregistrer</a></li>
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
            @canany(['mod-access', 'admin-access'])
                <li><a href="#" class="pr-4 hover:font-bold">Skin en attente</a></li>
            @endcanany

            <li class="{{ Route::is('skins.create') ? "active" : "" }}"><a href="{{ route('skins.create') }}" class="pr-4 hover:font-bold">Poster un skin</a></li>
            <li class="{{ (Route::is('dashboarduserdetails.index') || Route::is('adminpanel')) ? "active" : "" }}"><a href="{{ route('dashboarduserdetails.index') }}" class="pr-4 hover:font-bold">Mon compte</a></li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:font-bold">Se déconnecter</button>
            </form>
        @endauth
    </div>
</ul>
