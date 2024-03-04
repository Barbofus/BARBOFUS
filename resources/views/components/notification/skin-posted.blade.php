<div class="flex items-start ">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-16 text-green-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
    </svg>

    <div class="pl-4">
        <p class="font-normal">Skin Posté <span class="italic text-inactiveText">{{ ((isset($notification->data['name'])) ? $notification->data['name'] : 'ID#' . $notification->data['id']) }}</span></p>
        <p class="indent-2 font-light">Bien joué ! Ton skin en <span class="font-normal">{{ $notification->data['info'] }}</span> à été validé par un membre du staff</p>
    </div>
</div>
