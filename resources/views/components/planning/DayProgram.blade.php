<div class="hidden lg:grid grid-cols-7 gap-4 h-full">

    {{-- Planning une journée --}}
    <template x-for="day in planning" :key="day.name">
        <div  class="flex flex-col gap-3 h-full">
            {{-- Day Header --}}
            <div class="relative group flex-shrink-0">
                <div class="absolute inset-0 bg-gradient-to-r from-[#fba436] to-[#faed61] rounded-2xl blur-md opacity-40 group-hover:opacity-60 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-[#fba436] to-[#faed61] p-4 rounded-2xl">
                    <div class="text-center">
                        <div class="text-[#292522] font-light text-xl tracking-[0.3em] opacity-80 uppercase mb-1.5" x-text="day.name"></div>
                    </div>
                </div>
            </div>

            {{-- Time Slots --}}
            <div class="flex flex-col gap-3 flex-1">
                <template x-for="activity in day.activities" :key="activity.name + activity.startTime">
                    <x-planning.SingleActivity />
                </template>
            </div>
        </div>
    </template>
</div>
