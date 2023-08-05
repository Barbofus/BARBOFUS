<div x-data="{ skinDeleteID: null, skinDeleteImg: '', }">
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Mes skins','subtitle' => 'Tes propres créations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mes skins'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Tes propres créations')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="bg-primary w-full flex justify-center sticky top-12 py-8 z-10">
            <a href="<?php echo e(route('skins.create')); ?>" class="goldGradient px-4 py-2 rounded-md text-primary flex flex-col transition-all items-center text-2xl hover:rounded-3xl group hover:brightness-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                <p class="group-hover:-translate-y-2 transition-all">Poster un skin</p>
            </a>
        </div>

        <div class="flex-1 flex flex-col items-center mb-10">
            <?php if(count($postIdChunks) > 0): ?>
                <?php for($i = 0; $i < $page && $i < $maxPage; $i++): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.myskins-chunk', ['skinIds' => $postIdChunks[$i],'page' => $page,'itemsPerPage' => Self::ITEMS_PER_PAGE])->html();
} elseif ($_instance->childHasBeenRendered('chunk-'.$queryCount.'-'.$i)) {
    $componentId = $_instance->getRenderedChildComponentId('chunk-'.$queryCount.'-'.$i);
    $componentTag = $_instance->getRenderedChildComponentTagName('chunk-'.$queryCount.'-'.$i);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('chunk-'.$queryCount.'-'.$i);
} else {
    $response = \Livewire\Livewire::mount('user-panel.myskins-chunk', ['skinIds' => $postIdChunks[$i],'page' => $page,'itemsPerPage' => Self::ITEMS_PER_PAGE]);
    $html = $response->html();
    $_instance->logRenderedChild('chunk-'.$queryCount.'-'.$i, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endfor; ?>
            <?php else: ?>
                <img class="mt-8 h-[16rem]" src="<?php echo e(asset('storage/images/misc_ui/Barbe_pleure.png')); ?>">
                <p class="text-4xl font-normal">Aïe ! <span class="font-thin italic text-3xl">Encore aucun skin posté !</span></p>
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

    <div class="fixed top-0 right-0 bottom-0 left-0"
         x-show="skinDeleteID"  x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-full">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.skin-delete-verification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.skin-delete-verification'); ?>
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
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/myskins-infinite-load.blade.php ENDPATH**/ ?>