<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:title" content="Barbofus" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e(Request::url()); ?>" />
    <meta property="og:image" content="<?php echo $__env->yieldContent('app-meta-image'); ?>" /> 
    <meta property="og:description" content="Partage les meilleurs skins du monde des douze !" />
    <meta name="theme-color" content="#fcb943">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://www.google.com/recaptcha/api.js"></script>

    
    <style>
        [x-cloak] {
            display: none;
        }

        input:-webkit-autofill {
            background: var(--anthraciteLit);
        }
    </style>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('/storage/images/icons/favicon.ico')); ?>">

    <title>Barbofus</title>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>
<body class="bg-primary text-secondary min-h-screen max-w-screen"
    x-data="{
        alertMessage: '',
        showAlert: false,
        timeoutID: null,

        sessionAlert: <?php echo e(session()->has('alert-message') ? 'true' : 'false'); ?>,

        newAlert(msg) {
            clearTimeout(this.timeoutID);

            this.closeAlert();

            setTimeout(() => this.createAlert(msg), 300);
        },
        createAlert(msg) {
            this.showAlert = true;
            this.alertMessage = msg;

            this.timeoutID = setTimeout(() => this.closeAlert(), 5000)
        },
        closeAlert() {
            this.showAlert = false;
        },
    }"
    x-init="if(sessionAlert) setTimeout(() => newAlert('<?php echo e(session('alert-message')); ?>'), 300)"
    x-on:alert-event="newAlert($event.detail.message)">
    <?php echo $__env->yieldContent('app-content'); ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.custom-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.custom-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php echo \Livewire\Livewire::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/layouts/app.blade.php ENDPATH**/ ?>