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
                        <p><span class="italic tracking-widest font-normal">{{ $user->skin_count }}</span> likes reçus</p>
                    </div>

                    <div class="flex flex-col gap-y-4">
                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_ocre.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->skin_count }}</span> victoires</p>
                        </div>

                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_emeraude.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->skin_count }}</span> victoires</p>
                        </div>

                        <div class="flex gap-x-4 items-center">
                            <img src="{{ asset('storage/images/misc_ui/dofus_cawotte.png') }}" class="h-12">
                            <p><span class="italic tracking-widest font-normal">{{ $user->skin_count }}</span> victoires</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Préférences --}}
            <div>
                <h2 class="font-thin text-4xl uppercase">Préférences</h2>
                <div class="border-b border-secondary w-96 ml-4"></div>
            </div>

            {{-- Paramètres --}}
            <div>
                <h2 class="font-thin text-4xl uppercase">Paramètres</h2>
                <div class="border-b border-secondary w-96 ml-4"></div>
            </div>
        </div>
    </div>
</div>
