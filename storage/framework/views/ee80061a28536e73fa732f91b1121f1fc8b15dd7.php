<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Skins en Attente','subtitle' => 'Accepte ou refuse les skins']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Skins en Attente'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Accepte ou refuse les skins')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>


        <div class="grid justify-center grid-cols-[repeat(auto-fill,12.5rem)] p-4 gap-4">
            <?php $__currentLoopData = $skins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $skin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                
                <div
                    wire:key="'skins-validation-<?php echo e($skin->id); ?>-<?php echo e(rand()); ?>'"
                    class="mt-2 flex space-y-2 flex-col"
                    x-data="{
                    open: false,
                    inTransition: false,
                    SwitchOpen(){
                        console.log('SwitchOpen');
                        if(!this.open) {
                            this.open = true;
                            return;
                        }

                        this.open = false;
                        this.inTransition = true;
                        setTimeout(() => { this.inTransition = false }, 700);
                    }
                }"
                    :class="open || inTransition ? 'min-[750px]:col-span-3' : ''"
                >

                    <div class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 items-center">

                        
                        <button
                            class="flex flex-col items-center transition-colors rounded-md"
                            x-on:click="SwitchOpen"
                            :class="open || inTransition ? 'bg-primary-100' : 'hover:bg-primary-100 '"
                        >

                            
                            <div class="flex items-center space-x-2 w-full">
                                <img draggable="false" width="64" src="<?php echo e(asset('storage/' . $skin->race_icon)); ?>">
                                <div class="flex flex-col items-baseline">
                                    <p class="text-inactiveText italic text-sm">ID#<?php echo e($skin->id); ?></p>
                                    <p class="text-xl"><?php echo e($skin->race_name); ?></p>
                                </div>
                            </div>

                            
                            <img draggable="false" width="200" src="<?php echo e(asset('storage/' . $skin->image_path)); ?>">

                            <p class="text-inactiveText italic"><?php echo e($skin->user_name); ?></p>
                        </button>

                        
                        <div class="flex flex-col min-[750px]:flex-row min-[750px]:space-x-2 items-center min-[750px]:h-full max-[749px]:w-full"
                             x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-x-full"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in delay-300 duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0 -translate-x-1/2">

                            
                            <div>

                                <div class="flex gap-x-8 justify-center items-center">
                                    <div class="flex gap-x-2 items-center">
                                        <?php if($skin->gender == 'Femme'): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                            </svg>
                                        <?php else: ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-6" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                                            </svg>
                                        <?php endif; ?>
                                        <p class="text-secondary font-thin text-lg min-[750px]:text-xl"><?php echo e($skin->gender); ?></p>
                                    </div>
                                    <p class="text-secondary font-thin text-lg min-[750px]:text-xl">Visage n°<span class="font-normal"><?php echo e($skin->face); ?></span></p>
                                </div>

                                <div>
                                    <?php if(isset($skin->dofus_item_hat_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item-validation','data' => ['name' => $skin->dofus_item_hat_name,'icon' => $skin->dofus_item_hat_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_name),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_hat_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($skin->dofus_item_cloak_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item-validation','data' => ['name' => $skin->dofus_item_cloak_name,'icon' => $skin->dofus_item_cloak_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_name),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_cloak_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($skin->dofus_item_shield_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item-validation','data' => ['name' => $skin->dofus_item_shield_name,'icon' => $skin->dofus_item_shield_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_name),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_shield_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($skin->dofus_item_pet_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item-validation','data' => ['name' => $skin->dofus_item_pet_name,'icon' => $skin->dofus_item_pet_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_name),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_pet_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($skin->dofus_item_costume_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.item-validation','data' => ['name' => $skin->dofus_item_costume_name,'icon' => $skin->dofus_item_costume_icon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.item-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_name),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->dofus_item_costume_icon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="pl-10 min-[750px]:pl-4 flex flex-col items-start justify-between min-[750px]:h-full max-[749px]:w-full">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['color' => $skin->color_skin,'name' => 'Peau']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->color_skin),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Peau')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['color' => $skin->color_hair,'name' => 'Cheveux']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->color_hair),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Cheveux')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['color' => $skin->color_cloth_1,'name' => 'Habits 1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->color_cloth_1),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Habits 1')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['color' => $skin->color_cloth_2,'name' => 'Habits 2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->color_cloth_2),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Habits 2')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.skins-presentation.color','data' => ['color' => $skin->color_cloth_3,'name' => 'Habits 3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('skins-presentation.color'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skin->color_cloth_3),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Habits 3')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div
                        class="flex flex-col min-[750px]:flex-row max-[749px]:gap-y-2 min-[750px]:gap-x-2 relative pb-8"
                        x-show="open" x-cloak
                        x-transition:enter="transition ease-out delay-300 duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-full"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 -translate-y-1/2">

                        <button wire:click="acceptSkin(<?php echo e($skin->id); ?>)"
                                class="px-4 h-12 text-primary goldGradient transition-all hover:rounded-3xl hover:tracking-widest rounded-md text-md min-[750px]:text-xl hover:brightness-110">Accepter</button>

                        <div class="flex min-[750px]:space-x-2 flex-1" x-data="{ refused_reason: '' }">

                            <button @click="$wire.refuseSkin(refused_reason, <?php echo e($skin->id); ?>), refused_reason = ''" class="px-4 h-12 absolute top-0 right-0 text-primary transition-all hover:rounded-3xl hover:tracking-widest heartGradient rounded-md text-md min-[750px]:text-xl hover:brightness-110 min-[750px]:static">Refuser</button>
                            <textarea
                                type="text" name="reason" placeholder="Raison du refus ..." maxlength="128"
                                class="rounded-md text-md text-secondary placeholder:text-inactiveText bg-primary-100 flex-1 h-12 p-2"
                                x-model="refused_reason"></textarea>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/skins-validation.blade.php ENDPATH**/ ?>