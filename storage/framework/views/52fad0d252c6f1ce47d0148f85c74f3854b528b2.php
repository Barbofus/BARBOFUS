<div x-data @scroll.window="if((window.scrollY + window.innerHeight) >= document.body.offsetHeight) $wire.LoadMore()" class="mb-8">

    
    <div class="flex justify-center my-8">

        <img wire:loading wire:target="LoadMore" class="animate-pulseFast h-32 w-32 opacity-25" src="<?php echo e(asset('storage/images/misc_ui/logo_barbe_x256.png')); ?>" draggable="false">

    </div>

    
    <div class="p-4 flex flex-col items-center">
        <button class="py-4 px-8 rounded-md bg-secondary mt-4 hover:bg-secondary-100"
                wire:click="LoadMore">
            <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 316.513 316.513" class="h-8 w-8 fill-primary"
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
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/utils/load-more.blade.php ENDPATH**/ ?>