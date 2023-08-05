<div class="grid grid-cols-[repeat(auto-fill,14rem)] pt-20 px-4 gap-x-8 gap-y-20 w-[min(100%,93rem)] justify-center">
    <?php $__currentLoopData = $skins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $skin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div wire:key="skin.<?php echo e($skin->id); ?>" class="relative opacity-0 animate-skinApparition h-full shadow-sm" style="animation-delay: <?php echo e(($key - ($itemsPerPage * ($page - 1))) * 35); ?>ms">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.skin-card','data' => ['skin' => $skin]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.skin-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['skin' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <p class="absolute mt-2 text-lg text-inactiveText italic">Aimé <?php echo e($skin->liked_at->diffForHumans()); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/mylikes-chunk.blade.php ENDPATH**/ ?>