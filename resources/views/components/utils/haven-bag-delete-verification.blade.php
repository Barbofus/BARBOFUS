<div class="fixed top-0 right-0 bottom-0 left-0 z-[999] bg-black/40 flex justify-center items-center">
    <div class="w-[min(65rem,90vw)] rounded-md bg-primary-100 shadow-lg flex flex-col items-center justify-center gap-y-8 p-8"
         x-on:click.away="havenBagDeleteID = null">

        <img :src="havenBagDeleteImg" draggable="false" class="rounded-xl">

        <div>
            <p class="text-2xl text-secondary font-light text-center italic">{{ __('barbofus.descriptionDeleteHSVerif') }}</p>
            <p class="text-inactiveText italic text-md text-center">{{ __('barbofus.descriptionOperationIrreversible') }}</p>
        </div>

        <div class="flex justify-center space-x-10 w-full">
            <button x-on:click="havenBagDeleteID = null" class="uppercase text-sm min-[400px]:text-xl text-goldText border-goldText border-2 hover:rounded-3xl transition-all hover:tracking-widest px-4 py-2 rounded-md">{{ __('barbofus.buttonCancel') }}</button>

            <button x-on:click="$wire.deleteHavenBag(havenBagDeleteID), havenBagDeleteID = null" class="uppercase text-sm min-[400px]:text-xl text-primary px-4 py-2 rounded-md goldGradient hover:rounded-3xl transition-all hover:tracking-widest">{{ __('barbofus.buttonDelete') }}</button>
        </div>
    </div>
</div>
