<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s] min-[800px]:pl-12">
        <x-utils.userpage-title :title="'Mon compte'" :subtitle="'Configurations et préférences'" />

        <div class="w-[80%] min-[800px]:mx-auto flex flex-col min-[1500px]:flex-row gap-x-16 gap-y-16">

            <div class="flex flex-col gap-y-12">
                {{-- Informations --}}
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl uppercase">Informations</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    <h2 class="font-light italic text-2xl mt-4 min-[800px]:pl-60">{{ $user->name }}</h2>

                    <div class="flex flex-col min-[800px]:flex-row gap-y-8 gap-x-8 mt-8 font-light text-xl items-start min-[800px]:items-center min-[800px]:pl-36">
                        <div class="flex flex-col gap-y-4">
                            <p>Inscrit <span class="italic font-normal">{{ $user->created_at->diffForHumans() }}</span></p>
                            <p><span class="italic tracking-widest font-normal">{{ $user->skin_count + $user->unity_skin_count }}</span> skins postés</p>
                            <p><span class="italic tracking-widest font-normal">{{ $user->like_given + $user->unity_like_given }}</span> likes donnés</p>
                            <p><span class="italic tracking-widest font-normal">{{ $user->like_received + $user->unity_like_received }}</span> likes reçus</p>
                            @canany(['mod-access', 'admin-access'])
                                <p><span class="italic tracking-widest font-normal">{{ \App\Models\Skin::all()->count() + \App\Models\UnitySkin::all()->count() }}</span> skins total sur le site</p>
                            @endcan
                        </div>

                        <div class="flex flex-col gap-y-4">
                            <div class="flex gap-x-4 items-center">
                                <img src="{{ asset('storage/images/misc_ui/dofus_ocre.webp') }}" class="h-12">
                                <p><span class="italic tracking-widest font-normal">{{ $user->ocre_wins + $user->unity_ocre_wins }}</span> victoires</p>
                            </div>

                            <div class="flex gap-x-4 items-center">
                                <img src="{{ asset('storage/images/misc_ui/dofus_emeraude.webp') }}" class="h-12">
                                <p><span class="italic tracking-widest font-normal">{{ $user->emerald_wins + $user->unity_emerald_wins }}</span> victoires</p>
                            </div>

                            <div class="flex gap-x-4 items-center">
                                <img src="{{ asset('storage/images/misc_ui/dofus_cawotte.webp') }}" class="h-12">
                                <p><span class="italic tracking-widest font-normal">{{ $user->cawotte_wins + $user->unity_cawotte_wins }}</span> victoires</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Préférences --}}
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Préférences</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    <h3 class="font-thin text-xl uppercase mt-6 pl-12">Recevoir un e-mail pour:</h3>

                    <div class="flex flex-col gap-y-6 pt-6 pl-4">
                        <div class="relative w-[min(17rem,80%)]">
                            <x-forms.filter-button
                                :name="'skin-validation'"
                                wire:click="togglePreference('mail_skin_validation', '{{ ($user->mail_skin_validation_preference !== 0) }}')"
                                :checked="!(isset($user->mail_skin_validation_preference) ? $user->mail_skin_validation_preference : 1)">
                                <p class="absolute italic font-thin text-secondary text-lg left-7 top-1 cursor-pointer">Validation / Refus d'un skin</p>
                            </x-forms.filter-button>
                        </div>
                    </div>
                </div>

                {{-- Connections --}}
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Connexions</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    {{-- Bouton pour link son discord --}}
                    @if(!isset($discord))
                        <button wire:click="DiscordConnectionUrl" class="px-4 py-2 ml-8 mt-4 flex items-center bg-[#5865f2] gap-x-4 rounded-md hover:brightness-[1.2] transition-all w-fit group">
                            <img src="{{ asset('storage/images/misc_ui/logo_discord_white.png') }}" class="h-12">
                            <p class="font-thin text-xl text-white group-hover:-translate-y-1 transition-all">Connecte ton discord</p>
                        </button>
                    @else
                        <div class="flex gap-x-4 items-center">
                            <x-utils.discord-card :$discord />

                            <button class="pt-4" wire:click="DisconnectDiscord">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 hover:scale-125 text-inactiveText hover:text-red-500 transition-all">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Paramètres --}}
            <div>
                <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Paramètres</h2>
                <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                <h3 class="font-thin text-2xl uppercase mt-8 pl-12">Changer de mot de passe</h3>

                <form wire:submit.prevent="ChangeUserPassword" class="flex flex-col gap-y-4 mt-4 pl-4">

                    {{-- Old Password --}}
                    <x-forms.text-input autocomplete="false" wire:model="current_password" :placeholder="'Ancien Mot de passe'" :type="'password'" :name="'current_password'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </x-forms.text-input>

                    {{-- New Password --}}
                    <x-forms.text-input autocomplete="false" wire:model="password" :placeholder="'Nouveau Mot de passe'" :type="'password'" :name="'password'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </x-forms.text-input>

                    {{-- Password Confirmation --}}
                    <x-forms.text-input autocomplete="false" wire:model="password_confirmation" :placeholder="'Confirmation'" :type="'password'" :name="'password_confirmation'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </x-forms.text-input>

                    <x-forms.submit>Enregistrer</x-forms.submit>
                </form>

                <h3 class="font-thin text-2xl uppercase pl-12">Changer de pseudo</h3>

                {{-- Pseudo --}}
                <form wire:submit.prevent="ChangeUsername" class="flex flex-col gap-y-4 mt-4 pl-4">
                    <x-forms.text-input autocomplete="true" wire:model="name" :placeholder="'Nouveau Pseudo'" :type="'text'" :name="'name'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </x-forms.text-input>

                    <x-forms.submit>Enregistrer</x-forms.submit>
                </form>

                <h3 class="font-thin text-2xl uppercase pl-12">Changer d'adresse e-mail</h3>

                <p class="font-light text-lg mt-2 mb-4 italic text-secondary pl-8 indent-12">(Attention! Vous serez déconnecté et devrez valider l'E-mail)</p>

                {{-- Email --}}
                <form wire:submit.prevent="ChangeUserEMail" class="flex flex-col gap-y-4 mt-4 pl-4">
                    <x-forms.text-input autocomplete="true" wire:model="email" :placeholder="'Nouveau E-mail'" :type="'email'" :name="'email'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </x-forms.text-input>

                    <x-forms.submit>Enregistrer</x-forms.submit>
                </form>
            </div>
        </div>
    </div>
</div>
