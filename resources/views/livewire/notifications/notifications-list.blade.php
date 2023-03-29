<div
    wire:poll.visible
    class="absolute top-4 right-20 flex flex-col items-end"
    x-data="{
                open: false
            }"
    x-on:click.away="open = false"
>
    @if( auth()->user()->notifications->count() > 0)
        {{-- Notification Bell --}}
        <button class="hover:text-gray-600 transition-all active:scale-90 relative" x-on:click="open = !open">
            @if( auth()->user()->unreadNotifications->count() > 0)
                <div class="rounded-full bg-red-500 text-white text-sm w-3 h-3 absolute top-0 right-1"></div>
            @endif
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Dropdown --}}
        <div class="w-80"
             x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-300 origin-top-right"
             x-transition:enter-start="opacity-0 scale-0"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-out duration-300 origin-top-right"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-0">

            <div class="flex justify-between items-baseline text-sm text-red-400">
                <button wire:click="ReadNotifications" class="hover:text-red-300">Tout marquer comme "lu"</button>
                <button wire:click="DeleteNotifications" class="hover:text-red-300">Tout supprimer</button>
            </div>
            <div class="py-4 shadow-xl rounded-md right-0 absolute w-full bg-white">
                @foreach( auth()->user()->notifications->take($notificationsAmount) as $notification)
                    <x-notification.template :component="'notification.' . $notification->data['component']" :notification="$notification" :item="$notification->data['model']::find($notification->data['id'])" :read="$notification->read_at"/>
                @endforeach

                <div class="flex justify-center text-red-400 text-sm mt-2">
                    @if(auth()->user()->notifications->count() > $notificationsAmount)
                        <button wire:click="ShowAllNotifications" class="hover:text-red-300">Tout afficher
                            <span>( {{ auth()->user()->notifications->count() - $notificationsAmount }} restant{{ auth()->user()->notifications->count() - $notificationsAmount == 1 ? ' ' : 's' }} )</span>
                        </button>
                    @elseif(auth()->user()->notifications->count() > $initNotificationsAmount)
                        <button wire:click="ShowLessNotifications" class="hover:text-red-300">Afficher moins</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
