

<?php $__env->startSection('content'); ?>
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='<?php echo e(route('verification.send', ['id' => Route::current()->parameter('id')])); ?>' class="flex justify-center w-[80%]">
            <?php echo csrf_field(); ?>
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">
                <?php if(session('status') == 'verification-link-sent'): ?>
                    <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600">Un e-mail de vérification a été réenvoyer !</p>
                <?php endif; ?>

                <h2 class="text-2xl font-thin text-center -mt-10 mb-8">L'adresse mail doit être validé pour se conencter.</h2>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8">Un email de vérification a été envoyé.</h2>
                <h2 class="text-2xl font-light text-center -mt-10 mb-8">Merci de cliquer sur le lien dans le mail.</h2>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Réenvoyer l'e-mail de validation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.basic-views', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>