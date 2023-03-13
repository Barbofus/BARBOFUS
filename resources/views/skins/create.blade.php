@extends('layouts.app')

@section('content')
    <h1 class="text-2xl text-center text-red-500 ">Bienvenue sur le create des skins !</h1>

    <div class="flex justify-center mt-10">
        <form method="POST" action="{{ route('skins.store') }}" enctype="multipart/form-data" class="max-w-[500px] min-h-[750px]" onkeydown="return event.key != 'Enter';">
            @csrf

            {{-- Choix de l'image --}}
            <p class="text-xl font-semibold">Image du skin<span class="ml-2 text-lg font-normal italic">(le .png du skinator de dofusbook)</span></p>
            <input name="image_path" type="file" accept="image/png" class="ml-6 mt-2 @error('image_path') err-border @enderror">

            @error('image_path')
                <x-requirements-error message={!!$message!!} />
            @enderror

            {{-- Choix du sexe --}}
            <p class="mt-5 text-xl font-semibold">Choix du sexe</p>
            <div class="pt-2 pl-6">
                <input id="male" name="gender" type="radio" value="male" checked>
                <label for="male">Mâle</label>
                <input class="ml-4" id="female" name="gender" type="radio" value="female" {{ (old('gender') == 'female') ? 'checked' : '' }}>
                <label for="female">Femelle</label>
            </div>


            {{-- Choix de la classe --}}
            <p class="mt-5 text-xl font-semibold">Choix de la classe</p>
            <select name="race_id" class="pt-2 pl-6">
                @foreach ($races as $race)
                    <option value="{{ $race->id }}" {{( $race->id == old('race_id')) ? 'selected' : ''}}>{{ $race->name }}</option>
                @endforeach
            </select>


            {{-- Choix du visage --}}
            <p class="mt-5 text-xl font-semibold">Choix du visage</p>
            <div class="grid grid-cols-4 mt-4 gap-y-4">
                @for ($i = 1; $i <= 8; $i++)
                    <label class="w-12 h-12">
                        <input type="radio" name="face" value="{{ $i }}" class="absolute opacity-0 peer" @if ($i == 1) checked @endif {{ (old('face') == $i) ? 'checked' : '' }}>
                        <div class="flex items-center justify-center w-full h-full text-3xl bg-gray-200 border-2 border-gray-500 cursor-pointer hover:bg-blue-200 hover:border-blue-500 peer-checked:bg-green-200 peer-checked:border-green-500">{{ $i }}</div>
                    </label>
                @endfor
            </div>


            {{-- Choix des couleurs --}}
            <p class="mt-5 text-xl font-semibold">Choix des couleurs</p>

            <div class="flex items-center justify-center mt-2">
                <x-color-input title="Peau:" name="color_skin" value="{{old('color_skin')}}" />
                <x-color-input title="Cheveux:" name="color_hair" value="{{old('color_hair')}}" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-color-input title="Habits 1:" name="color_cloth_1" value="{{old('color_cloth_1')}}" />
                <x-color-input title="Habits 2:" name="color_cloth_2" value="{{old('color_cloth_2')}}" />
                <x-color-input title="Habits 3:" name="color_cloth_3" value="{{old('color_cloth_3')}}" />
            </div>

            {{-- Choix des items --}}


            {{-- Choix des items --}}
            <button type="submit" class="w-48 h-12 mt-10 text-2xl text-white bg-blue-500 hover:bg-blue-300">Poster !</button>

        </form>
    </div>
@endsection
