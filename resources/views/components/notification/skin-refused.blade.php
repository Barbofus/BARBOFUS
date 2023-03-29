<div class="flex items-start ">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-16 text-red-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>


    <div class="pl-4">
        <p class="font-bold">Skin Refusé <span class="italic text-gray-500">ID#{{ $item->id }}</span></p>
        <p class="indent-2">Ton skin en <span class="font-bold">{{ $item->race->name }}</span> à été refusé par un membre du staff. <a class="text-gray-400 hover:text-gray-300" href="{{ route('skins.edit', ['skin' => $item->id]) }}">Clique ici pour le modifier</a></p>
    </div>
</div>
