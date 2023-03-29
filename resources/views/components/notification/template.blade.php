<div class="border-b w-full border-gray-300 text-left p-2 {{ $read ? 'bg-gray-200' : 'hover:bg-gray-100'}}">

    <x-dynamic-component :component="$component" :item="$item"/>

    <div class="w-full flex justify-between my-2 px-6">
        <p class="text-sm text-gray-500">Il y a
            {{ ((time() - strtotime($notification->created_at)) < 60) ? (time() - strtotime($notification->created_at)) . ' seconde(s)' : (((time() - strtotime($notification->created_at)) < 3600) ? (round((time() - strtotime($notification->created_at)) / 60)) . ' minute(s)' : (((time() - strtotime($notification->created_at)) < 86400) ? (round((time() - strtotime($notification->created_at)) / 3600)) . ' heure(s)' : (round((time() - strtotime($notification->created_at)) / 86400)) . ' jour(s)'))}}</p>

        @if($read)
            <button wire:click="DeleteNotification('{{ $notification->id }}')" class="text-red-400 text-sm hover:text-red-300">Supprimer</button>
        @else
            <button wire:click="ReadNotification('{{ $notification->id }}')" class="text-red-400 text-sm hover:text-red-300">Marquer comme lu</button>
        @endif
    </div>
</div>
