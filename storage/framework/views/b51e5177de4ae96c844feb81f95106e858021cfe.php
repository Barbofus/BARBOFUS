<button
    class="w-[1.125rem] h-[1.125rem] border rounded-[3px] bg-anthraciteLit border-1 border-ivory"
    @click="window.scrollTo(0,0)"
    <?php echo e($attributes); ?>>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.svg.checkmark','data' => ['checked' => $checked]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('svg.checkmark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checked)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if(isset($label)): ?>
        <label class="absolute font-thin text-secondary text-[0.9rem] left-7 top-2 cursor-pointer"><?php echo e($label); ?></label>
    <?php endif; ?>

    <?php echo e($slot); ?>

</button>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/forms/filter-button.blade.php ENDPATH**/ ?>