<button
    id="{{ $name }}"
    class="w-[1.125rem] h-[1.125rem] border rounded-[3px] bg-anthraciteLit border-1 border-ivory"
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    {{ $attributes }}>

    <x-svg.checkmark :checked="$checked"/>

    @if(isset($label))
        <label for="{{ $name }}" class="absolute font-thin text-secondary text-[0.9rem] left-7 top-2 cursor-pointer">{{ $label }}</label>
    @endif

    {{ $slot }}
</button>
