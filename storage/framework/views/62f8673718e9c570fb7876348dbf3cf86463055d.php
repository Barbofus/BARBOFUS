<div class="flex justify-center mt-20 mb-10">

    
    <div
        class="w-[100vw] px-6 min-[1550px]:w-[80vw] relative flex gap-x-2" x-cloak
        x-data="{
            currentPage: '<?php echo e((session()->has('section')) ? session('section') : 'user-details'); ?>',
            initButtonClass: 'border-b-2 transition-all text-inactiveText border-primary px-2 min-[1250px]:px-6 h-[4rem] flex gap-x-2 items-center text-left text-xl w-full hover:bg-primary-100 hover:text-secondary fill-inactiveText group',
            activeButtonClass: 'border-b-2 transition-all px-2 min-[1250px]:px-6 h-[4rem] flex gap-x-2 items-center text-left w-full font-normal border-secondary text-secondary text-2xl fill-secondary',
            initTextClass: 'absolute invisible min-[1250px]:visible min-[1250px]:static transition-transform group-hover:-skew-x-12',

        }">

        
        <div class="min-[1250px]:w-[20rem] max-h-[25rem] font-light sticky top-32">

            <button wire:click="$set('section', 'user-details')" @click="currentPage = 'user-details', window.scrollTo(0,0)" :class="(currentPage == 'user-details') ? activeButtonClass : initButtonClass" x-cloak>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                </svg>


                <p :class="initTextClass">Détails du compte</p>
            </button>

            <button wire:click="ChangeSection('my-skins')" @click="currentPage = 'my-skins', window.scrollTo(0,0)" :class="(currentPage == 'my-skins') ? activeButtonClass : initButtonClass" x-cloak>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M20.599 1.5c-.376 0-.743.111-1.055.32l-5.08 3.385a18.747 18.747 0 00-3.471 2.987 10.04 10.04 0 014.815 4.815 18.748 18.748 0 002.987-3.472l3.386-5.079A1.902 1.902 0 0020.599 1.5zm-8.3 14.025a18.76 18.76 0 001.896-1.207 8.026 8.026 0 00-4.513-4.513A18.75 18.75 0 008.475 11.7l-.278.5a5.26 5.26 0 013.601 3.602l.502-.278zM6.75 13.5A3.75 3.75 0 003 17.25a1.5 1.5 0 01-1.601 1.497.75.75 0 00-.7 1.123 5.25 5.25 0 009.8-2.62 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                </svg>



                <p :class="initTextClass">Mes Skins</p>
            </button>

            <button wire:click="ChangeSection('my-likes')" @click="currentPage = 'my-likes', window.scrollTo(0,0)" :class="(currentPage == 'my-likes') ? activeButtonClass : initButtonClass" x-cloak>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg>

                <p :class="initTextClass">Mes Likes</p>
            </button>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('validate-skin')): ?>
                <button wire:click="$set('section', 'skins-validation')" @click="currentPage = 'skins-validation', window.scrollTo(0,0)" :class="(currentPage == 'skins-validation') ? activeButtonClass : initButtonClass" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                    </svg>

                    <p :class="initTextClass">Skins en attente</p>
                </button>
            <?php endif; ?>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-access')): ?>

                <button wire:click="$set('section', 'users-list')" @click="currentPage = 'users-list', window.scrollTo(0,0)" :class="(currentPage == 'users-list') ? activeButtonClass : initButtonClass" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                    </svg>


                    <p :class="initTextClass">Liste des utilisateurs</p>
                </button>


                <button wire:click="$set('section', 'admin-panel')" @click="currentPage = 'admin-panel', window.scrollTo(0,0)" :class="(currentPage == 'admin-panel') ? activeButtonClass : initButtonClass" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                    </svg>

                    <p :class="initTextClass">Panel administrateur</p>
                </button>
            <?php endif; ?>
        </div>

        <div class="min-h-[50vh] flex-grow relative">

            
            <div wire:loading.delay class="h-screen w-[calc(80vw-20rem)] fixed top-0 z-10">
                <div class="flex flex-col items-center justify-center gap-y-4 min-h-screen bg-primary
                 opacity-0 animate-opacityFade [--custom-animation-time:100ms]">
                    <img class="animate-pulseFast h-32 w-32 opacity-25" src="<?php echo e(asset('storage/images/misc_ui/logo_barbe_x256.png')); ?>" draggable="false">
                    <h1 class="animate-pulseFast opacity-25 text-[min(3.5rem,max(5vw,1.5rem))] font-normal text-center">Chargement ...</h1>
                </div>
            </div>

            <?php switch($section):
                case ('user-details'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.user-details', [])->html();
} elseif ($_instance->childHasBeenRendered('user-details-<?php echo e(rand()); ?>')) {
    $componentId = $_instance->getRenderedChildComponentId('user-details-<?php echo e(rand()); ?>');
    $componentTag = $_instance->getRenderedChildComponentTagName('user-details-<?php echo e(rand()); ?>');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('user-details-<?php echo e(rand()); ?>');
} else {
    $response = \Livewire\Livewire::mount('user-panel.user-details', []);
    $html = $response->html();
    $_instance->logRenderedChild('user-details-<?php echo e(rand()); ?>', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php break; ?>

                <?php case ('my-skins'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.myskins-infinite-load', [])->html();
} elseif ($_instance->childHasBeenRendered('my-skins-<?php echo e(rand()); ?>')) {
    $componentId = $_instance->getRenderedChildComponentId('my-skins-<?php echo e(rand()); ?>');
    $componentTag = $_instance->getRenderedChildComponentTagName('my-skins-<?php echo e(rand()); ?>');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('my-skins-<?php echo e(rand()); ?>');
} else {
    $response = \Livewire\Livewire::mount('user-panel.myskins-infinite-load', []);
    $html = $response->html();
    $_instance->logRenderedChild('my-skins-<?php echo e(rand()); ?>', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php break; ?>

                <?php case ('my-likes'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.mylikes-infinite-load', [])->html();
} elseif ($_instance->childHasBeenRendered('my-likes-<?php echo e(rand()); ?>')) {
    $componentId = $_instance->getRenderedChildComponentId('my-likes-<?php echo e(rand()); ?>');
    $componentTag = $_instance->getRenderedChildComponentTagName('my-likes-<?php echo e(rand()); ?>');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('my-likes-<?php echo e(rand()); ?>');
} else {
    $response = \Livewire\Livewire::mount('user-panel.mylikes-infinite-load', []);
    $html = $response->html();
    $_instance->logRenderedChild('my-likes-<?php echo e(rand()); ?>', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php break; ?>

                <?php case ('skins-validation'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('validate-skin')): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.skins-validation', [])->html();
} elseif ($_instance->childHasBeenRendered('skins-validation-<?php echo e(rand()); ?>')) {
    $componentId = $_instance->getRenderedChildComponentId('skins-validation-<?php echo e(rand()); ?>');
    $componentTag = $_instance->getRenderedChildComponentTagName('skins-validation-<?php echo e(rand()); ?>');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('skins-validation-<?php echo e(rand()); ?>');
} else {
    $response = \Livewire\Livewire::mount('user-panel.skins-validation', []);
    $html = $response->html();
    $_instance->logRenderedChild('skins-validation-<?php echo e(rand()); ?>', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php break; ?>

                <?php case ('users-list'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-access')): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-panel.users-list', [])->html();
} elseif ($_instance->childHasBeenRendered('users-list-<?php echo e(rand()); ?>')) {
    $componentId = $_instance->getRenderedChildComponentId('users-list-<?php echo e(rand()); ?>');
    $componentTag = $_instance->getRenderedChildComponentTagName('users-list-<?php echo e(rand()); ?>');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('users-list-<?php echo e(rand()); ?>');
} else {
    $response = \Livewire\Livewire::mount('user-panel.users-list', []);
    $html = $response->html();
    $_instance->logRenderedChild('users-list-<?php echo e(rand()); ?>', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                    <?php break; ?>

                <?php case ('admin-panel'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-access')): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-panel.admin-panel','data' => ['needDofusUpdate' => (new \App\Actions\DofusDBApi\CheckDofusDBUpdate)()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('user-panel.admin-panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['need-dofus-update' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((new \App\Actions\DofusDBApi\CheckDofusDBUpdate)())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php break; ?>

            <?php endswitch; ?>

        </div>
    </div>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/skins/NameScroll.js', 'resources/js/skins/AnimationsManager.js']); ?>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/user-dashboard.blade.php ENDPATH**/ ?>