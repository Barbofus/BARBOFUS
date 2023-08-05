<?php $__env->startSection('mail-subject'); ?>
    Réinitialisation de mot passe
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-sentence'); ?>
    Nous avons reçu une requête de réinitialisation de mot de passe.<br>
    Si tu n'es pas à l'origine de cette demande, ne prend pas en compte la suite de ce mail.<br>
    Sinon, pour réinitialiser ton mot de passe, clique sur le bouton plus bas.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-button'); ?>
    <a href="<?php echo e($url); ?>">Réinitialiser mon mot de passe</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mail-url'); ?>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/mail/reset-password-mail.blade.php ENDPATH**/ ?>