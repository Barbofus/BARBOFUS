@extends('layouts.app')

@section('content')
    <h1 class="text-2xl text-center text-red-500 ">Bienvenue sur le create des skins !</h1>

    <div class="flex justify-center mt-10">
        <form autocomplete="off" method="POST" action="{{ route('skins.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
            @csrf

            <div class="flex space-x-8">

                {{-- Choix de l'image --}}
                <div x-data="{
                    finaleUrl: '',
                    ChangeFile(event) {
                        this.FileToDataUrl(event, src => this.finaleUrl = src)
                    },

                    FileToDataUrl(event, callback) {
                        if (! event.target.files.length) return

                        let file = event.target.files[0],
                        reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }">
                    <p class="text-xl font-semibold">Image du skin</p>
                    <div class="mt-2 ml-2 @error('image_path') err-border @enderror">
                        <input x-on:input.change="ChangeFile" class="text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:bg-blue-500 file:text-white file:h-8 file:border-0 hover:file:bg-blue-300 file:cursor-pointer" type="file" name="image_path" accept="image/png">
                        <p class="mt-1 ml-8 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG (MAX. 350x450px, 100ko).</p>
                    </div>

                    <img x-show="finaleUrl" x-transition class="mt-16" width="308" height="400" :src="finaleUrl" draggable="false"/>

                    @error('image_path')
                        <x-requirements-error message={{$message}} />
                    @enderror

                </div>

                <div>
                    <div class="flex space-x-8">
                        <div>
                            {{-- Choix du sexe --}}
                            <p class="text-xl font-semibold">Choix du sexe</p>
                            <div class="pt-2 pl-6">
                                <input id="male" name="gender" type="radio" value="male" checked>
                                <label for="male">Mâle</label>
                                <input class="ml-4" id="female" name="gender" type="radio" value="female" {{ (old('gender') == 'female') ? 'checked' : '' }}>
                                <label for="female">Femelle</label>
                            </div>
                            @error('gender')
                                <x-requirements-error message={{$message}} />
                            @enderror


                            {{-- Choix de la classe --}}
                            <p class="mt-5 text-xl font-semibold">Choix de la classe</p>
                            <select name="race_id" class="pt-2 pl-6">
                                @foreach ($races as $race)
                                    <option value="{{ $race->id }}" {{( $race->id == old('race_id')) ? 'selected' : ''}}>{{ $race->name }}</option>
                                @endforeach
                            </select>
                            @error('race_id')
                                <x-requirements-error message={{$message}} />
                            @enderror


                            {{-- Choix du visage --}}
                            <p class="mt-5 text-xl font-semibold">Choix du visage</p>
                            <div class="grid grid-cols-4 gap-4 mt-4 w-fit">
                                @for ($i = 1; $i <= 8; $i++)
                                    <label class="w-12 h-12">
                                        <input type="radio" name="face" value="{{ $i }}" class="absolute opacity-0 peer" @if ($i == 1) checked @endif {{ (old('face') == $i) ? 'checked' : '' }}>
                                        <div class="flex items-center justify-center w-full h-full text-3xl bg-gray-200 border-2 border-gray-500 cursor-pointer hover:bg-blue-200 hover:border-blue-500 peer-checked:bg-green-200 peer-checked:border-green-500">{{ $i }}</div>
                                    </label>
                                @endfor
                            </div>
                            @error('face')
                                <x-requirements-error message={{$message}} />
                            @enderror
                        </div>

                        <div>
                            {{-- Choix des couleurs --}}
                            <p class="text-xl font-semibold">Choix des couleurs</p>

                            <div class="flex flex-col pl-10 gap-y-2">
                                <x-color-input title="Peau:" name="color_skin" value="{{old('color_skin')}}" />
                                <x-color-input title="Cheveux:" name="color_hair" value="{{old('color_hair')}}" />
                                <x-color-input title="Habits 1:" name="color_cloth_1" value="{{old('color_cloth_1')}}" />
                                <x-color-input title="Habits 2:" name="color_cloth_2" value="{{old('color_cloth_2')}}" />
                                <x-color-input title="Habits 3:" name="color_cloth_3" value="{{old('color_cloth_3')}}" />
                            </div>
                        </div>
                    </div>

                    {{-- Choix des items --}}
                    <p class="mt-5 text-xl font-semibold">Choix des items</p>
                    <div class="grid grid-flow-row grid-cols-2 gap-2 mt-2">
                        <livewire:forms.searchbar-items-autocomplete :relatedModel="'App\Models\DofusItemHat'" :name="'dofus_item_hat_id'" :value="old('dofus_item_hat_id')" :placeholder="'Choisis une coiffe...'" />
                        <livewire:forms.searchbar-items-autocomplete :relatedModel="'App\Models\DofusItemCloak'" :name="'dofus_item_cloak_id'" :value="old('dofus_item_cloak_id')" :placeholder="'Choisis une cape...'" />
                        <livewire:forms.searchbar-items-autocomplete :relatedModel="'App\Models\DofusItemShield'" :name="'dofus_item_shield_id'" :value="old('dofus_item_shield_id')" :placeholder="'Choisis un bouclier...'" />
                        <livewire:forms.searchbar-items-autocomplete :relatedModel="'App\Models\DofusItemPet'" :name="'dofus_item_pet_id'" :value="old('dofus_item_pet_id')" :placeholder="'Choisis un familier...'" />
                        <livewire:forms.searchbar-items-autocomplete :relatedModel="'App\Models\DofusItemcostume'" :name="'dofus_item_costume_id'" :value="old('dofus_item_costume_id')" :placeholder="'Choisis un costume...'" />
                    </div>

                    {{-- Choix des items --}}
                    <button type="submit" class="w-48 h-12 mt-10 text-2xl text-white bg-blue-500 hover:bg-blue-300">Poster !</button>
                </div>
            </div>
        </form>
    </div>
@endsection
