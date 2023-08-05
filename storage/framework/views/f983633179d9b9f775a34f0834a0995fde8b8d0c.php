<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['needDofusUpdate' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['needDofusUpdate' => false]); ?>
<?php foreach (array_filter((['needDofusUpdate' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]"
         x-data="{
        loading: false
    }">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Panel Administrateur','subtitle' => 'Gestion de l\'API DofusDB']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Panel Administrateur'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Gestion de l\'API DofusDB')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="flex justify-center w-full mt-16">

            <?php if($needDofusUpdate): ?>
                <a  href="<?php echo e(route('dofusDBApi')); ?>"
                    class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110"
                    x-on:click="loading = true">Récupérer les items</a>
            <?php else: ?>
                <div class="w-48 p-4 text-2xl text-primary text-center font-light rounded-md bg-inactiveText">API DofusDB à jour</div>
            <?php endif; ?>

        </div>

        <div class="flex flex-col gap-y-2 items-center mt-10"
             x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-full"
             x-transition:enter-end="opacity-100">
            <img class="animate-pulseFast h-32 w-32 opacity-25" src="<?php echo e(asset('storage/images/misc_ui/logo_barbe_x256.png')); ?>" draggable="false">
            <p class="text-2xl text-secondary animate-pulseFast opacity-25 font-light">Récupération des items</p>
        </div>

        <h2 class="text-2xl font-thin text-center mt-16 mb-8 uppercase">Gestion du miss'skin</h2>

        <div class="w-full flex justify-center">
            <?php if(session('miss-skin')): ?>
                <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600"><?php echo e(session('miss-skin')); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex justify-center w-full mt-8">
            <a  href="<?php echo e(route('miss-skin')); ?>"
                class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110">Lancer le concours</a>
        </div>

    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/user-panel/admin-panel.blade.php ENDPATH**/ ?>