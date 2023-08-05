<?php $__env->startSection('mail-subject'); ?>
    Skin posté
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Ton skin <span class="font-normal italic">ID#<?php echo e($skin->id); ?></span> en <span class="font-normal"><?php echo e($skin->race->name); ?></span> a été validé par un membre du Staff.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-body'); ?>
    <div class="flex justify-center"><img class="p-4" src="<?php echo e(asset('storage/' . $skin->image_path )); ?>" alt="Image du skin <?php echo e($skin->id); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Clique pour le voir en action !</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mails/skin-posted.blade.php ENDPATH**/ ?>