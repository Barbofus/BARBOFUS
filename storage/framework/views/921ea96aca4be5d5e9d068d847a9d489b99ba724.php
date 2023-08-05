<?php $__env->startSection('mail-subject'); ?>
    Skin refusé
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Ton skin <span class="font-normal italic">ID#<?php echo e($skin->id); ?></span> en <span class="font-normal"><?php echo e($skin->race->name); ?></span> a été refusé par un membre du Staff.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-body'); ?>
    <?php if($skin->refused_reason): ?>
        <div class="py-4 px-6 bg-[rgba(255,50,50,0.3)] text-red-500 border-l-[3px] border-red-500 rounded-r-md mb-6"><?php echo e($skin->refused_reason); ?></div>
    <?php endif; ?>
    <div class="flex justify-center"><img class="p-4 bg-[rgba(255,50,50,0.3)] border-[3px] border-red-500 rounded-md" src="<?php echo e(asset('storage/' . $skin->image_path )); ?>" alt="Image du skin <?php echo e($skin->id); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Clique pour le modifier</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mails/skin-refused.blade.php ENDPATH**/ ?>