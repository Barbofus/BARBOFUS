<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s] pl-12">
        <x-utils.userpage-title :title="'Mon compte'" :subtitle="'Configurations et préférences'" />

        <div class="w-[80%] mx-auto flex flex-col gap-y-16">

            {{-- Informations --}}
            <div>
                <h2 class="font-thin text-4xl uppercase">Informations</h2>
                <div class="border-b border-secondary w-96 ml-4"></div>

                <div class="flex gap-x-8 mt-8 font-light text-xl items-center pl-36">
                    <div class="flex flex-col gap-y-4">
                        <p>Inscrit <span class="italic font-normal">{{ $user->created_at->diffForHumans() }}</span></p>
                        <p><span class="italic tracking-widest font-normal">{{ $user->skin_count }}</span> skins postés</p>
                        <p><span class="italic tracking-widest font-normal">{{ $user->like_given }}</span> likes donnés</p>
                        <p><span class="italic tracking-widest font-normal">{{ $user->like_received }}</span> likes reçus</p>
                    </div>

                    <div class="flex flex-col gap-y-4">
                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_ocre.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->ocre_wins }}</span> victoires</p>
                        </div>

                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_emeraude.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->emerald_wins }}</span> victoires</p>
                        </div>

                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_cawotte.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->cawotte_wins }}</span> victoires</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Préférences --}}
            <div>
                <h2 class="font-thin text-4xl uppercase">Préférences</h2>
                <div class="border-b border-secondary w-96 ml-4"></div>

                <h3 class="font-thin text-2xl uppercase mt-8 pl-12">Notifications</h3>

                <p class="font-light text-xl mt-6 mb-4 pl-24">Recevoir un e-mail pour:</p>

                <div class="flex gap-x-8">
                    <div class="relative w-72">
                        <x-forms.filter-button wire:click="togglePreference('mail_skin_validation', '{{ ($user->mail_skin_validation_preference !== 0) }}')" :checked="($user->mail_skin_validation_preference !== 0)"><p class="absolute italic font-thin text-secondary text-lg left-7 top-1 cursor-pointer">Validation / Refus d'un skin</p></x-forms.filter-button>
                    </div>

                    <div class="relative w-96">
                        <x-forms.filter-button wire:click="togglePreference('mail_skin_winner', '{{  $user->mail_skin_winner_preference !== 0 }}')" :checked="($user->mail_skin_winner_preference !== 0)"><p class="absolute italic font-thin text-secondary text-lg left-7 top-1 cursor-pointer">Victoire d'un Miss'SKin</p></x-forms.filter-button>
                    </div>
                </div>
            </div>

            {{-- Paramètres --}}
            <div>
                <h2 class="font-thin text-4xl uppercase">Paramètres</h2>
                <div class="border-b border-secondary w-96 ml-4"></div>
            </div>
        </div>
    </div>
</div>
