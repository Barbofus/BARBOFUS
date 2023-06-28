<div>
    <button
        class="w-24 rounded-md hover:bg-primary-100 group relative overflow-hidden"
        x-data="{
            color:'{{ $color }}',
            copied: false,
            dark: false,

            GetBrightness() {

                finalColor = '#' + this.color;

                rgb = finalColor.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(m, r, g, b) => '#' + r + r + g + g + b + b)
                            .substring(1).match(/.{2}/g)
                            .map(x => parseInt(x, 16));

                brightness = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);

                (brightness > 125) ? this.dark = false : this.dark = true;
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
            <p class="font-thin group-hover:font-light italic text-md text-secondary">{{ $name }} :</p>
            <svg class="w-4 fill-inactiveText group-hover:fill-secondary" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 442 442" xml:space="preserve" transform="matrix(-1, 0, 0, 1, 0, 0)">
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

        <div class="w-full rounded-md h-8 mt-1 col-span-2 flex items-center justify-center border-2 uppercase" :class="dark ? 'border-inactiveText' : 'border-primary'" :style="'background-color: #' + '{{ $color }}'">
            <p x-text="'#' + color" :class="dark ? 'text-secondary' : 'text-primary' "></p>
        </div>

        <div x-show="copied" class="w-full h-full bg-black/80 absolute top-0 flex items-center justify-center">
            <p class="text-secondary text-xl font-normal">Copié !</p>
        </div>
    </button>
</div>
