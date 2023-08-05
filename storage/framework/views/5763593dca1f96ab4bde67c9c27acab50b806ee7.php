<div class="-mx-3" x-data="{ text: '<?php echo e((old($name)) ? old($name) : ''); ?>'}">
    <div class="w-[min(90%,350px)] px-3">
        <div class="flex w-full h-12 group rounded-md <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-border <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <input x-model="text" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" type="<?php echo e($type); ?>" maxlength="30"
                   class="h-full peer w-full p-2 pr-3 bg-primary-100 border-y-2 border-r-2 border-primary-100 rounded-r-md outline-none focus:border-goldText placeholder-inactiveText transition-all"
                   placeholder="<?php echo e($placeholder); ?>"
                    <?php echo e($attributes); ?>>

            <div class="order-first relative bg-primary-100 h-full w-12 rounded-l-md p-2 flex justify-between items-center border-y-2 border-l-2 border-primary-100 transition-all peer-focus:border-goldText">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-full h-full transition-all" x-cloak
                     :class="(text) ? 'text-secondary' : 'text-inactiveText'">
                    <?php echo e($slot); ?>

                </svg>


                <div x-cloak
                     class="absolute left-0 border-r-2 w-full h-8 transition-all"
                     :class="(text) ? 'border-secondary' : 'border-inactiveText'"></div>
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
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/forms/text-input.blade.php ENDPATH**/ ?>