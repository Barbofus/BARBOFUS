<div>
    <div class="flex gap-x-2 items-center justify-start">
        <img src="<?php echo e(asset('storage/' . $subicon)); ?>" class="h-7">
        <p class="text-inactiveText text-md font-light"><?php echo e($subname); ?></p>
        <p class="text-inactiveText text-md font-light">Lv. <?php echo e($level); ?></p>
    </div>
    <div class="flex space-x-2 items-center bg-primary-100 rounded-md pr-4">
        <img class="w-14" draggable="false" src="<?php echo e(asset('storage/' . $icon )); ?>">
        <p class="font-light italic text-secondary text-md min-[750px]:text-lg"><?php echo e($name); ?></p>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/skins-presentation/item.blade.php ENDPATH**/ ?>