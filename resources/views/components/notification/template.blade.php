<div class="border-b w-full border-gray-300 text-left p-2 {{ $read ? 'bg-gray-200' : 'hover:bg-gray-100'}}">

    <div class="{{ $read ? 'opacity-40' : ''}}">
        <x-dynamic-component :component="$component" :item="$item" :notification="$notification"/>
    </div>

    <div class="w-full flex justify-between my-2 px-6">
        <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans()}}</p>

        @if($read)
            <button wire:click="DeleteNotification('{{ $notification->id }}')" class="text-red-400 text-sm hover:text-red-300">Supprimer</button>
        @else
            <button wire:click="ReadNotification('{{ $notification->id }}')" class="text-red-400 text-sm hover:text-red-300">Marquer comme lu</button>
        @endif
    </div>
</div>
