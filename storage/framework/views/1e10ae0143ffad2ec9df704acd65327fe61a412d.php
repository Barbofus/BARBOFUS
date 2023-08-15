<div class="flex items-start ">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-16 text-red-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>


    <div class="pl-4">
        <p class="font-normal">Skin Refusé <span class="italic text-inactiveText">ID#<?php echo e($notification->data['id']); ?></span></p>
        <p class="indent-2 font-light">Ton skin en <span class="font-normal"><?php echo e($notification->data['info']); ?></span> à été refusé par un membre du staff. <a wire:click="ReadNotification('<?php echo e($notification->id); ?>')" class="text-goldText hover:text-goldTextLit font-thin" href="<?php echo e(route('skins.edit', ['skin' => $notification->data['id']])); ?>">Clique ici pour le modifier</a></p>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/notification/skin-refused.blade.php ENDPATH**/ ?>