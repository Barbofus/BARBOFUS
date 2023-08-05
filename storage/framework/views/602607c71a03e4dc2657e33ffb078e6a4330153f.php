<?php $__env->startSection('mail-subject'); ?>
    Pseudo modifié
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Ton pseudo vient d'être modifié, si tu n'es pas à l'origine de cette modification, clique sur le bouton pour changer ton mot de passe.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Changer mon mot de passe</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mail/user-name-change-mail.blade.php ENDPATH**/ ?>