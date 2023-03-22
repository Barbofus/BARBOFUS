<div>
    <p class="text-lg">{{ $title }}</p>
    <div class="flex items-center ml-2"
         x-data="{
            color: '{{$value}}',
            changePreviewColor(color){
                $refs.colorPreview.style.backgroundColor = '#' + color;
            },
            }"
         x-init="changePreviewColor('{{$value}}')">
        <div x-ref="colorPreview" class="w-6 h-6 border-2 border-slate-600"></div>
        <span class="ml-2 text-xl">#</span>
        <input x-model="color" x-on:input.change="changePreviewColor(color)" maxlength="6" type="text" name="{{ $name }}" placeholder="FFFFFF" class="max-w-[75px] focus:outline-none bg-slate-100 rounded-md @error($name) err-border @enderror" value="{{ $value }}">

        @error($name)
        <x-forms.requirements-error :$message />
        @enderror
    </div>
</div>
