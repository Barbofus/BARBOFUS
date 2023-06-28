<div>
    <div class="flex space-x-2 items-center mt-2">
        <img class="w-12" draggable="false" src="{{ asset('storage/' . $icon )}}">
        <div>

            <p>{{ $name }}</p>

            <div class="flex space-x-2 items-center">
                <img draggable="false" width="24" height="24" src="{{ asset('storage/' . $subicon) }}">
                <p class="text-sm italic text-gray-500">{{ $subname }}</p>
                <p class="text-sm italic text-gray-500">Lv. {{ $level }}</p>
            </div>
        </div>
    </div>
</div>
