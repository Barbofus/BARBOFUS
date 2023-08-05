

<?php $__env->startSection('content'); ?>
    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">Création</h1>
    <h2 class="text-2xl font-thin text-center -mt-3 mb-8 uppercase">Présente nous tes skins !</h2>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" action="<?php echo e(route('skins.store')); ?>" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            <?php echo csrf_field(); ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.skin-form','data' => ['races' => $races]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.skin-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['races' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($races)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.basic-views', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/skins/create.blade.php ENDPATH**/ ?>