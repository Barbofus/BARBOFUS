
<!-- Top page button -->
<button
    x-data="{
        showButton: (document.documentElement.scrollTop > 20 || document.body.scrollTop > 20)
      }"
    @scroll.window="(document.documentElement.scrollTop > 20 || document.body.scrollTop > 20) ? showButton = true : showButton = false"
    x-show="showButton" x-transition.opacity
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="fixed z-50 flex items-center justify-center w-16 h-16 rounded-full shadow-sm right-4 bg-secondary bottom-6 group">
    <svg
        class="w-10 transition-all duration-150 text-primary group-hover:-translate-y-1"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" >
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
    </svg>
</button>
