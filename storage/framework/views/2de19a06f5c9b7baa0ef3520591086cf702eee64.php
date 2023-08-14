<?php $__env->startSection('meta-image'); ?>
    <?php echo e(asset('storage/' . $skin->image_path)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="relative flex flex-col gap-y-1 min-[950px]:gap-y-4 h-[91rem] min-[950px]:h-[53rem] w-[min(95rem,95vw)] mx-auto overflow-hidden min-[950px]:mt-4 min-[950px]:rounded-lg min-[950px]:bg-black min-[950px]:bg-opacity-[0.09] min-[950px]:shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)]"
         x-data="{ skinDeleteID: null, skinDeleteImg:''}">

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('validate-skin')): ?>
            <button class="text-inactiveText hover:text-red-500 transition-all absolute top-2 right-2" @click="skinDeleteID = <?php echo e($skin->id); ?>, skinDeleteImg='<?php echo e(asset('storage/'. $skin->image_path)); ?>'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>


            <div class="fixed top-0 right-0 bottom-0 left-0 z-50"
                 x-show="skinDeleteID"  x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-full"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-y-full">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.skin-delete-verification','data' => ['useController' => true,'skin' => $skin]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.skin-delete-verification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['use-controller' => true,'skin' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        
        <h2 class="text-[min(5vw,1.25rem)] font-thin text-center mt-11 min-[950px]:mt-4">Par <span class="text-[min(6vw,1.5rem)] font-light"><?php echo e($skin->user_name); ?></span></h2>
        
        <div class="grid grid-cols-2 gap-x-4 min-[420px]:gap-x-8 items-center justify-center">
            <div class="flex rounded-md justify-self-end items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary"><?php echo e($skin->race_name); ?></p>
            </div>

            
            <div class="flex rounded-md justify-self-start items-center gap-x-2 border-2 text-secondary border-goldText px-2 min-[950px]:px-3 min-[950px]:h-12 bg-primary-100 py-1 min-[950px]:py-2">
                <?php if($skin->gender == 'Homme'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 min-[950px]:h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                    </svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                    </svg>
                <?php endif; ?>
                <p class="font-thin text-[min(6vw,1.25rem)] text-secondary"><?php echo e($skin->gender); ?></p>
            </div>
        </div>

        <p class="font-thin text-[min(5vw,1.25rem)] text-center text-secondary">Visage N°<?php echo e($skin->face); ?></p>

        <div class="flex flex-col gap-y-4 items-center min-[950px]:pt-24 relative h-full">
            
            <img src="<?php echo e(asset('storage/' . $skin->image_path)); ?>" draggable="false" class="max-[949px]:h-[min(50vh,25rem)] min-[950px]:w-[18.75rem]">
            <img src="<?php echo e(asset('storage/' . $skin->race_icon)); ?>" draggable="false" class="absolute -z-10 opacity-40">

            
            <button class="uppercase px-2 min-[950px]:px-4 py-1 min-[950px]:py-2 goldGradient rounded-md hover:rounded-3xl group-hover:brightness-110 group transition-all"
                    x-data="{
                        copied: 'Copy Link',

                        CopyLink() {
                            if(!navigator.clipboard) return;

                            navigator.clipboard.writeText('<?php echo e(url()->current()); ?>');
                            this.copied = 'Copié';
                        }
                    }"
                    x-on:mousedown="CopyLink">
                <p class="text-primary font-medium text-[min(4.5vw,1.125rem)] group-hover:tracking-widest transition-all" x-text="copied"></p>
            </button>

            <div class="flex flex-row min-[420px]:flex-col items-center gap-x-4 gap-y-4 mt-4">
                

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[19.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[7.5rem]">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['name' => 'Peau','color' => ''.e($skin->color_skin).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Peau','color' => ''.e($skin->color_skin).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[11.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[0.5rem]">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['name' => 'Cheveux','color' => ''.e($skin->color_hair).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Cheveux','color' => ''.e($skin->color_hair).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>

                <div class="flex flex-col min-[420px]:flex-row gap-x-4">
                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:-translate-x-[3.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[11.5rem]">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['name' => 'Habits 1','color' => ''.e($skin->color_cloth_1).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Habits 1','color' => ''.e($skin->color_cloth_1).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[4.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:-translate-x-[3.5rem]">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['name' => 'Habits 2','color' => ''.e($skin->color_cloth_2).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Habits 2','color' => ''.e($skin->color_cloth_2).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div class="min-[950px]:absolute top-0 min-[950px]:-translate-y-0 min-[950px]:translate-x-[12.5rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-y-[35rem] [@media(min-height:920px)_and_(min-width:1100px)]:translate-x-[4.5rem]">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['name' => 'Habits 3','color' => ''.e($skin->color_cloth_3).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Habits 3','color' => ''.e($skin->color_cloth_3).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-y-4 mt-4">
                
                <?php if(isset($skin->dofus_item_costume_level)): ?>
                    <div class="min-[950px]:absolute min-[950px]:animate-slideY [--custom-translate-y:5px] [--custom-animation-time:5s] left-[calc(50%-45.5rem)] top-[7.5rem] order-4 w-[31.25rem] flex justify-center min-[950px]:justify-end" style="animation-delay: -2500ms">
                        <div class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item','data' => ['subicon' => $skin->dofus_item_costume_subicon,'subname' => $skin->dofus_item_costume_subname,'name' => $skin->dofus_item_costume_name,'level' => $skin->dofus_item_costume_level,'icon' => $skin->dofus_item_costume_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subicon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_subicon),'subname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_subname),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_name),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_level),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <img src="<?php echo e(asset('storage/images/misc_ui/costume_arrow.png')); ?>" class="absolute invisible min-[950px]:animate-slideX [--custom-translate-x:5px] [--custom-animation-time:5s] min-[950px]:visible top-[-2.5rem] right-[-12rem]">
                    </div>
                <?php endif; ?>

                <?php if(isset($skin->dofus_item_shield_level)): ?>
                    <div class="min-[950px]:absolute min-[950px]:animate-slideY [--custom-translate-y:5px] [--custom-animation-time:5s] left-[calc(50%-39.5rem)] top-[16rem] order-3 w-[31.25rem] flex justify-center min-[950px]:justify-end" style="animation-delay: -1250ms">
                        <div class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item','data' => ['subicon' => $skin->dofus_item_shield_subicon,'subname' => $skin->dofus_item_shield_subname,'name' => $skin->dofus_item_shield_name,'level' => $skin->dofus_item_shield_level,'icon' => $skin->dofus_item_shield_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subicon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_subicon),'subname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_subname),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_name),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_level),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <img src="<?php echo e(asset('storage/images/misc_ui/shield_arrow.png')); ?>" class="absolute invisible min-[950px]:animate-slideX [--custom-translate-x:5px] [--custom-animation-time:5s] min-[950px]:visible top-[-3rem] right-[-5rem]">
                    </div>
                <?php endif; ?>

                <?php if(isset($skin->dofus_item_pet_level)): ?>
                    <div class="min-[950px]:absolute min-[950px]:animate-slideY [--custom-translate-y:5px] [--custom-animation-time:5s] left-[calc(50%-43.5rem)] top-[24rem] order-5 w-[31.25rem] flex justify-center min-[950px]:justify-end" style="animation-delay: -1250ms">
                        <div class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-end">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item','data' => ['subicon' => $skin->dofus_item_pet_subicon,'subname' => $skin->dofus_item_pet_subname,'name' => $skin->dofus_item_pet_name,'level' => $skin->dofus_item_pet_level,'icon' => $skin->dofus_item_pet_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subicon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_subicon),'subname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_subname),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_name),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_level),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <img src="<?php echo e(asset('storage/images/misc_ui/pet_arrow.png')); ?>" class="absolute min-[950px]:animate-slideX [--custom-translate-x:5px] [--custom-animation-time:5s] invisible min-[950px]:visible bottom-[-5rem] right-[-5rem]" style="animation-delay: -1250ms">
                    </div>
                <?php endif; ?>

                <?php if(isset($skin->dofus_item_hat_level)): ?>
                    <div class="min-[950px]:absolute min-[950px]:animate-slideY [--custom-translate-y:5px] [--custom-animation-time:5s] left-[calc(50%+11.5rem)] top-[8.5rem] order-1 w-[31.25rem] flex justify-center min-[950px]:justify-start" style="animation-delay: -1250ms">
                        <div class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-start">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item','data' => ['subicon' => $skin->dofus_item_hat_subicon,'subname' => $skin->dofus_item_hat_subname,'name' => $skin->dofus_item_hat_name,'level' => $skin->dofus_item_hat_level,'icon' => $skin->dofus_item_hat_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subicon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_subicon),'subname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_subname),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_name),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_level),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <img src="<?php echo e(asset('storage/images/misc_ui/hat_arrow.png')); ?>" class="absolute min-[950px]:animate-slideX [--custom-translate-x:5px] [--custom-animation-time:5s] invisible min-[950px]:visible top-[-4.5rem] left-[-5rem]">
                    </div>
                <?php endif; ?>

                <?php if(isset($skin->dofus_item_cloak_level)): ?>
                    <div class="min-[950px]:absolute min-[950px]:animate-slideX [--custom-translate-x:5px] [--custom-animation-time:5s] left-[calc(50%+14.5rem)] top-[19rem] order-2 w-[31.25rem] flex justify-center min-[950px]:justify-start" style="animation-delay: -1250ms">
                        <div class="w-[clamp(90vw,12.5rem,31.25rem)] min-[950px]:w-[clamp(25vw,12.5rem,31.25rem)] flex justify-center min-[950px]:justify-start">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item','data' => ['subicon' => $skin->dofus_item_cloak_subicon,'subname' => $skin->dofus_item_cloak_subname,'name' => $skin->dofus_item_cloak_name,'level' => $skin->dofus_item_cloak_level,'icon' => $skin->dofus_item_cloak_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['subicon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_subicon),'subname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_subname),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_name),'level' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_level),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <img src="<?php echo e(asset('storage/images/misc_ui/cloak_arrow.png')); ?>" class="absolute min-[950px]:animate-slideY [--custom-translate-y:5px] [--custom-animation-time:5s] invisible min-[950px]:visible top-[-3rem] left-[-9rem]" style="animation-delay: -1250ms">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.basic-views', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/skins/show.blade.php ENDPATH**/ ?>