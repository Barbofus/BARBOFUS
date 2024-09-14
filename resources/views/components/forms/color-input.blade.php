<div>
    <p class="text-lg italic font-thin ml-5 text-secondary">{{ $title }}</p>
    <div class="flex items-center ml-2 h-8 relative z-10"
         x-data="{
            color: '{{$value}}',
            dark: true,

            IsDark() {

                if(this.color.length < 6) return;

                finalColor = '#' + this.color;

                rgb = finalColor.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(m, r, g, b) => '#' + r + r + g + g + b + b)
                            .substring(1).match(/.{2}/g)
                            .map(x => parseInt(x, 16));

                brightness = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);

                (brightness > 125) ? this.dark = false : this.dark = true;
            },

            changePreviewColor(color){
                if(this.color.length < 6) {
                    $refs.colorPreview.style.backgroundColor = '';
                    return;
                }

                if(this.color.length > 6) {
                    color = color.slice(1);
                    this.color = color;

                    console.log(color);
                }

                $refs.colorPreview.style.backgroundColor = '#' + color;
                this.IsDark();
            },
            }"
         x-init="changePreviewColor('{{$value}}')">

        <div x-ref="colorPreview" class="aspect-square h-full rounded-md border-2" :class="dark ? 'border-inactiveText' : 'border-primary'"></div>
        <div class="rounded-md ml-2 @error($name) err-border @enderror flex h-full overflow-hidden">
            <span class="text-xl h-full flex items-center bg-primary-100 transition-all pl-1" :class="color ? 'text-secondary' : 'text-inactiveText'">#</span>
            <input x-model="color" x-on:input.change="changePreviewColor(color)" maxlength="7" type="text" name="{{ $name }}" placeholder="FFFFFF" class="pl-1 h-full max-w-[75px] placeholder-inactiveText placeholder:font-thin placeholder:italic font-light uppercase bg-primary-100 focus:outline-none" value="{{ $value }}">
        </div>

        <div class="absolute -right-32 top-1 w-full">
            @error($name)
                <x-forms.requirements-error :$message />
            @enderror
        </div>
    </div>
</div>
