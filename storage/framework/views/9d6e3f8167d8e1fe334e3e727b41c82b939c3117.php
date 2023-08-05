

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.user-dashboard', [])->html();
} elseif ($_instance->childHasBeenRendered('I7tMws5')) {
    $componentId = $_instance->getRenderedChildComponentId('I7tMws5');
    $componentTag = $_instance->getRenderedChildComponentTagName('I7tMws5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('I7tMws5');
} else {
    $response = \Livewire\Livewire::mount('user-panel.user-dashboard', []);
    $html = $response->html();
    $_instance->logRenderedChild('I7tMws5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.basic-views', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/user_page/user-dashboard-view.blade.php ENDPATH**/ ?>