

{{-- Vue comprenant  la présentation des builds --}}
<div class="border rounded-xl overflow-hidden">
    <div class="relative">

        {{-- Affiche la bannière en fonction de la classes du build --}}
        <img src="{{ asset('/storage/images/banner/classes/' .$build['build']['race']['banner_path']) }}" alt="{{ $build['build']['race']['name'] }}" class="brightness-[45%] contrast-[120%] group-hover:brightness-[100%] group-hover:contrast-[100%] transition duration-150">
        
        {{-- On passe le reste en absolute pour qu'elles soient sur la bannière --}}
        <div class=" absolute text-white top-0 w-full h-full">
            
            {{-- Affiche le titre --}}
            <div class=" h-[40%] w-full flex items-center justify-center">
                <span class=" text-3xl font-bold">{{ $build['build']['title'] }}</span>
            </div>

            <div class=" h-[60%] w-full flex">
                <div class=" h-full w-[50%]">
                    <div class="flex justify-center h-full p-4">

                        {{-- Affiche le nombre de PA dans son icone --}}
                        <div class="relative w-[50%] h-full flex items-center justify-center">
                            <img src="{{ asset('/storage/images/misc_ui/icon_pa.png') }}" alt="Icone PA" width="70">
                            <span class="absolute text-xl font-bold">{{ $build['build']['ap_nbr'] }}</span>
                        </div>
                        
                        {{-- Affiche le nombre de PM dans son icone --}}
                        <div class="relative w-[50%] h-full flex items-center justify-center">
                            <img src="{{ asset('/storage/images/misc_ui/icon_pm.png') }}" alt="Icone PM" width="70">
                            <span class="absolute text-xl font-bold">{{ $build['build']['mp_nbr'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Affiche les élements du build --}}
                <div class=" h-full w-[50%] backdrop-blur-sm">
                    <div class=" w-full h-[50%] flex items-center justify-end">
                        
                        {{-- Affiche d'abord les 4 élements primordiaux (Terre / Air / Feu / Eau) --}}
                        @foreach ($build['elements'] as $element)
                            @if ($element['is_elemental'] == 1)
                                <img src="{{ asset('/storage/images/icons/elements/' .$element['icon_path']) }}" alt="{{ $element['name'] }}" width="50" height="50">
                            @endif
                        @endforeach
                    </div>

                    <div class=" w-full h-[50%] border-t flex items-center justify-end">
                        
                        {{-- Affiche ensuite les 2 élements secondaires (Do Cri / Do Pou) --}}
                        @foreach ($build['elements'] as $element)
                            @if ($element['is_elemental'] == 0)
                                <img src="{{ asset('/storage/images/icons/elements/' .$element['icon_path']) }}" alt="{{ $element['name'] }}" width="50" height="50">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Affiche le screen DofusRoom du build lui-même --}}
    <img src="{{ asset('/storage/' .$build['build']['image_path']) }}" alt="{{ $build['build']['title'] }}" width="400" height="400" class="h-[400px] w-[400px] object-contain group-hover:grayscale group-hover:brightness-110 transition ease-in duration-150">
</div>