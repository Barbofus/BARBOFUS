<div>
    <div class="grid grid-cols-1 grid-rows-[34.375rem,37.5rem,32.5rem] gap-4
            md:grid-cols-[18.75rem,18.75rem] md:grid-rows-[35rem,18rem]
            lg:grid-cols-[18.75rem,40.625rem] lg:grid-rows-[23rem,18rem]">
        
        <div class="lg:row-span-2 flex items-center gap-4 flex-col p-2">

            
            <div x-data="{
                finaleUrl: '<?php echo e(isset($skin) ? asset('storage/' . $skin['image_path']) : ''); ?>',

                ChangeFile(event) {
                    this.FileToDataUrl(event, src => this.finaleUrl = src)
                },

                FileToDataUrl(event, callback) {
                    if (! event.target.files.length) return

                    let file = event.target.files[0],
                    reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                }
            }">
                <p class="ml-10 text-xl font-light">Image du skin</p>
                <div class="mt-2 <?php $__errorArgs = ['image_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-border <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <input x-on:input.change="ChangeFile" class="w-[min(18.75rem,90vw)] text-inactiveText rounded-md cursor-pointer bg-primary-100 focus:outline-none file:goldGradient file:text-primary file:h-10 file:border-0 hover:file:brightness-110 file:cursor-pointer" type="file" name="image_path" accept="image/png">
                    <p class="mt-1 ml-8 text-sm text-inactiveText" id="file_input_help">Export PNG de DofusBook<br> (MAX. 350x450px, 100ko).</p>
                </div>

                <div class="flex justify-center"><img x-show="finaleUrl" x-cloak x-transition class="mt-4" width="200" height="260" :src="finaleUrl" draggable="false"/></div>

                <?php $__errorArgs = ['image_path'];
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

            
            <?php if(isset($skin) && $skin['status'] == 'Refused'): ?>
                <div class="bg-red-300 border border-red-500 h-[clamp(6rem,8rem)] p-4 rounded-md text-red-900 max-w-[18.75rem] flex flex-col items-center justify-center order-first md:order-2">
                    <p class="font-light">Ton skin a été refusé <span><?php echo e($skin['refused_reason'] ? ' car' : '!'); ?></span></p>
                    <p class="font-normal italic break-words max-w-full"><?php echo e($skin['refused_reason']); ?></p>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="p-2">
            <div class="flex flex-col items-start lg:flex-row gap-4">

                
                <div>
                    <p class="text-xl ml-10 font-light">Choix du sexe</p>
                    <div class="flex gap-x-4">

                        <div>
                            <input id="male" name="gender" type="radio" value="Homme" class="hidden peer" checked>
                            <label for="male" class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-full" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                                </svg>
                                <p>Homme</p>
                            </label>
                        </div>

                        <div>
                            <input id="female" name="gender" type="radio" value="Femme" class="hidden peer"
                                <?php echo e((old('gender')) ? ((old('gender') == 'Femme') ? 'checked' : '') : (isset($skin) ? (($skin['gender'] == 'Femme') ? 'checked' : '') : '')); ?>>
                            <label for="female" class="flex transition-all rounded-md items-center justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-goldText hover:border-inactiveText cursor-pointer w-32 h-12 bg-primary-100 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                </svg>
                                <p>Femme</p>
                            </label>
                        </div>
                    </div>
                    <?php $__errorArgs = ['gender'];
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

                    
                    <div class="mt-5">
                        <p class="ml-10 text-xl font-light">Choix de la classe</p>
                        <div class="relative"
                             x-data="{
                                  races: <?php echo e(json_encode(array_values($races))); ?>,
                                  showSort: false,
                                  selection: <?php echo e((old('race_id')) ? old('race_id') : (isset($skin) ? $skin['race_id'] : 1)); ?>,
                                }" x-init="console.log(races)">
                            <div x-on:mousedown.outside="if(showSort) showSort = false">

                                <!-- Resultat -->
                                <div x-on:mousedown="showSort = !showSort"
                                     class="flex transition-all rounded-md w-[15rem] items-center justify-left gap-x-2 border-2 text-secondary border-goldText hover:border-secondary cursor-pointer h-12 bg-primary-100 p-2">
                                    <img :src="races[selection-1]['ghost_icon_path']" class="h-11">
                                    <p x-text="races[selection-1]['name']"></p>
                                </div>

                                <!-- Menu déroulant -->
                                <div class="left-0 top-12 w-[15rem] max-h-[18.75rem] overflow-auto rounded-b-md z-50 absolute bg-primary-100 text-[1rem] font-light transition-all duration-200 cursor-pointer "
                                     x-show="showSort" x-transition.opacity x-cloak >
                                    <?php $__currentLoopData = $races; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $race): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <input type="radio" value="<?php echo e($race->id); ?>" class="hidden peer" name="race_id" id="race_id_<?php echo e($race->id); ?>"
                                                <?php echo e((old('race_id')) ? ((old('race_id') == $race->id) ? 'checked' : '') : (isset($skin) ? (($skin['race_id'] == $race->id) ? 'checked' : '') : (($race->id == 1) ? 'checked' : ''))); ?>>
                                            <label for="race_id_<?php echo e($race->id); ?>"
                                                   @click="selection = <?php echo e($race->id); ?>, showSort = false"
                                                   class="flex rounded-md items-center transition-all justify-left gap-x-2 text-inactiveText border-2 border-primary-100 peer-checked:text-secondary peer-checked:border-secondary hover:border-inactiveText cursor-pointer h-12 bg-primary-100 p-2">
                                                <img src="<?php echo e($race->ghost_icon_path); ?>" class="h-11">
                                                <p><?php echo e($race->name); ?></p>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php $__errorArgs = ['race_id'];
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

                    
                    <p class="mt-5 ml-10 text-xl font-light">Choix du visage</p>
                    <div class="grid grid-cols-4 gap-4 mt-4 w-fit">
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <label class="w-12 h-12">
                                <input type="radio" name="face" value="<?php echo e($i); ?>" class="absolute opacity-0 peer"
                                    <?php echo e((old('face')) ? ((old('face') == $i) ? 'checked' : '') : (isset($skin) ? ($skin['face'] == $i ? 'checked' : '') : (($i == 1) ? 'checked' : ''))); ?>>
                                <div class="flex rounded-md items-center justify-center w-full h-full text-3xl bg-primary-100 border-2 border-inactiveText cursor-pointer hover:border-secondary peer-checked:border-goldText"><?php echo e($i); ?></div>
                            </label>
                        <?php endfor; ?>
                    </div>
                    <?php $__errorArgs = ['face'];
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

                
                <div class="lg:ml-10">
                    <p class="text-xl ml-10 font-light">Choix des couleurs</p>

                    <div class="grid grid-flow-row grid-cols-2 gap-4
                        lg:grid-cols-1">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.color-input','data' => ['title' => 'Peau:','name' => 'color_skin','value' => ''.e((old('color_skin')) ? (old('color_skin')) : (isset($skin) ? $skin['color_skin'] : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.color-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Peau:','name' => 'color_skin','value' => ''.e((old('color_skin')) ? (old('color_skin')) : (isset($skin) ? $skin['color_skin'] : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.color-input','data' => ['title' => 'Cheveux:','name' => 'color_hair','value' => ''.e((old('color_hair')) ? (old('color_hair')) : (isset($skin) ? $skin['color_hair'] : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.color-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Cheveux:','name' => 'color_hair','value' => ''.e((old('color_hair')) ? (old('color_hair')) : (isset($skin) ? $skin['color_hair'] : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.color-input','data' => ['title' => 'Habits 1:','name' => 'color_cloth_1','value' => ''.e((old('color_cloth_1')) ? (old('color_cloth_1')) : (isset($skin) ? $skin['color_cloth_1'] : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.color-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Habits 1:','name' => 'color_cloth_1','value' => ''.e((old('color_cloth_1')) ? (old('color_cloth_1')) : (isset($skin) ? $skin['color_cloth_1'] : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.color-input','data' => ['title' => 'Habits 2:','name' => 'color_cloth_2','value' => ''.e((old('color_cloth_2')) ? (old('color_cloth_2')) : (isset($skin) ? $skin['color_cloth_2'] : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.color-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Habits 2:','name' => 'color_cloth_2','value' => ''.e((old('color_cloth_2')) ? (old('color_cloth_2')) : (isset($skin) ? $skin['color_cloth_2'] : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.color-input','data' => ['title' => 'Habits 3:','name' => 'color_cloth_3','value' => ''.e((old('color_cloth_3')) ? (old('color_cloth_3')) : (isset($skin) ? $skin['color_cloth_3'] : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.color-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Habits 3:','name' => 'color_cloth_3','value' => ''.e((old('color_cloth_3')) ? (old('color_cloth_3')) : (isset($skin) ? $skin['color_cloth_3'] : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="p-2
                    md:col-span-2 md:row-start-2
                    lg:col-start-2">
            <p class="text-xl ml-10 font-light">Choix des items</p>
            <div class="grid grid-flow-row grid-cols-1 gap-4
                        md:grid-cols-2">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_hats','name' => 'dofus_item_hat_id','placeholder' => 'Choisis une coiffe...','value' => (old('dofus_item_hat_id')) ? old('dofus_item_hat_id') : (isset($skin) ? $skin['dofus_item_hat_id']: '')])->html();
} elseif ($_instance->childHasBeenRendered('kcHReU9')) {
    $componentId = $_instance->getRenderedChildComponentId('kcHReU9');
    $componentTag = $_instance->getRenderedChildComponentTagName('kcHReU9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kcHReU9');
} else {
    $response = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_hats','name' => 'dofus_item_hat_id','placeholder' => 'Choisis une coiffe...','value' => (old('dofus_item_hat_id')) ? old('dofus_item_hat_id') : (isset($skin) ? $skin['dofus_item_hat_id']: '')]);
    $html = $response->html();
    $_instance->logRenderedChild('kcHReU9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_cloaks','name' => 'dofus_item_cloak_id','placeholder' => 'Choisis une cape...','value' => (old('dofus_item_cloak_id')) ? old('dofus_item_cloak_id') : (isset($skin) ? $skin['dofus_item_cloak_id']: '')])->html();
} elseif ($_instance->childHasBeenRendered('ZgCchE5')) {
    $componentId = $_instance->getRenderedChildComponentId('ZgCchE5');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZgCchE5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZgCchE5');
} else {
    $response = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_cloaks','name' => 'dofus_item_cloak_id','placeholder' => 'Choisis une cape...','value' => (old('dofus_item_cloak_id')) ? old('dofus_item_cloak_id') : (isset($skin) ? $skin['dofus_item_cloak_id']: '')]);
    $html = $response->html();
    $_instance->logRenderedChild('ZgCchE5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_shields','name' => 'dofus_item_shield_id','placeholder' => 'Choisis un bouclier...','value' => (old('dofus_item_shield_id')) ? old('dofus_item_shield_id') : (isset($skin) ? $skin['dofus_item_shield_id']: '')])->html();
} elseif ($_instance->childHasBeenRendered('NO45s6i')) {
    $componentId = $_instance->getRenderedChildComponentId('NO45s6i');
    $componentTag = $_instance->getRenderedChildComponentTagName('NO45s6i');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('NO45s6i');
} else {
    $response = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_shields','name' => 'dofus_item_shield_id','placeholder' => 'Choisis un bouclier...','value' => (old('dofus_item_shield_id')) ? old('dofus_item_shield_id') : (isset($skin) ? $skin['dofus_item_shield_id']: '')]);
    $html = $response->html();
    $_instance->logRenderedChild('NO45s6i', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_pets','name' => 'dofus_item_pet_id','placeholder' => 'Choisis un familier...','value' => (old('dofus_item_pet_id')) ? old('dofus_item_pet_id') : (isset($skin) ? $skin['dofus_item_pet_id']: '')])->html();
} elseif ($_instance->childHasBeenRendered('FgHVfkP')) {
    $componentId = $_instance->getRenderedChildComponentId('FgHVfkP');
    $componentTag = $_instance->getRenderedChildComponentTagName('FgHVfkP');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FgHVfkP');
} else {
    $response = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_pets','name' => 'dofus_item_pet_id','placeholder' => 'Choisis un familier...','value' => (old('dofus_item_pet_id')) ? old('dofus_item_pet_id') : (isset($skin) ? $skin['dofus_item_pet_id']: '')]);
    $html = $response->html();
    $_instance->logRenderedChild('FgHVfkP', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_costumes','name' => 'dofus_item_costume_id','placeholder' => 'Choisis un costume...','value' => (old('dofus_item_costume_id')) ? old('dofus_item_costume_id') : (isset($skin) ? $skin['dofus_item_costume_id']: '')])->html();
} elseif ($_instance->childHasBeenRendered('qRphbL3')) {
    $componentId = $_instance->getRenderedChildComponentId('qRphbL3');
    $componentTag = $_instance->getRenderedChildComponentTagName('qRphbL3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qRphbL3');
} else {
    $response = \Livewire\Livewire::mount('forms.searchbar-items-autocomplete', ['relatedModel' => 'dofus_item_costumes','name' => 'dofus_item_costume_id','placeholder' => 'Choisis un costume...','value' => (old('dofus_item_costume_id')) ? old('dofus_item_costume_id') : (isset($skin) ? $skin['dofus_item_costume_id']: '')]);
    $html = $response->html();
    $_instance->logRenderedChild('qRphbL3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        </div>
    </div>

    
    <div class="mt-8">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Valider <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/components/forms/skin-form.blade.php ENDPATH**/ ?>