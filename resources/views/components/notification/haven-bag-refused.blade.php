<div class="flex items-start ">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-16 text-red-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>


    <div class="pl-4">
        <p class="font-normal">Havre-sac Refusé <span class="italic text-inactiveText">{{ ((isset($notification->data['name'])) ? $notification->data['name'] : 'ID#' . $notification->data['id']) }}</span></p>
        <p class="indent-2 font-light">Ton havre-sac sur le thème <span class="font-normal">{{ $notification->data['info'] }}</span> à été refusé par un membre du staff. <a wire:click="ReadNotification('{{ $notification->id }}')" class="text-goldText hover:text-goldTextLit font-thin" href="{{ route('havre-sacs.edit', ['havenBag' => $notification->data['id']]) }}">Clique ici pour le modifier</a></p>
    </div>
</div>
