<div x-data="{
    oldSkinsCount: 0,
    loading: false,

    LoadMore()
    {
        this.loading = true;
        $wire.LoadMore();
    }
}">

    {{-- La grille des skins --}}
    <div class="flex justify-center">
        <div class="grid grid-cols-[repeat(auto-fill,200px)] p-4 gap-4 max-w-[1400px] justify-center">

            @foreach($skins as $skin)
                <div class="animate-skinApparition">
                    <p>{{ $skin->id }}</p>
                    <img src="{{ asset('storage\/') . $skin->image_path }}">
                    <p>{{ $skin->User->name }}</p>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Loader --}}
    <div class="flex justify-center h-16 my-8">

        <div role="status" x-show="loading" x-transition.opacity x-transition.duration.150ms>
            <svg aria-hidden="true" class="w-16 h-16 mb-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Chargement...</span>
        </div>

    </div>

    {{-- Bouton Charger plus ... --}}
    <div class="p-4 flex flex-col items-center">
        <button class="py-4 px-8 rounded-md bg-red-800 mt-4 text-white hover:bg-red-700"
                @click="LoadMore">
            <svg fill="#FFF" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 316.513 316.513" class="h-8 w-8"
                 xml:space="preserve">
                <g>
                    <path d="M158.253,0C71,0,0.012,71.001,0.012,158.263c0,87.256,70.989,158.25,158.241,158.25
                        c87.259,0,158.248-70.994,158.248-158.25C316.501,71.001,245.518,0,158.253,0z M230.891,177.982h-57.748v52.914
                        c0,7.428-4.864,13.438-12.301,13.438c-7.422,0-12.298-6.017-12.298-13.438v-52.914H85.634c-7.44,0-13.454-4.864-13.454-12.298
                        s6.014-12.301,13.454-12.301h62.909V85.616c0-7.434,4.876-13.453,12.298-13.453c7.437,0,12.301,6.02,12.301,13.453v67.768h57.748
                        c7.439,0,13.456,4.867,13.456,12.301S238.33,177.982,230.891,177.982z"/>
                </g>
            </svg>
        </button>
    </div>

    @push('scripts')
        @vite('resources/js/skins/infinite-scroll-listener.js')
    @endpush
</div>
