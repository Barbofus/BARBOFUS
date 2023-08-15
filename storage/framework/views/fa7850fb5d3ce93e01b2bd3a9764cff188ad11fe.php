<div class="relative">
    <div class="flex items-center h-6 space-x-2 text-inactiveText">
        <?php if($existentItem && count($existentItem) > 0): ?>
            <img class="h-full" src="<?php echo e(asset('storage\\'.$existentItem['sub_icon_path'])); ?>" draggable="false">
            <p><?php echo e($existentItem['sub_name']); ?></p>
            <p>Lvl. <?php echo e($existentItem['level']); ?></p>
        <?php endif; ?>
    </div>

    <div class="w-[min(90vw,300px)]">

        
        <div class="relative w-full h-12"
            x-data="{show: false}"
            @mousedown.away="show = false">
            <label for="<?php echo e($name); ?>">
                <img class="absolute h-full" src="<?php echo e(($existentItem && count($existentItem) > 0) ? asset('storage/'.$existentItem['icon_path']) : ''); ?>" draggable="false">
                <input x-ref="input"
                    maxlength="30" id="<?php echo e($name); ?>" type="text" placeholder="<?php echo e($placeholder); ?>"
                    class="w-full h-full rounded-md pl-14 focus:outline-none placeholder-inactiveText bg-primary-100 <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-border <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e($value); ?>"
                    wire:model="query"
                    wire:keydown.arrow-down.prevent="<?php echo e((count($items) > 0) ? 'incrementSelection' : ''); ?>"
                    wire:keydown.arrow-up.prevent="<?php echo e((count($items) > 0) ? 'decrementSelection' : ''); ?>"
                    wire:keydown.enter="<?php echo e(count($items) > 0 ? 'useSelectionAsValue' : ''); ?>"
                    wire:keydown.tab.prevent="<?php echo e((count($items) > 0) ? 'incrementSelection' : ''); ?>"
                    @mousedown="show = true"
                    @focusin="show = true"
                    @keydown.enter.prevent="show = false, $refs.input.blur()"/>
                <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e(($existentItem && count($existentItem) > 0) ? $existentItem['id'] : null); ?>" />
            </label>

            
            <div class="h-72 w-full absolute" x-show="show">

                <div class="absolute bg-primary-100 z-50 w-full max-h-60 overflow-y-auto">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            type="button"
                            class="flex w-full rounded-md items-center transition-all border-2 h-12 space-x-2 cursor-pointer <?php echo e(($selectedItem === $key) ? 'border-secondary text-secondary font-normal' : 'hover:border-inactiveText border-primary-100 text-inactiveText font-light'); ?>"
                            wire:click="setSelection(<?php echo e($key); ?>)"
                            @click="show = false">

                            <img draggable="false" class="h-full select-none" src="<?php echo e(asset('storage\\'. $item->icon_path)); ?>" alt="">
                            <p class="select-none"><?php echo e($item->name); ?></p>
                        </button>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.requirements-error','data' => ['message' => $message]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.requirements-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($message)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/forms/searchbar-items-autocomplete.blade.php ENDPATH**/ ?>