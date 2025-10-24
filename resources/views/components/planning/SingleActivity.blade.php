
<div class="bg-[#292522]/50 backdrop-blur-md border-white/5 border-2 overflow-hidden transition-all hover:scale-[1.02] hover:border-[#fba436]/40 hover:shadow-2xl hover:shadow-[#fba436]/20 group relative rounded-2xl flex-1 cursor-pointer">
    <div class="relative h-full overflow-hidden flex flex-col">
        {{-- Image Section --}}
        <div class="relative flex-1 overflow-hidden">
            <img :src="activity.Image"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
            <div class="absolute inset-0 bg-gradient-to-t from-[#292522] via-[#292522]/50 to-transparent opacity-100 group-hover:opacity-50 transition-opacity duration-500"></div>
        </div>

        {{-- Content Section --}}
        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-[#292522] to-transparent">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-gradient-to-r from-[#fba436] to-[#faed61] shadow-lg shadow-[#fba436]/50"></div>
                    <p class="text-transparent font-light bg-gradient-to-r from-[#fba436] to-[#faed61] bg-clip-text tracking-wider" x-text="activity.StartTime + ' - ' + activity.EndTime" />
                </div>
                <p class="text-white leading-tight" x-text="activity.Name" />
            </div>
        </div>

        {{-- Shimmer effect on hover --}}
        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/0 to-transparent group-hover:via-white/5 transition-all duration-500"></div>
    </div>
</div>
