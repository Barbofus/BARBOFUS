
<!-- Navbar -->
<nav id="navbar"
     class="fixed min-[1201px]:sticky min-[1201px]:z-40 z-40 top-0 min-[1201px]:border-t-8 min-[1201px]:border-secondary h-12 w-full tracking-tight text-[1.35rem] text-inactiveText font-thin bg-primary pb-[0.75rem] min-[1201px]:pt-2"
     x-data="{
            title: {
                'skins.index': 'Skins',
                'skins.show': 'Skins',
                'unity-skins.index': 'Skins UNITY',
                'unity-skins.show': 'Skins UNITY',
                'havre-sacs.index': 'Havre-sacs',
            },
            showNavbar: (window.innerWidth > 1200),
            selectedClass: 'max-[1200px]:border-y max-[1200px]:border-secondary max-[1200px]:flex max-[1200px]:items-center max-[1200px]:px-5 min-[1201px]:pl-5 h-[12%] min-[1201px]:h-[2rem] text-secondary-100 font-light flex min-[1201px]:after:ml-5 min-[1201px]:after:-mt-1 min-[1201px]:after:clip-path-triangle-down min-[1201px]:after:block min-[1201px]:after:h-[2.25rem] min-[1201px]:after:w-[5rem] min-[1201px]:after:bg-secondary focus:outline-none',
            unselectedClass: 'px-5 transition-all max-[1200px]:flex max-[1200px]:items-center h-[12%] min-[1201px]:h-[2rem] min-[1201px]:border-r hover:text-secondary-100 border-r-inactiveText focus:outline-none',
            unselectedClassLast: 'px-5 transition-all max-[1200px]:flex max-[1200px]:items-center h-[12%] min-[1201px]:h-[2rem] hover:text-secondary-100 focus:outline-none',
          }"
     @resize.window="
            showNavbar = (window.innerWidth > 1200);">
    <template x-if="true">
        <div x-show="showNavbar" x-transition
             class="flex h-[max(100vh,15.625rem)] w-screen max-[1200px]:pb-2 min-[1201px]:h-full min-[1201px]:w-full items-center justify-center flex-col min-[1201px]:flex-row bg-primary">

            <a href="{{ route('home') }}" title="Accueil Barbofus" :class="{{ (Route::is('home')) ? 'selectedClass' : 'unselectedClass' }}">Accueil</a>
            <a href="{{ route('skins.index') }}" title="Galleri de skins" :class="{{ (Route::is('skins.index', 'skins.show')) ? 'selectedClass' : 'unselectedClass'  }}">Skins 2.0</a>
            <a href="{{ route('unity-skins.index') }}" title="Galleri de skins" class="relative" :class="{{ (Route::is('unity-skins.index', 'unity-skins.show')) ? 'selectedClass' : 'unselectedClass'  }}">Skins UNITY <p class="absolute text-red-500 font-medium text-md rotate-[20deg] left-24 -top-3">BÊTA</p></a>

            @guest
                <a href="{{ route('havre-sacs.index') }}" title="Galleri de havre-sacs" :class="{{ (Route::is('havre-sacs.index')) ? 'selectedClass' : 'unselectedClass' }}">Havre-Sacs</a>
                <a href="{{ route('login') }}" title="Page de connexion" :class="{{ (Route::is('login')) ? 'selectedClass' : 'unselectedClass' }}">Se connecter</a>
                <a href="{{ route('register') }}" title="Formulaire d'inscription" :class="{{ (Route::is('register')) ? 'selectedClass' : 'unselectedClassLast' }}">S'enregistrer</a>
            @endguest

            @auth()
                <a href="{{ route('skins.create') }}" title="Partage de skin" :class="{{ (Route::is('skins.create')) ? 'selectedClass' : 'unselectedClass'  }}">Poster un Skin</a>
                <a href="{{ route('havre-sacs.index') }}" title="Galleri de havre-sacs" :class="{{ (Route::is('havre-sacs.index')) ? 'selectedClass' : 'unselectedClass' }}">Havre-Sacs</a>
                <a href="{{ route('user-dashboard.index') }}" title="Espace mon compte" :class="{{ (Route::is('user-dashboard.index')) ? 'selectedClass' : 'unselectedClass'  }}">Mon Compte</a>
                <form method="POST" action="{{ route('logout') }}" class="max-[900px]:h-[18%] ">
                    @csrf
                    <button type="submit" class="px-5 max-[1200px]:flex max-[1200px]:items-center h-full min-[1201px]:h-[2rem] hover:text-secondary-100 focus:outline-none">Se déconnecter</button>
                </form>
            @endauth
        </div>
    </template>

    <!-- Croix -->
    <button x-show="showNavbar" x-transition
            aria-label="Fermeture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-10 z-50 w-10 visible min-[1201px]:invisible fixed top-2 right-2 text-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Hamburger -->
    <button x-show="!showNavbar" x-transition
            aria-label="Ouverture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-10 w-10 visible min-[1201px]:invisible fixed top-2 right-2 text-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- Header --}}
    <div x-show="!showNavbar" x-transition
            aria-label="Ouverture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-12 visible min-[1201px]:invisible fixed top-0 left-2 text-secondary flex">
        <a href="{{ route('home') }}" title="Accueil Barbofus"><img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.webp') }}" loading="lazy" height="48" alt="Logo Barbofus" class="h-full" draggable="false" /></a>

        @if(Route::is('skins.index', 'skins.show', 'unity-skins.index', 'unity-skins.show', 'havre-sacs.index'))
            <p class="pt-2 p-10 font-medium italic" x-text="title['{{ Route::currentRouteName() }}']"/>
        @endif
    </div>
</nav>
