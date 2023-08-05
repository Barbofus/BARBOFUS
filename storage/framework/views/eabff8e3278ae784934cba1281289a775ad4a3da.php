<div>
    <p class="text-lg italic font-thin ml-5 text-secondary"><?php echo e($title); ?></p>
    <div class="flex items-center ml-2 h-8 relative z-10"
         x-data="{
            color: '<?php echo e($value); ?>',
            dark: true,

            IsDark() {

                if(this.color.length < 6) return;

                finalColor = '#' + this.color;

                rgb = finalColor.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(m, r, g, b) => '#' + r + r + g + g + b + b)
                            .substring(1).match(/.{2}/g)
                            .map(x => parseInt(x, 16));

                brightness = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);

                (brightness > 125) ? this.dark = false : this.dark = true;
            },

            changePreviewColor(color){
                if(this.color.length < 6) {
                    $refs.colorPreview.style.backgroundColor = '';
                    return;
                }

                $refs.colorPreview.style.backgroundColor = '#' + color;
                this.IsDark();
            },
            }"
         x-init="changePreviewColor('<?php echo e($value); ?>')">

        <div x-ref="colorPreview" class="aspect-square h-full rounded-md border-2" :class="dark ? 'border-inactiveText' : 'border-primary'"></div>
        <div class="rounded-md ml-2 <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-border <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> flex h-full overflow-hidden">
            <span class="text-xl h-full flex items-center bg-primary-100 transition-all pl-1" :class="color ? 'text-secondary' : 'text-inactiveText'">#</span>
            <input x-model="color" x-on:input.change="changePreviewColor(color)" maxlength="6" type="text" name="<?php echo e($name); ?>" placeholder="FFFFFF" class="pl-1 h-full max-w-[75px] placeholder-inactiveText placeholder:font-thin placeholder:italic font-light uppercase bg-primary-100 focus:outline-none" value="<?php echo e($value); ?>">
        </div>

        <div class="absolute -right-32 top-1 w-full">
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
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/forms/color-input.blade.php ENDPATH**/ ?>