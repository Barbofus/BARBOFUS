<div class="grid h-full grid-rows-[7] md:grid-cols-2 lg:grid-cols-7 gap-8 lg:gap-4">
    <template x-for="(day, dayIndex) in planning" :key="dayIndex + '-' + day.name">
        <div class="relative flex flex-col h-full min-h-0 gap-3">

            <!-- Header -->
            <div class="relative flex-shrink-0 pointer-events-none group">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-[#fba436] to-[#faed61] rounded-2xl blur-md opacity-40 group-hover:opacity-60 transition-opacity">
                </div>
                <div
                    class="relative bg-gradient-to-br from-[#fba436] to-[#faed61] p-[min(1rem,0.75vw)] rounded-[min(1rem,0.75vw)] pointer-events-auto">
                    <div class="text-center">
                        <div class="text-[#292522] font-light text-xl lg:text-[min(1.25rem,1.25vw)] tracking-[0.3em] opacity-80 uppercase"
                            x-text="day.name">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities -->
            <div class="flex flex-1 min-h-0 gap-3 lg:flex-col">
                <template x-for="(activity, activityIndex) in (day.activities || [])"
                    :key="dayIndex + '-' + activityIndex">
                    <div class="flex-1 min-h-0 aspect-[9/16] lg:aspect-auto">
                        <x-planning.SingleActivity />
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>
