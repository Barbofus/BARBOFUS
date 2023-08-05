<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]"
        x-data="{deleteID: null, deleteUserName: ''}">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Utilisateurs','subtitle' => 'Choix des rôles / ban']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Utilisateurs'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Choix des rôles / ban')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>


        <div class="w-1/2 mx-auto">
            <div class="flex gap-x-8 mb-8 items-center">
                <input type="text"
                       class="py-2 pl-4 focus:outline-none rounded-3xl w-1/2 bg-primary-100 px-4 font-light text-xl placeholder:text-inactiveText text-secondary"
                       maxlength="45"
                       placeholder="Recherche un pseudo"
                       wire:model.debounce.500ms="query">

                <p class="text-lg text-secondary font-light italic py-2"><?php echo e(count($users)); ?> utilisateurs trouvés</p>
            </div>

            <table class="text-secondary table-auto text-left w-full">
                <thead class="flex w-full mb-8">
                    <tr class="flex justify-between pl-[5%] pr-[5%] py-2 gap-x-8 w-full border-b border-secondary">
                        <th class="text-2xl font-normal w-full">Pseudo</th>
                        <th class="text-2xl font-normal w-[12.5rem]">Rôle</th>
                        <th class="text-2xl font-normal">Supprimer</th>
                    </tr>
                </thead>
                <tbody class="flex flex-col overflow-y-scroll w-full h-[45vh]">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="odd:bg-primary-100 flex justify-between gap-x-8 items-center px-12 py-4">
                            <td class="font-light text-xl w-full"><?php echo e($user->name); ?></td>
                            <td>
                                <div x-data="{ showRoles: false, }" class="relative w-[12.5rem]"
                                     x-on:mousedown.outside="if(showRoles) showRoles = false">

                                    <!-- Trier par: Texte -->
                                    <button @click="showRoles = !showRoles" class="font-normal px-4 py-2 w-full text-primary text-center rounded-full text-lg <?php echo e(($user->role_id == 1) ? 'cawotteGradient' : (($user->role_id == 2) ? 'emeraldGradient' : 'goldGradient')); ?> cursor-pointer hover:brightness-110 hover:tracking-wider transition-all"><?php echo e($user->role_name); ?></button>

                                    <!-- Menu déroulant -->
                                    <div class="w-full h-screen top-16 left-0 rounded-md z-50 absolute bg-primary p-4 flex flex-col gap-y-2"
                                         x-show="showRoles"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 -translate-y-48"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-out duration-300"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0 -translate-y-48">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button class="font-normal px-4 py-2 w-full text-primary text-center rounded-full text-lg <?php echo e(($role->id == 1) ? 'cawotteGradient' : (($role->id == 2) ? 'emeraldGradient' : 'goldGradient')); ?> hover:bg-inactiveText cursor-pointer hover:brightness-110 hover:tracking-wider transition-all" @click="showRoles = false" wire:click="ChangeRole(<?php echo e($user->id); ?>, <?php echo e($role->id); ?>)">
                                                <?php echo e($role->name); ?>

                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="text-inactiveText hover:text-red-500 transition-all" @click="deleteID = <?php echo e($user->id); ?>, deleteUserName = '<?php echo e(addslashes($user->name)); ?>'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="fixed top-0 right-0 bottom-0 left-0"
             x-show="deleteID"  x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-full"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-full">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.user-delete-verification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.user-delete-verification'); ?>
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
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/users-list.blade.php ENDPATH**/ ?>