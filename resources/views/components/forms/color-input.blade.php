<div>
    <p class="text-lg italic font-thin ml-5 text-secondary">{{ $title }}</p>
    <div class="flex items-center ml-2 h-8 relative z-10"
         x-data="{
            color: '{{$value}}',
            dark: false,

            IsDark() {

                console.log(this.color);
                r = parseInt(this.color.substring(0,2), 16);
                g = parseInt(this.color.substring(2,4), 16);
                b = parseInt(this.color.substring(4,6), 16);


                (r + g + b > 382) ? this.dark = false : this.dark = true;
            },

            changePreviewColor(color){
                $refs.colorPreview.style.backgroundColor = '#' + color;
                this.IsDark();
            },
            }"
         x-init="changePreviewColor('{{$value}}')">
        <div x-ref="colorPreview" class="aspect-square h-full rounded-sm border-2" :class="dark ? 'border-inactiveText' : 'border-primary'"></div>
        <div class="rounded-md ml-2 @error($name) err-border @enderror flex h-full overflow-hidden">
            <span class="text-xl h-full flex items-center bg-primary-100 transition-all pl-1" :class="color ? 'text-secondary' : 'text-inactiveText'">#</span>
            <input x-model="color" x-on:input.change="changePreviewColor(color)" maxlength="6" type="text" name="{{ $name }}" placeholder="FFFFFF" class="pl-1 h-full max-w-[75px] placeholder-inactiveText placeholder:font-thin placeholder:italic font-light uppercase bg-primary-100 focus:outline-none" value="{{ $value }}">
        </div>

        <div class="absolute -right-32 top-1 w-full">
            @error($name)
                <x-forms.requirements-error :$message />
            @enderror
        </div>
    </div>
</div>
