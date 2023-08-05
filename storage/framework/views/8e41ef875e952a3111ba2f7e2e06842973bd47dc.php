<div wire:poll.visible.60s="Refresh" id="rewards-section"
     class="z-0 flex flex-col items-center w-full px-8 pt-4 top-12
            min-[1800px]:fixed min-[1800px]:order-last min-[1800px]:w-[25rem] min-[1800px]:flex-row min-[1800px]:px-0 min-[1800px]:min-h-[calc(100vh-15vh-1rem)]
            min-[1800px]:max-h-[calc(100vh-theme(spacing.2))] min-[1800px]:top-[calc(15vh+0.5rem)] min-[1800px]:right-0 min-[1800px]:z-30 min-[1800px]:py-8 min-[1800px]:h-full">

    <!-- Content -->
    <div class="flex flex-col items-start justify-center flex-1 w-full py-4 min-[1800px]:h-[min(100%,93rem)]">

        <!-- Header -->
        <div class="relative flex items-center justify-center w-full pl-4 gap-x-2">

            <!-- Icone Info -->
            <div class="relative h-6 cursor-pointer min-w-[1.5rem] group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-secondary">
                    <path d="M11.812,0C5.289,0,0,5.289,0,11.812s5.289,11.813,11.812,11.813s11.813-5.29,11.813-11.813
                      S18.335,0,11.812,0z M14.271,18.307c-0.608,0.24-1.092,0.422-1.455,0.548c-0.362,0.126-0.783,0.189-1.262,0.189
                      c-0.736,0-1.309-0.18-1.717-0.539s-0.611-0.814-0.611-1.367c0-0.215,0.015-0.435,0.045-0.659c0.031-0.224,0.08-0.476,0.147-0.759
                      l0.761-2.688c0.067-0.258,0.125-0.503,0.171-0.731c0.046-0.23,0.068-0.441,0.068-0.633c0-0.342-0.071-0.582-0.212-0.717
                      c-0.143-0.135-0.412-0.201-0.813-0.201c-0.196,0-0.398,0.029-0.605,0.09c-0.205,0.063-0.383,0.12-0.529,0.176l0.201-0.828
                      c0.498-0.203,0.975-0.377,1.43-0.521c0.455-0.146,0.885-0.218,1.29-0.218c0.731,0,1.295,0.178,1.692,0.53
                      c0.395,0.353,0.594,0.812,0.594,1.376c0,0.117-0.014,0.323-0.041,0.617c-0.027,0.295-0.078,0.564-0.152,0.811l-0.757,2.68
                      c-0.062,0.215-0.117,0.461-0.167,0.736c-0.049,0.275-0.073,0.485-0.073,0.626c0,0.356,0.079,0.599,0.239,0.728
                      c0.158,0.129,0.435,0.194,0.827,0.194c0.185,0,0.392-0.033,0.626-0.097c0.232-0.064,0.4-0.121,0.506-0.17L14.271,18.307z
                      M14.137,7.429c-0.353,0.328-0.778,0.492-1.275,0.492c-0.496,0-0.924-0.164-1.28-0.492c-0.354-0.328-0.533-0.727-0.533-1.193
                      c0-0.465,0.18-0.865,0.533-1.196c0.356-0.332,0.784-0.497,1.28-0.497c0.497,0,0.923,0.165,1.275,0.497
                      c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z"/>
                </svg>
                <div class="group-hover:visible group-hover:opacity-100 z-10 invisible opacity-0 transition-all cursor-text absolute top-[150%]
                      min-[901px]:-left-[17.5rem] min-[901px]:-top-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.miss-skin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.miss-skin'); ?>
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
                    <svg class="absolute h-4 text-secondary right-[50%] rotate-180 -top-4
                        min-[901px]:-rotate-90 min-[901px]:top-5 min-[901px]:-right-4 " x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                        <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                    </svg>
                </div>
            </div>

            <!-- Sentance -->
            <p class="w-auto text-secondary font-light">Tirage tous les <span class="font-normal">Mardi à 9h</span> !</p>
        </div>



        <!-- Skins -->
        <div class="relative flex flex-col gap-y-12 items-center justify-center flex-1 w-full pt-14
                  min-[851px]:max-[1799px]:flex-row min-[501px]:gap-x-8
                  min-[701px]:max-[1799px]:gap-x-16">

            <?php $__currentLoopData = $skins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div wire:key="skinwinner.<?php echo e($skin->id); ?>"
                    class="max-[500px]:w-[clamp(8.75rem,90%,12.5rem)]
                    min-[501px]:max-[1799px]:w-[12.5rem]
                    min-[1800px]:h-[min(28%,22.5rem)] min-[1800px]:w-full min-[1800px]:flex min-[1800px]:justify-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.winners-skin-card','data' => ['skin' => $skin]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.winners-skin-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['skin' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Bottom border -->
    <div class="h-1 mt-4 rounded-full goldGradientSide w-[80%]
                min-[1101px]:w-[max(12.5rem,80%)]
                min-[1800px]:goldGradientTop min-[1800px]:w-1 min-[1800px]:h-[80%] min-[1800px]:order-first min-[1800px]:mt-0"></div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/skin/last-winners.blade.php ENDPATH**/ ?>