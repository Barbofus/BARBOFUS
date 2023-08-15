<div class="w-full mb-1 shadow-md rounded-md text-left p-2 <?php echo e($read ? 'bg-primary-100' : 'bg-primary hover:bg-primary-100'); ?>">

    <div class="<?php echo e($read ? 'opacity-40' : ''); ?>">
        <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $component] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notification' => $notification,':read' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
    </div>

    <div class="w-full flex justify-between my-2 px-6">
        <p class="text-sm text-inactiveText"><?php echo e($notification->created_at->diffForHumans()); ?></p>

        <?php if($read): ?>
            <button wire:click="DeleteNotification('<?php echo e($notification->id); ?>')" class="text-red-400 text-sm hover:text-red-300">Supprimer</button>
        <?php else: ?>
            <button wire:click="ReadNotification('<?php echo e($notification->id); ?>')" class="text-red-400 text-sm hover:text-red-300">Marquer comme lu</button>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/notification/template.blade.php ENDPATH**/ ?>