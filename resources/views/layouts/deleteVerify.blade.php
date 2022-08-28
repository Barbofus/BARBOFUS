<div x-show="deleteVerify" x-cloak>
    <div class=" fixed bg-black opacity-75 h-full w-full top-0 left-0"></div>
    <div class="h-[250px] w-[600px] px-2 flex items-center fixed bottom-[35%] right-[40%] bg-red-600 text-xl text-red-100 border-r-[16px] border-red-700" x-on:click.outside="deleteVerify = false">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div class="pl-10">
            <span class="text-3xl">Es-tu sûr de vouloir supprimer <span x-text="deleteVerify"></span> ?</span>
            <div class="mt-10 flex justify-between">
                <button x-on:click="$wire.ToDelete(deleteVerify), deleteVerify = false" class="ml-8 h-[50px] w-[150px] bg-green-600 text-2xl text-green-100 border-r-[16px] border-green-700 hover:bg-green-700 hover:border-green-800 hover:font-bold">Supprimer</button>
                <button x-on:click="deleteVerify = false" class="mr-8 h-[50px] w-[150px] bg-blue-600 text-2xl text-blue-100 border-r-[16px] border-blue-700 hover:bg-blue-700 hover:border-blue-800 hover:font-bold">Annuler</button>
            </div>
        </div>
    </div>
</div>