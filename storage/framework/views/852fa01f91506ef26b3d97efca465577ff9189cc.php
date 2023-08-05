

<?php $__env->startSection('content'); ?>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('skin.infinite-skin-index', [])->html();
} elseif ($_instance->childHasBeenRendered('skin-index'.e(rand()).'')) {
    $componentId = $_instance->getRenderedChildComponentId('skin-index'.e(rand()).'');
    $componentTag = $_instance->getRenderedChildComponentTagName('skin-index'.e(rand()).'');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('skin-index'.e(rand()).'');
} else {
    $response = \Livewire\Livewire::mount('skin.infinite-skin-index', []);
    $html = $response->html();
    $_instance->logRenderedChild('skin-index'.e(rand()).'', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.basic-views', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/skins/index.blade.php ENDPATH**/ ?>