<!-- En-tête -->
<div id="header"
     class="w-full h-0 bg-secondary invisible
          min-[901px]:visible min-[901px]:h-[15vh] min-[901px]:min-h-[150px]">
    <div class="flex justify-center h-full">
        <img src="{{ asset('storage/images/misc_ui/Barbofus_Logo.png') }}" class="h-full"/>
    </div>

    {{-- Notifications --}}
    @auth
        <livewire:notifications.notifications-list/>
    @endauth
</div>
