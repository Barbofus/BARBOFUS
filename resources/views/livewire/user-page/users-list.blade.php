<div>
    <div class="flex mt-10 mb-5 ml-24 items-end justify-between">
        
        {{-- La barre de recherche --}}
        <div class="relative" x-data="{srchBar: ''}" >
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            
            {{-- Le model query permet de lancer automatiquement la fonction updatedQuery() dans le Livewire concerné à chaque chagenement de value --}}
            <input 
                type="text"
                placeholder="Recherche un nom ou un email..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5"
                wire:model="query"
            >
        </div>
        
        {{-- Affiche le nombre d'utilisateurs inscrit sur le site --}}
        <p class="mr-[250px] text-lg text-gray-500">Vous avez <span class="font-bold">{{ App\Models\User::all()->count() }}</span> utilisateurs enregistrés</p>
    </div>

    {{-- Affichage des utilisateurs, géré grace aux variables AlpineJS --}}
    <div 
        class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative mb-10 mx-16 h-[600px]" 
        x-data="{
            userSortSelection: 'created_at',
            userSortType: false,
            deleteVerify: false  }">

        <table class="border-collapse table-fixed w-full whitespace-no-wrap bg-white table-striped relative">
            <tbody>
                
                {{-- Création des en-têtes du tableau --}}
                {{-- Chaque en-tête est cliquable, au clique, change la variable 'userSortSelection', --}}
                {{-- inverse l'ordre d'affichage (ASC ou DESC) avec la variable userSortType --}}
                {{-- puis enfin lance la fonction ChangeSort() dans le Livewire pour actualiser tout ça en temps réel --}}
                <tr>

                    {{-- En tête des 'ID' --}}
                    <th class="border-dashed border-r border-gray-200 hover:bg-slate-100 w-[75px] h-[50px]" >
                        <button class="pl-6 py-3 w-full h-full flex justify-start" x-on:click="userSortSelection = 'id', userSortType = !userSortType, $wire.ChangeSort(userSortType, userSortSelection)">Id
                            <svg x-show="userSortType && userSortSelection === 'id'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!userSortType && userSortSelection === 'id'"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button></th>


                    {{-- En tête des 'Pseudo' --}}
                    <th class="border-dashed border-r border-gray-200 hover:bg-slate-100 w-[250px]" >
                        <button class="pl-6 py-3  w-full h-full flex justify-start" x-on:click="userSortSelection = 'name', userSortType = !userSortType, $wire.ChangeSort(userSortType, userSortSelection)">Pseudo
                            <svg x-show="userSortType && userSortSelection === 'name'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!userSortType && userSortSelection === 'name'"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button></th>


                    {{-- En tête des 'Email' --}}
                    <th class="border-dashed border-r border-gray-200 hover:bg-slate-100 w-[300px]" >
                        <button class="pl-6 py-3  w-full h-full flex justify-start" x-on:click="userSortSelection = 'email', userSortType = !userSortType, $wire.ChangeSort(userSortType, userSortSelection)">Email
                            <svg x-show="userSortType && userSortSelection === 'email'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!userSortType && userSortSelection === 'email'"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button></th>


                    {{-- En tête des 'Dates de créations' --}}
                    <th class="border-dashed border-r border-gray-200 hover:bg-slate-100 w-[175px]" >
                        <button class="pl-6 py-3  w-full h-full flex justify-start" x-on:click="userSortSelection = 'created_at', userSortType = !userSortType, $wire.ChangeSort(userSortType, userSortSelection)">Date de création
                            <svg x-show="userSortType && userSortSelection === 'created_at'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!userSortType && userSortSelection === 'created_at'"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button></th>

                    {{-- En tête des 'Âges des comptes' --}}
                    <th class="border-dashed border-r border-gray-200 px-6 py-3 w-[175px]"><span class="flex justify-start">Age du compte</span></th>

                    {{-- En tête des 'Rôles' --}}
                    <th class="border-dashed border-r border-gray-200 hover:bg-slate-100 w-[150px]" >
                        <button class="pl-6 py-3  w-full h-full flex justify-start" x-on:click="userSortSelection = 'role_id', userSortType = !userSortType, $wire.ChangeSort(userSortType, userSortSelection)">Rôle
                            <svg x-show="userSortType && userSortSelection === 'role_id'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!userSortType && userSortSelection === 'role_id'"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button></th>


                    {{-- En tête des boutons de suppressions --}}
                    <th class="px-6 py-3 w-[100px]" ></th>
                </tr>

                {{-- Affiche chacun des users avec les informations des en-têtes --}}
                @foreach ($users as $user)
                    @if ($user != $currentUser) 
                        <tr>
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center" >{{ $user->id }}</span>
                            </td>
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center" >{{ $user->name }}</span>
                            </td>
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center">{{ $user->email }}</span>
                            </td>
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center">{{ $user->created_at->translatedFormat('j F Y') }}</span>
                            </td>
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center">{{ $usersUptime[$user->id] }}</span>
                            </td>
                            
                            {{-- Affichage des rôles --}}
                            <td class="border-dashed border-t border-r border-gray-200">
                                
                                {{-- Au changement du <select>, lance la fonction ChangeUserRole() du Livewire --}}
                                <select 
                                    x-ref="sel_{{ $user->id }}" 
                                    name="role_id" id="role_id" 
                                    x-on:change="$wire.ChangeUserRole({{ $user->id }}, $refs.sel_{{ $user->id }}.value)">

                                    {{-- Affiche chaque rôle dans le <select> et montre le rôle actuel de l'utilisateur de base --}}
                                    @foreach ($roles as $role)
                                        <option value="{{  $role->id }}" {{ $role->id === $user->role_id ? 'selected' : ''}}>{{  $role->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- Bouton de suppression de l'utilisateur --}}
                            <td class="border-dashed border-t border-r border-gray-200">
                                <span class="text-gray-700 px-6 py-3 flex items-center">
                                    
                                    {{-- Au clique, remplis la variable deleteVerify avec le nom du User, pour afficher le 'layouts.deleteVerify' --}}
                                    <button x-on:click="deleteVerify = '{{ $user->name }}'" class="px-1 py-1 bg-transparent outline-none border-2 border-red-400 rounded text-red-500 font-medium active:scale-95 hover:bg-red-600 hover:text-white hover:border-transparent transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                </span>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        
        {{-- S'affiche lors du clique d'un bouton de suppression d'un utilisateur --}}        
        @include('layouts.deleteVerify')

        
        {{-- S'affiche lorsque qu'on a une notification de succé --}}
        @if (session()->Has('success'))
            @section('alertMessage')
                {{session('success')}}
            @endsection

            @include('layouts.success-alert')
        @endif
    </div>
</div>