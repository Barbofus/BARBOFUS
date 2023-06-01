
<!-- Navbar -->
<nav id="navbar"
     class="fixed min-[901px]:sticky min-[901px]:z-30 z-40 top-0 min-[901px]:border-t-8 min-[901px]:border-secondary h-12 w-full tracking-tight text-[1.35rem] text-inactiveText font-thin
          [@media(max-height:700px)_and_(max-width:900px)]:bg-transparent bg-primary pb-[12px] min-[901px]:pt-2"
     x-data="{
            showNavbar: (window.innerWidth > 900),
            selectedClass: 'max-[900px]:border-y max-[900px]:border-secondary max-[900px]:flex max-[900px]:items-center max-[900px]:px-5 min-[901px]:pl-5 h-[18%] min-[901px]:h-[30px] text-secondary-100 font-light flex min-[901px]:after:ml-5 min-[901px]:after:-mt-1 min-[901px]:after:clip-path-triangle-down min-[901px]:after:block min-[901px]:after:h-[36px] min-[901px]:after:w-[80px] min-[901px]:after:bg-secondary focus:outline-none',
            unselectedClassLast: 'px-5 max-[900px]:flex max-[900px]:items-center h-[18%] min-[901px]:h-[30px] hover:text-secondary-100 focus:outline-none',
            unselectedClass: 'px-5 max-[900px]:flex max-[900px]:items-center h-[18%] min-[901px]:h-[30px] min-[901px]:border-r hover:text-secondary-100 border-r-inactiveText focus:outline-none',
          }"
     @resize.window="
            if(window.innerWidth > 900) showNavbar = true;">
    <template x-if="true">
        <div x-show="showNavbar" x-transition
             class="flex h-[max(100vh,250px)] w-screen max-[900px]:pb-2 min-[901px]:h-full min-[901px]:w-full items-center justify-center flex-col min-[901px]:flex-row bg-primary">

            <a href="{{ route('home') }}" :class="{{ (Route::is('home')) ? 'selectedClass' : 'unselectedClass' }}">Accueil</a>
            <a href="{{ route('skins.index') }}" :class="{{ (Route::is('skins.index')) ? 'selectedClass' : 'unselectedClass'  }}">Les Skins</a>

            @guest
                <a href="{{ route('login') }}" :class="{{ (Route::is('login')) ? 'selectedClass' : 'unselectedClass' }}">Se connecter</a>
                <a href="{{ route('register') }}" :class="{{ (Route::is('register')) ? 'selectedClass' : 'unselectedClassLast' }}">S'enregistrer</a>
            @endguest

            @auth()
                <a href="{{ route('skins.create') }}" :class="{{ (Route::is('skins.create')) ? 'selectedClass' : 'unselectedClass'  }}">Poster un Skin</a>
                <a href="{{ route('dashboarduserdetails.index') }}" :class="{{ (Route::is('dashboarduserdetails.index')) ? 'selectedClass' : 'unselectedClass'  }}">Mon Compte</a>
                <form method="POST" action="{{ route('logout') }}" class="max-[900px]:h-[18%] ">
                    @csrf
                    <button type="submit" class="px-5 max-[900px]:flex max-[900px]:items-center h-full min-[901px]:h-[30px] hover:text-secondary-100 focus:outline-none">Se déconnecter</button>
                </form>
            @endauth
        </div>
    </template>

    <!-- Croix -->
    <svg x-show="showNavbar" x-transition
         @click="showNavbar = !showNavbar"
         class="visible min-[901px]:invisible fixed w-10 cursor-pointer top-2 right-2 text-secondary"
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>

    <!-- Hamburger -->
    <svg x-show="!showNavbar" x-transition
         @click="showNavbar = !showNavbar"
         class="visible min-[901px]:invisible fixed w-10 cursor-pointer top-2 right-2 text-secondary"
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
</nav>
