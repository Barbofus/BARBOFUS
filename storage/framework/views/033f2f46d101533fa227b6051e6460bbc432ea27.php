<!-- En-tête -->
<div id="header"
     class="w-full h-0 bg-secondary relative z-20 invisible [@media(min-height:950px)_and_(min-width:901px)]
          [@media(min-height:950px)_and_(min-width:901px)]:visible [@media(min-height:950px)_and_(min-width:901px)]:h-[15vh] [@media(min-height:950px)_and_(min-width:901px)]:min-h-[150px] overflow-hidden">

    
    <div class="absolute w-full h-full flex items-center justify-center bg-primary">
        <div class="w-[min(100vw,1500px)] relative">

            
            <img src="<?php echo e(asset('storage/images/misc_ui/Barbofus_Logo_Background.jpg')); ?>" class="animate-slideY [--custom-translate-y:-35px] [--custom-animation-time:20s]">

            
            <div class="bg-gradient-to-r from-primary via-primary to-transparent h-full w-[300px] absolute left-0 top-0 z-10"></div>
            <div class="bg-gradient-to-l from-primary via-primary to-transparent h-full w-[300px] absolute right-0 top-0 z-10"></div>
        </div>
    </div>

    
    <div class="flex h-full justify-center z-10 relative">
        <div class="max-w-1/2 h-full flex justify-center relative overflow-hidden">

            
            <div class="bg-[linear-gradient(90deg,transparent_0%,rgba(0,0,0,0.65)_25%,rgba(0,0,0,.65)_75%,transparent_100%)] via-primary h-full w-full absolute -z-10"></div>

            
            <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('storage/images/misc_ui/Barbofus_Logo.png')); ?>" class="h-full" draggable="false" /></a>
        </div>
    </div>

    
    <div class="h-[min(2vw,30%)] w-1/2 absolute bottom-[-1px] left-0 z-10">

        
        <div class="h-full w-full bg-secondary [clip-path:polygon(0%_0%,100%_80%,100%_100%,0%_100%)] js-slope"></div>

        
        <img src="<?php echo e(asset('storage/images/misc_ui/dofus_ocre.png')); ?>" draggable="false" class="js-subject absolute h-20 right-[min(calc(65%+71px),571px)] bottom-0 translate-y-[2px] rotate-45 opacity-0">
        <img src="<?php echo e(asset('storage/images/misc_ui/dofus_emeraude.png')); ?>" draggable="false" class="js-subject absolute h-20 right-[min(65%,500px)] bottom-0 translate-y-[11px] rotate-[115deg] opacity-0">

        <img src="<?php echo e(asset('storage/images/misc_ui/tofu.png')); ?>" draggable="false" class="js-subject absolute h-16 right-[750px] bottom-0 -translate-y-[40px] opacity-0">
    </div>

    
    <div class="h-[min(2vw,30%)] w-[calc(50%+1px)] absolute bottom-[-1px] right-0 z-10">

        
        <div class="h-full w-full bg-secondary [clip-path:polygon(0%_80%,100%_0%,100%_100%,0%_100%)]"></div>

        
        <img src="<?php echo e(asset('storage/images/misc_ui/dofus_cawotte.png')); ?>" draggable="false" class="js-subject-r absolute h-20 left-[650px] bottom-0 translate-y-[1px] -rotate-[25deg] opacity-0">

        <img src="<?php echo e(asset('storage/images/misc_ui/champchamp.png')); ?>" draggable="false" class="js-subject-r absolute h-[4.5rem] scale-x-[-1] left-[min(70%,400px)] bottom-0 translate-y-[14px] opacity-0">
        <img src="<?php echo e(asset('storage/images/misc_ui/wabbit.png')); ?>" draggable="false" class="js-subject-r absolute h-16 left-[600px] bottom-0 translate-y-[19px] opacity-0">
    </div>

    
    <div class="relative z-10">
    </div>

    <div class="opacity-0">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.twitch-embed','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.twitch-embed'); ?>
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

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/header/OnSlope.js'); ?>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/main-header.blade.php ENDPATH**/ ?>