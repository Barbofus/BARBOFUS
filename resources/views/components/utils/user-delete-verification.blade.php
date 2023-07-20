<div class="fixed top-0 right-0 bottom-0 left-0 z-[999] bg-black/40 flex justify-center items-center">
    <div class="w-96 rounded-md bg-primary-100 shadow-lg flex flex-col items-center justify-center gap-y-8 p-8"
         @click.away="deleteID = null">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-1/2">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
        </svg>


        <div>
            <p class="text-2xl text-secondary font-light text-center italic">Es-tu sûr de vouloir supprimer <span class="pl-2 font-normal not-italic" x-text="deleteUserName"></span> ainsi que tous ses skins / likes ?</p>
            <p class="text-inactiveText italic text-md text-center">Cette opération est irréversible.</p>
        </div>

        <div class="flex justify-between w-full">
            <button @click="deleteID = null" class="uppercase text-xl text-goldText border-goldText border-2 hover:rounded-3xl transition-all hover:tracking-widest px-4 py-2 rounded-md">Annuler</button>
            <button @click="$wire.deleteUser(deleteID), deleteID = null" class="uppercase text-xl text-primary px-4 py-2 rounded-md goldGradient hover:rounded-3xl transition-all hover:tracking-widest">Supprimer</button>
        </div>
    </div>
</div>
