<div class="-mx-3" x-data="{ text: '{{ (old($name)) ? old($name) : '' }}'}">
    <div class="w-[min(90%,350px)] px-3">
        <div class="flex w-full h-12 group rounded-md @error($name) err-border @enderror">
            <input x-model="text" id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" maxlength="30"
                   class="h-full peer w-full p-2 pr-3 bg-primary-100 border-y-2 border-r-2 border-primary-100 rounded-r-md outline-none focus:border-goldText placeholder-inactiveText transition-all"
                   placeholder="{{ $placeholder }}"
                    {{ $attributes }}>

            <div class="order-first relative bg-primary-100 h-full w-12 rounded-l-md p-2 flex justify-between items-center border-y-2 border-l-2 border-primary-100 transition-all peer-focus:border-goldText">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-full h-full transition-all" x-cloak
                     :class="(text) ? 'text-secondary' : 'text-inactiveText'">
                    {{ $slot }}
                </svg>


                <div x-cloak
                     class="absolute left-0 border-r-2 w-full h-8 transition-all"
                     :class="(text) ? 'border-secondary' : 'border-inactiveText'"></div>
            </div>
        </div>
    </div>
    @error($name)
        <x-forms.requirements-error :message="$message"/>
    @enderror
</div>
