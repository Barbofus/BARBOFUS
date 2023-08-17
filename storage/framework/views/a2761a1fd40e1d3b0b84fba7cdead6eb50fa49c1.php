<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s] min-[800px]:pl-12">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.userpage-title','data' => ['title' => 'Mon compte','subtitle' => 'Configurations et préférences']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.userpage-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Mon compte'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Configurations et préférences')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="w-[80%] min-[800px]:mx-auto flex flex-col min-[1500px]:flex-row gap-x-16 gap-y-16">

            <div class="flex flex-col gap-y-12">
                
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl uppercase">Informations</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    <h2 class="font-light italic text-2xl mt-4 min-[800px]:pl-60"><?php echo e($user->name); ?></h2>

                    <div class="flex flex-col min-[800px]:flex-row gap-y-8 gap-x-8 mt-8 font-light text-xl items-start min-[800px]:items-center min-[800px]:pl-36">
                        <div class="flex flex-col gap-y-4">
                            <p>Inscrit <span class="italic font-normal"><?php echo e($user->created_at->diffForHumans()); ?></span></p>
                            <p><span class="italic tracking-widest font-normal"><?php echo e($user->skin_count); ?></span> skins postés</p>
                            <p><span class="italic tracking-widest font-normal"><?php echo e($user->like_given); ?></span> likes donnés</p>
                            <p><span class="italic tracking-widest font-normal"><?php echo e($user->like_received); ?></span> likes reçus</p>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['mod-access', 'admin-access'])): ?>
                                <p><span class="italic tracking-widest font-normal"><?php echo e(\App\Models\Skin::all()->count()); ?></span> skins total sur le site</p>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-col gap-y-4">
                            <div class="flex gap-x-4 items-center">
                                <img src="<?php echo e(asset('storage/images/misc_ui/dofus_ocre.png')); ?>" class="h-12">
                                <p><span class="italic tracking-widest font-normal"><?php echo e($user->ocre_wins); ?></span> victoires</p>
                            </div>

                            <div class="flex gap-x-4 items-center">
                                <img src="<?php echo e(asset('storage/images/misc_ui/dofus_emeraude.png')); ?>" class="h-12">
                                <p><span class="italic tracking-widest font-normal"><?php echo e($user->emerald_wins); ?></span> victoires</p>
                            </div>

                            <div class="flex gap-x-4 items-center">
                                <img src="<?php echo e(asset('storage/images/misc_ui/dofus_cawotte.png')); ?>" class="h-12">
                                <p><span class="italic tracking-widest font-normal"><?php echo e($user->cawotte_wins); ?></span> victoires</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Préférences</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    <h3 class="font-thin text-xl uppercase mt-6 pl-12">Recevoir un e-mail pour:</h3>

                    <div class="flex flex-col gap-y-6 pt-6 pl-4">
                        <div class="relative w-[min(17rem,80%)]">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.filter-button','data' => ['wire:click' => 'togglePreference(\'mail_skin_validation\', \''.e(($user->mail_skin_validation_preference !== 0)).'\')','checked' => ($user->mail_skin_validation_preference !== 0)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.filter-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'togglePreference(\'mail_skin_validation\', \''.e(($user->mail_skin_validation_preference !== 0)).'\')','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($user->mail_skin_validation_preference !== 0))]); ?><p class="absolute italic font-thin text-secondary text-lg left-7 top-1 cursor-pointer">Validation / Refus d'un skin</p> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        
                    </div>
                </div>

                
                <div>
                    <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Connexions</h2>
                    <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                    
                    <?php if(!isset($discord)): ?>
                        <button wire:click="DiscordConnectionUrl" class="px-4 py-2 ml-8 mt-4 flex items-center bg-[#5865f2] gap-x-4 rounded-md hover:brightness-[1.2] transition-all w-fit group">
                            <img src="<?php echo e(asset('storage/images/misc_ui/logo_discord_white.png')); ?>" class="h-12">
                            <p class="font-thin text-xl text-white group-hover:-translate-y-1 transition-all">Connecte ton discord</p>
                        </button>
                    <?php else: ?>
                        <div class="flex gap-x-4 items-center">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.utils.discord-card','data' => ['discord' => $discord]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('utils.discord-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['discord' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($discord)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                            <button class="pt-4" wire:click="DisconnectDiscord">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-16 hover:scale-125 text-inactiveText hover:text-red-500 transition-all">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div>
                <h2 class="font-thin text-3xl min-[800px]:text-4xl  uppercase">Paramètres</h2>
                <div class="border-b border-secondary w-[min(24rem,50vw)] ml-4"></div>

                <h3 class="font-thin text-2xl uppercase mt-8 pl-12">Changer de mot de passe</h3>

                <form wire:submit.prevent="ChangeUserPassword" class="flex flex-col gap-y-4 mt-4 pl-4">

                    
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.text-input','data' => ['autocomplete' => 'false','wire:model' => 'current_password','placeholder' => 'Ancien Mot de passe','type' => 'password','name' => 'current_password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'false','wire:model' => 'current_password','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Ancien Mot de passe'),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('password'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('current_password')]); ?>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.text-input','data' => ['autocomplete' => 'false','wire:model' => 'password','placeholder' => 'Nouveau Mot de passe','type' => 'password','name' => 'password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'false','wire:model' => 'password','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Nouveau Mot de passe'),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('password'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('password')]); ?>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.text-input','data' => ['autocomplete' => 'false','wire:model' => 'password_confirmation','placeholder' => 'Confirmation','type' => 'password','name' => 'password_confirmation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'false','wire:model' => 'password_confirmation','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Confirmation'),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('password'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('password_confirmation')]); ?>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Enregistrer <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </form>

                <h3 class="font-thin text-2xl uppercase pl-12">Changer de pseudo</h3>

                
                <form wire:submit.prevent="ChangeUsername" class="flex flex-col gap-y-4 mt-4 pl-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.text-input','data' => ['autocomplete' => 'true','wire:model' => 'name','placeholder' => 'Nouveau Pseudo','type' => 'text','name' => 'name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'true','wire:model' => 'name','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Nouveau Pseudo'),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('name')]); ?>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Enregistrer <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </form>

                <h3 class="font-thin text-2xl uppercase pl-12">Changer d'adresse e-mail</h3>

                <p class="font-light text-lg mt-2 mb-4 italic text-secondary pl-8 indent-12">(Attention! Vous serez déconnecté et devrez valider l'E-mail)</p>

                
                <form wire:submit.prevent="ChangeUserEMail" class="flex flex-col gap-y-4 mt-4 pl-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.text-input','data' => ['autocomplete' => 'true','wire:model' => 'email','placeholder' => 'Nouveau E-mail','type' => 'email','name' => 'email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'true','wire:model' => 'email','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Nouveau E-mail'),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('email'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('email')]); ?>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Enregistrer <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Travail\Web\_Servers\BARBOFUS\resources\views/livewire/user-panel/user-details.blade.php ENDPATH**/ ?>