<div>
    <div class="animate-topFade [--custom-translate-y:50px] [--custom-animation-time:0.3s]"
         x-data="{
        loading: false
    }">
        <x-utils.userpage-title :title="'Panel Administrateur'" :subtitle="'Gestion de l\'API DofusDB'" />

        <div class="flex justify-center w-full mt-16">

            @if($needDofusDBUpdate)
                <a  href="{{ route('dofusDBApi') }}"
                    class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110"
                    x-on:click="loading = true">Récupérer les items</a>
            @else
                <div class="w-48 p-4 text-2xl text-primary text-center font-light rounded-md bg-inactiveText">API DofusDB à jour</div>
            @endif

        </div>

        <div class="flex flex-col gap-y-2 items-center mt-10"
             x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-full"
             x-transition:enter-end="opacity-100">
            <img class="animate-pulseFast h-32 w-32 opacity-25" src="{{ asset('storage/images/misc_ui/logo_barbe_x256.png') }}" draggable="false">
            <p class="text-2xl text-secondary animate-pulseFast opacity-25 font-light">Récupération des items</p>
        </div>

        <h2 class="text-2xl font-thin text-center mt-16 mb-8 uppercase">Gestion du miss'skin</h2>

        <div class="w-full flex justify-center">
            @if(session('miss-skin'))
                <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600">{{ session('miss-skin') }}</p>
            @endif
        </div>

        <div class="flex justify-center w-full mt-8">
            <a  href="{{ route('miss-skin') }}"
                class="w-48 p-4 text-2xl text-primary text-center font-light goldGradient rounded-md hover:brightness-110">Lancer le concours</a>
        </div>

    </div>
</div>
