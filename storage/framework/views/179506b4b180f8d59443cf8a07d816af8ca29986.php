<div class="text-[1.15rem]">
    <p class="text-ivory font-thin">Recherche un item ou un pseudo :</p>

    <div
        class="w-[90%] -ml-1 relative"
        x-data
        @click.away="<?php echo e((count($itemToShow) > 0) ? '$wire.emptyQuery()' : ''); ?>">
        <input type="text"
               class="border-transparent py-2 pl-4 focus:outline-none rounded-[2.25px] w-full mt-1 bg-primary-100 px-1 placeholder-inactiveText font-thin text-inactiveText"
               placeholder="Nom d'item ou pseudo"
               maxlength="45"
               wire:model="query"
               wire:keydown.arrow-down.prevent="<?php echo e((count($itemToShow) > 0) ? 'incrementSelection' : ''); ?>"
               wire:keydown.arrow-up.prevent="<?php echo e((count($itemToShow) > 0) ? 'decrementSelection' : ''); ?>"
               wire:keydown.tab.prevent="<?php echo e((count($itemToShow) > 0) ? 'incrementSelection' : ''); ?>"
               wire:keydown.enter="<?php echo e((count($itemToShow) > 0) ? '$emit(\'ToggleSearchedText\', \'' . addslashes($itemToShow[$selectionKey]->name) . '\')' : ''); ?>"
               @keydown.enter="window.scrollTo(0,0)">

        <div class="absolute bg-primary-100 max-h-[18.75rem] w-full rounded-sm z-50 overflow-auto">
            <?php $__currentLoopData = $itemToShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    class="flex w-full p-1 items-center group transition-all <?php echo e(($key == $selectionKey) ? 'bg-white bg-opacity-10' : 'hover:bg-white hover:bg-opacity-10'); ?>"
                    wire:click="$emit('ToggleSearchedText', '<?php echo e(addslashes($items->name)); ?>')"
                    @click="window.scrollTo(0,0)">
                    <?php if(@isset($items->icon_path)): ?>
                        <img class="h-10 transition-all <?php echo e(($key == $selectionKey) ? 'scale-110' : 'group-hover:scale-110'); ?>" src="<?php echo e(asset('storage\/'. $items->icon_path)); ?>">
                    <?php else: ?>
                        <svg class="h-10 fill-inactiveText transition-all <?php echo e(($key == $selectionKey) ? 'scale-110' : 'group-hover:scale-110'); ?>" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="-10 -10 80 80" xml:space="preserve">
                            <g><g><ellipse cx="30.336" cy="12.097" rx="11.997" ry="12.097"/><path d="M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9 C48.354,35.818,42.661,30.079,35.64,30.079z"/></g></g>
                        </svg>
                    <?php endif; ?>
                    <p class="font-thin transition-all text-[1rem] ml-2 text-left <?php echo e(($key == $selectionKey) ? '-translate-y-1' : 'group-hover:-translate-y-1'); ?>"><?php echo e($items->name); ?></p>
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="flex flex-wrap justify-start w-full max-h-[7rem] overflow-auto items-center gap-2 mt-2">
            <?php $__currentLoopData = $searchFilterInput; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button wire:click="$emit('ToggleSearchedText', '<?php echo e(addslashes($input)); ?>')"
                        @click="window.scrollTo(0,0)"
                        class="flex justify-between items-center px-2 py-1 bg-black bg-opacity-[0.2] rounded-[2.25px] group hover:bg-opacity-100 hover:bg-primary-100 transition-colors">
                    <p class="font-light text-[1rem] text-inactiveText"><?php echo e($input); ?></p>

                    <!-- Croix -->
                    <svg class="w-4 text-red-500 group-hover:text-red-400 ml-2"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/forms/skin-filter-search-bar.blade.php ENDPATH**/ ?>