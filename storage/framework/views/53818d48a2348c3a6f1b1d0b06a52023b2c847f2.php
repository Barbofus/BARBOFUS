<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Mes likes','subtitle' => 'Ton historique de likes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mes likes'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Ton historique de likes')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="flex-1 flex flex-col items-center mb-10">
            <?php if(count($postIdChunks) > 0): ?>
                <?php for($i = 0; $i < $page && $i < $maxPage; $i++): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.mylikes-chunk', ['skinIds' => $postIdChunks[$i],'page' => $page,'itemsPerPage' => Self::ITEMS_PER_PAGE])->html();
} elseif ($_instance->childHasBeenRendered('chunk-'.$queryCount.'-'.$i)) {
    $componentId = $_instance->getRenderedChildComponentId('chunk-'.$queryCount.'-'.$i);
    $componentTag = $_instance->getRenderedChildComponentTagName('chunk-'.$queryCount.'-'.$i);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('chunk-'.$queryCount.'-'.$i);
} else {
    $response = \Livewire\Livewire::mount('user-panel.mylikes-chunk', ['skinIds' => $postIdChunks[$i],'page' => $page,'itemsPerPage' => Self::ITEMS_PER_PAGE]);
    $html = $response->html();
    $_instance->logRenderedChild('chunk-'.$queryCount.'-'.$i, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endfor; ?>
            <?php else: ?>
                <img class="mt-8 h-[16rem]" src="<?php echo e(asset('storage/images/misc_ui/Barbe_pleure.png')); ?>">
                <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Tu n'as encore rien aimé !</span></p>
            <?php endif; ?>

            
            <?php if($this->HasMorePage()): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.load-more','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.load-more'); ?>
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
            <?php endif; ?>
        </div>
    </div>

</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/mylikes-infinite-load.blade.php ENDPATH**/ ?>