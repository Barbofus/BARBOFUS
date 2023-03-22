<div>
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur ton espace compte !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="flex justify-center mt-10 mb-10">

        {{-- Création de variable de class pour éviter les copier coller avec AlpineJS --}}
        <div
            class="w-[80%] flex border rounded-xl overflow-hidden bg-slate-50"
            x-data="{
                initButtonClass: 'border-b border-slate-300 h-[50px] flex items-center text-left text-xl w-full pl-6 bg-slate-200 hover:bg-slate-100 [&.active]:bg-slate-50'
            }">

            {{-- Pseudo navbar pour afficher tel ou tel onglet, 100% AlpineJS --}}
            <div class="w-[350px] border-r flex-col flex">
                <a  href="{{ route('dashboarduserdetails.index') }}" class="{{ Route::is('dashboarduserdetails.index') ? 'active' : ''}}"
                    :class="initButtonClass">Détails du compte</a>

                <a href="#" :class="initButtonClass">Mes Skins</a>

                <a href="#" :class="initButtonClass">Mes Likes</a>

                {{-- Onglet visible uniquement par les modérateurs et les admins --}}
                @canany(['mod-access', 'admin-access'])
                    <a href="#" :class="initButtonClass">Skins en attente</a>
                @endcanany

                {{-- Onglet visible uniquement par les admins --}}
                @can('admin-access')
                    <a href="#" :class="initButtonClass">Liste des utilisateurs</a>

                    <a  href="{{ route('adminpanel') }}" class="{{ Route::is('adminpanel') ? 'active' : ''}}"
                        :class="initButtonClass">Panel Administrateur</a>
                @endcan
            </div>

            <div class="w-full min-h-[350px]">

                {{ $slot }}

            </div>
        </div>
    </div>
</div>
