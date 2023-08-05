<?php $__env->startSection('mail-subject'); ?>
    Vérification d'E-mail
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Merci de cliquer sur ce lien pour valider ton adresse e-mail et te connecter à Barbofus.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Valider l'E-mail</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mail/verify-email.blade.php ENDPATH**/ ?>