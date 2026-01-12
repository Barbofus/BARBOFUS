<div class="flex rounded-lg gap-x-2 px-3 py-2 items-center bg-[#313338] w-fit"
     x-data="{ showDiscordInfo: false }">
    <div x-show="showDiscordInfo"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="flex items-center gap-x-2">
        <div class="relative">
            <img src="https://cdn.discordapp.com/avatars/{{ $discord['id'] }}/{{ $discord['avatar'] }}.png" class="h-8 rounded-full">
        </div>
        <div class="max-w-[120px] break-words">
            <p class="text-secondary text-sm font-light">{{ $discord['global_name'] }}</p>
            <p class="text-inactiveText text-xs font-thin">{{ $discord['username'] }}</p>
        </div>
    </div>
    <div x-show="!showDiscordInfo" class="flex items-center gap-x-2">
        <div class="bg-inactiveText rounded-full w-8 h-8 cursor-pointer hover:bg-secondary transition-colors"
             @click="showDiscordInfo = true">
        </div>
        <div class="bg-inactiveText rounded-md px-2 py-1 cursor-pointer hover:bg-secondary transition-colors"
             @click="showDiscordInfo = true">
            <p class="text-sm font-medium text-transparent">████████</p>
            <p class="text-xs font-medium text-transparent">████████</p>
        </div>
    </div>
</div>
