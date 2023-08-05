<div class="fixed top-0 right-0 bottom-0 left-0 z-[999] bg-black/40 flex justify-center items-center">
    <div class="w-96 rounded-md bg-primary-100 shadow-lg flex flex-col items-center justify-center gap-y-8 p-8"
         @click.away="skinDeleteID = null">

        
        <img :src="skinDeleteImg" draggable="false" class="w-[12.5rem]">

        <div>
            <p class="text-2xl text-secondary font-light text-center italic">Es-tu sûr de vouloir supprimer le skin <span class="pl-2 font-normal not-italic">ID#<span x-text="skinDeleteID"></span></span></p>
            <p class="text-inactiveText italic text-md text-center">Cette opération est irréversible.</p>
        </div>

        <div class="flex justify-between w-full">
            <button @click="skinDeleteID = null" class="uppercase text-xl text-goldText border-goldText border-2 hover:rounded-3xl transition-all hover:tracking-widest px-4 py-2 rounded-md">Annuler</button>
            <button @click="$wire.deleteSkin(skinDeleteID), skinDeleteID = null" class="uppercase text-xl text-primary px-4 py-2 rounded-md goldGradient hover:rounded-3xl transition-all hover:tracking-widest">Supprimer</button>
        </div>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/utils/skin-delete-verification.blade.php ENDPATH**/ ?>