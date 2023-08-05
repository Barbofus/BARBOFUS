<?php $__env->startSection('mail-subject'); ?>
    Mot de passe modifié
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Ton mot de passe vient d'être changé, si tu n'es pas à l'origine de ce changement, réinitialise-le avec ce bouton.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Réinitialiser mon mot de passe</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mail/user-password-change-mail.blade.php ENDPATH**/ ?>