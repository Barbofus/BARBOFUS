<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <x-utils.userpage-title :title="'Utilisateurs'" :subtitle="'Choix des rôles / ban'" />


        <div class="w-1/2 mx-auto">
            <div class="flex gap-x-8 mb-8 items-center">
                <input type="text"
                       class="py-2 pl-4 focus:outline-none rounded-3xl w-1/2 bg-primary-100 px-4 font-light text-xl placeholder:text-inactiveText text-secondary"
                       maxlength="45"
                       placeholder="Recherche un pseudo"
                       wire:model.debounce.500ms="query">

                <p class="text-lg text-secondary font-light italic py-2">{{ count($users) }} utilisateurs trouvés</p>
            </div>

            <table class="text-secondary table-auto text-left w-full">
                <thead class="flex w-full mb-8">
                    <tr class="flex justify-between pl-[10%] pr-[20%] py-2 w-full border-b border-secondary">
                        <th class="text-2xl font-normal">Pseudo</th>
                        <th class="text-2xl font-normal">Rôle</th>
                    </tr>
                </thead>
                <tbody class="flex flex-col overflow-y-scroll w-full h-[45vh]">
                    @foreach($users as $user)
                        <tr class="odd:bg-primary-100 flex justify-between items-center px-12 py-4">
                            <td class="font-light text-xl">{{ $user->name }}</td>
                            <td>
                                <div x-data="{ showRoles: false, }" class="relative w-[200px]"
                                     x-on:mousedown.outside="if(showRoles) showRoles = false">

                                    <!-- Trier par: Texte -->
                                    <button @click="showRoles = !showRoles" class="font-normal px-4 py-2 w-full text-primary text-center rounded-full text-lg {{ ($user->role_id == 1) ? 'cawotteGradient' : (($user->role_id == 2) ? 'emeraldGradient' : 'goldGradient') }} cursor-pointer hover:brightness-110 hover:tracking-wider transition-all">{{ $user->role_name }}</button>

                                    <!-- Menu déroulant -->
                                    <div class="w-full h-screen top-16 left-0 rounded-md z-50 absolute bg-primary p-4 flex flex-col gap-y-2"
                                         x-show="showRoles"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 -translate-y-48"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-out duration-300"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0 -translate-y-48">
                                        @foreach($roles as $role)
                                            <button class="font-normal px-4 py-2 w-full text-primary text-center rounded-full text-lg {{ ($role->id == 1) ? 'cawotteGradient' : (($role->id == 2) ? 'emeraldGradient' : 'goldGradient') }} hover:bg-inactiveText cursor-pointer hover:brightness-110 hover:tracking-wider transition-all" @click="showRoles = false" wire:click="ChangeRole({{$user->id}}, {{ $role->id }})">
                                                {{ $role->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
