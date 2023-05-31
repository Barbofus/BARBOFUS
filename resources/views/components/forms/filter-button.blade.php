<button
    class="w-[18px] h-[18px] border rounded-[3px] bg-anthraciteLit border-1 border-ivory"
    x-data="{
        active: true,
    }"
    x-on:mousedown="active = !active">

    <x-svg.checkmark />

    @if(isset($label))
        <label class="absolute font-thin text-secondary text-[0.9rem] left-7 top-2 cursor-pointer">{{ $label }}</label>
    @endif

    {{ $slot }}
</button>
