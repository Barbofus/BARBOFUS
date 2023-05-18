<div class="w-[300px] max-h-screen">
    <p class="my-4">Vainqueurs</p>

    <div class="flex flex-col gap-y-4 items-center relative w-full">
        @foreach($skins as $skin)
            <x-skins-presentation.skin-card :skin="$skin"/>
        @endforeach
    </div>
</div>
