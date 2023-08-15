<div class="flex rounded-md gap-x-4 px-4 py-2 items-center ml-8 mt-4 bg-[#313338] w-fit">
    <div class="relative">
        <img src="https://cdn.discordapp.com/avatars/{{ $discord['id'] }}/{{ $discord['avatar'] }}.png" class="h-10 rounded-full">
    </div>
    <div class="max-w-[200px] break-words">
        <p class="text-secondary text-lg font-light">{{ $discord['global_name'] }}</p>
        <p class="text-inactiveText text-md font-thin">{{ $discord['username'] }}</p>
    </div>
    <img src="{{ asset('storage/images/misc_ui/logo_discord_white.png') }}" class="h-10">
</div>
