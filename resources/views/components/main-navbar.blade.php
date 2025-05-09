
<!-- Navbar -->
<nav id="navbar"
     class="fixed min-[1251px]:sticky min-[1251px]:z-40 z-40 top-0 min-[1251px]:border-t-8 min-[1251px]:border-secondary h-12 w-full tracking-tight text-[1.35rem] text-inactiveText font-thin bg-primary pb-[0.75rem] min-[1251px]:pt-2"
     x-data="{
            title: {
                'skins.index': 'Skins',
                'skins.show': 'Skins',
                'unity-skins.index': 'Skins UNITY',
                'unity-skins.show': 'Skins UNITY',
                'havre-sacs.index': 'Havre-sacs',
                'tools': 'Barb\'Outils',
            },
            showNavbar: (window.innerWidth > 1200),
            selectedClass: 'max-[1250px]:border-y max-[1250px]:border-secondary max-[1250px]:flex max-[1250px]:items-center max-[1250px]:px-5 min-[1251px]:pl-5 h-[12%] min-[1251px]:h-[2rem] text-secondary-100 font-light flex min-[1251px]:after:ml-5 min-[1251px]:after:-mt-1 min-[1251px]:after:clip-path-triangle-down min-[1251px]:after:block min-[1251px]:after:h-[2.25rem] min-[1251px]:after:w-[5rem] min-[1251px]:after:bg-secondary focus:outline-none',
            unselectedClass: 'px-5 transition-all max-[1250px]:flex max-[1250px]:items-center h-[12%] min-[1251px]:h-[2rem] min-[1251px]:border-r hover:text-secondary-100 border-r-inactiveText focus:outline-none',
            unselectedClassLast: 'px-5 transition-all max-[1250px]:flex max-[1250px]:items-center h-[12%] min-[1251px]:h-[2rem] hover:text-secondary-100 focus:outline-none',
          }"
     @resize.window="
            showNavbar = (window.innerWidth > 1250);">
    <template x-if="true">
        <div x-show="showNavbar" x-transition
             class="flex h-[max(100vh,15.625rem)] w-screen max-[1250px]:pb-2 min-[1251px]:h-full min-[1251px]:w-full items-center justify-center flex-col min-[1251px]:flex-row bg-primary">

            <a href="{{ route('home') }}" title="Accueil Barbofus" :class="{{ (Route::is('home')) ? 'selectedClass' : 'unselectedClass' }}">⭐{{ __('barbofus.buttonHome') }}</a>
            <a href="{{ route('unity-skins.index') }}" title="Galleri de skins" class="relative" :class="{{ (Route::is('unity-skins.index', 'unity-skins.show')) ? 'selectedClass' : 'unselectedClass'  }}">🎨{{ __('barbofus.buttonSkins') }}</a>

            @guest
                <a href="{{ route('havre-sacs.index') }}" title="Galleri de havre-sacs" :class="{{ (Route::is('havre-sacs.index')) ? 'selectedClass' : 'unselectedClass' }}">🏠{{ __('barbofus.buttonHavenbags') }}</a>
                <a href="{{ route('tools') }}" title="Outils" :class="{{ (Route::is('tools')) ? 'selectedClass' : 'unselectedClass'  }}">🔧{{ __('barbofus.buttonTools') }}</a>
                <a href="{{ route('login') }}" title="Page de connexion" :class="{{ (Route::is('login')) ? 'selectedClass' : 'unselectedClass' }}">🔑{{ __('barbofus.buttonLogin') }}</a>
                <a href="{{ route('register') }}" title="Formulaire d'inscription" :class="{{ (Route::is('register')) ? 'selectedClass' : 'unselectedClassLast' }}">📝{{ __('barbofus.buttonRegister') }}</a>
            @endguest

            @auth()
                @if (Gate::check('mod-access') || Gate::check('admin-access'))
                    <a href="{{ route('skinator.create') }}" title="Partage de skin" :class="{{ (str_starts_with(Route::currentRouteName(),'skinator')) ? 'selectedClass' : 'unselectedClass'  }}">🚀Skinator</a>
                @else
                    <a href="{{ route('unity-skins.create') }}" title="Partage de skin" :class="{{ (Route::is('skins.create')) ? 'selectedClass' : 'unselectedClass'  }}">🚀{{ __('barbofus.buttonSkinPost') }}</a>
                @endif
                <a href="{{ route('havre-sacs.index') }}" title="Galleri de havre-sacs" :class="{{ (Route::is('havre-sacs.index')) ? 'selectedClass' : 'unselectedClass' }}">🏠{{ __('barbofus.buttonHavenbags') }}</a>
                <a href="{{ route('tools') }}" title="Outils" :class="{{ (Route::is('tools')) ? 'selectedClass' : 'unselectedClass'  }}">🔧{{ __('barbofus.buttonTools') }}</a>
                <a href="{{ route('user-dashboard.index') }}" title="Espace mon compte" :class="{{ (Route::is('user-dashboard.index')) ? 'selectedClass' : 'unselectedClass'  }}">⚙️{{ __('barbofus.buttonDashboard') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="max-[900px]:h-[18%] ">
                    @csrf
                    <button type="submit" class="px-5 max-[1200px]:flex max-[1200px]:items-center h-full min-[1201px]:h-[2rem] hover:text-secondary-100 focus:outline-none">🚪{{ __('barbofus.buttonLogout') }}</button>
                </form>
            @endauth
        </div>
    </template>

    <!-- Croix -->
    <button x-show="showNavbar" x-transition
            aria-label="Fermeture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-10 z-50 w-10 visible min-[1251px]:invisible fixed top-2 right-2 text-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Hamburger -->
    <button x-show="!showNavbar" x-transition
            aria-label="Ouverture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-10 w-10 visible min-[1251px]:invisible fixed top-2 right-2 text-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- Header --}}
    <div x-show="!showNavbar" x-transition
            aria-label="Ouverture du menu de navigation"
            @click="showNavbar = !showNavbar"
            class="h-12 visible min-[1251px]:invisible fixed top-0 left-2 text-secondary flex">
        <a href="{{ route('home') }}" title="Accueil Barbofus"><img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.webp') }}" loading="lazy" height="48" alt="Logo Barbofus" class="h-full" draggable="false" /></a>

        @if(Route::is('skins.index', 'skins.show', 'unity-skins.index', 'unity-skins.show', 'havre-sacs.index'))
            <p class="pt-2 p-10 font-medium italic" x-text="title['{{ Route::currentRouteName() }}']"/>
        @endif
    </div>
</nav>
