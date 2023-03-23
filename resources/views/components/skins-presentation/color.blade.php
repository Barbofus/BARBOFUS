<div>
    <button
        class="w-24 rounded-md hover:bg-gray-200 relative h-11 overflow-hidden"
        x-data="{
            color:'{{ $color }}',
            copied: false,
            dark: false,

            GetBrightness() {

                r = parseInt(this.color.substring(0,2), 16);
                g = parseInt(this.color.substring(2,4), 16);
                b = parseInt(this.color.substring(4,6), 16);


                (r + g + b > 382) ? this.dark = false : this.dark = true;
            },

            CopyText() {
                if(!navigator.clipboard) return;

                navigator.clipboard.writeText(this.color);
                this.copied = true;
            }
        }"
        x-init="GetBrightness"
        x-on:mousedown="CopyText"
        x-on:click.away="copied = false"
    >
        <div class="flex justify-between">
            <p>{{ $name }} :</p>
            <svg class="w-4 fill-gray-500" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 442 442" xml:space="preserve" transform="matrix(-1, 0, 0, 1, 0, 0)">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <g>
                    <polygon points="291,0 51,0 51,332 121,332 121,80 291,80 "></polygon>
                    <polygon points="306,125 306,195 376,195 "></polygon>
                    <polygon points="276,225 276,110 151,110 151,442 391,442 391,225 "></polygon>
                </g>
            </g>
        </svg>
        </div>

        <div class="w-full rounded-md h-5 col-span-2 flex items-center justify-center border" :class="dark ? 'border-gray-200' : 'border-gray-400'" :style="'background-color: #' + '{{ $color }}'">
            <p x-text="'#' + color" :class="dark ? 'text-white' : 'text-black' "></p>
        </div>

        <div x-show="copied" class="w-full h-full bg-black/60 absolute top-0 flex items-center justify-center">
            <p class="text-white font-bold">Copié !</p>
        </div>
    </button>
</div>
