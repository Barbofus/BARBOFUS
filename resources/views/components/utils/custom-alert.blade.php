<div class="fixed z-50 bottom-4 right-4 px-8 py-4 bg-green-100 border-l-4 border-green-700 text-green-700 text-xl max-w-[90vw] min-[1100px]:max-w-[30vw]" x-show="showAlert" x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-48"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-out duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 translate-y-48">

    <p class="font-normal text-2xl">Succé !</p>
    <p x-text="alertMessage" class="font-light"></p>

    <button class="absolute top-2 right-2" @click="closeAlert()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 hover:scale-125 transition-all">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
