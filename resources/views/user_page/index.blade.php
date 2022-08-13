@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur ton espace compte !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <div class="flex justify-center mt-10">
        <div class="w-[80%] flex border rounded-xl overflow-hidden bg-slate-50" x-data="{ selection: 'userPageDetails', 
        initButtonClass: 'border-b border-slate-300 h-[50px] text-left text-xl w-full pl-6 bg-slate-200 hover:bg-slate-100',
        selectedButtonClass: 'border-b border-slate-300 h-[50px] text-left text-xl w-full pl-6 bg-slate-50'}">

            <div class="w-[350px] ">
                <button x-on:click="selection = 'userPageDetails'" 
                :class="selection === 'userPageDetails' ? selectedButtonClass : initButtonClass">Détails du compte</button>
                
                <button x-on:click="selection = 'userPageSkins'" 
                :class="selection === 'userPageSkins' ? selectedButtonClass : initButtonClass">Mes Skins</button>
                
                <button x-on:click="selection = 'userPageLikes'" 
                :class="selection === 'userPageLikes' ? selectedButtonClass : initButtonClass">Mes Likes</button>

                @canany(['mod-access', 'admin-access'])
                    <button x-on:click="selection = 'userPagePendginSkins'" 
                    :class="selection === 'userPagePendginSkins' ? selectedButtonClass : initButtonClass">Skins en attente</button>
                @endcanany

                @can('admin-access')
                    <button x-on:click="selection = 'userPageBuilds'" 
                    :class="selection === 'userPageBuilds' ? selectedButtonClass : initButtonClass">Mes Builds</button>
                    
                    <button x-on:click="selection = 'userPageUsers'" 
                    :class="selection === 'userPageUsers' ? selectedButtonClass : initButtonClass">Liste des utilisateurs</button>
                @endcan

                <div class="h-full border-r border-slate-300"></div>
            </div>
            
            <div class="w-full min-h-[350px]">

                {{-- Contenu de l'onglet "Détails du compte" --}}
                @include('user_page.includes.userPageDetails')

                {{-- Contenu de l'onglet "Mes Skins" --}}
                @include('user_page.includes.userPageSkins')

                {{-- Contenu de l'onglet "Mes Likes" --}}
                @include('user_page.includes.userPageLikes')

                @canany(['mod-access', 'admin-access'])
                    {{-- Contenu de l'onglet "Skins en attente" --}}
                    @include('user_page.includes.userPagePendginSkins')
                @endcanany
                
                @can('admin-access')
                    {{-- Contenu de l'onglet "Mes builds" --}}
                    @include('user_page.includes.userPageBuilds')

                    
                    {{-- Contenu de l'onglet "Liste des utilisateurs" --}}
                    @include('user_page.includes.userPageUsers')
                @endcan
            </div>

        </div>
    </div>

@endsection