@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <h1 class=" text-5xl font-bold text-center mt-[50px]">Bienvenue sur la page de création de builds !</h1>
    <h2 class=" text-3xl italic text-center mt-[10px]">Je suis encore en construction, mais... on se reverra bientôt</h2>

    <form method="POST" action='{{ route('builds.store') }}' enctype="multipart/form-data" class="flex justify-center">
      @csrf
      <div class="w-full md:w-1/2 py-10 px-5 md:px-10">

        {{-- 
        --$table->string('image_path');
        --$table->string('build_link');
        $table->foreignId('race_id')->constrained();
        --$table->string('title');
        --$table->integer('ap_nbr');
        --$table->integer('mp_nbr');
        $table->foreignId('user_id')->constrained(); --}}

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Titre</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-email-outline text-gray-400 text-lg"></i></div>
                    <input id="title" name="title" type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="Panda Do Cri ...">
                </div>
            </div>
            @error('title')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="-mx-3 mb-5 pl-[250px]">
          <div class="w-[50%] px-3">
              <label for="" class="text-l font-semibold px-1">Nombre de PA</label>
              <div class="flex">
                  <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-email-outline text-gray-400 text-lg"></i></div>
                  <input id="ap_nbr" name="ap_nbr" type="number" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"  min="0" placeholder="0">
              </div>
          </div>
          @error('ap_nbr')
            <span class="text-red-400 text-l ml-[50px]">
              <span>{{ $message }}</span>
            </span>
          @enderror
        </div>
        

        <div class="-mx-3 mb-5 pl-[250px]">
            <div class="w-[50%] px-3">
                <label for="" class="text-l font-semibold px-1">Nombre de PM</label>
                <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                    <input id="mp_nbr" name="mp_nbr" type="number" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" min="0" placeholder="0">
                </div>
            </div>
            @error('mp_nbr')
              <span class="text-red-400 text-l ml-[50px]">
                <span>{{ $message }}</span>
              </span>
            @enderror
        </div>

        <div class="-mx-3 mb-5 pl-[250px]">
          <div class="w-[50%] px-3">
              <label for="" class="text-l font-semibold px-1">Choix de la classe</label>
              
              <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
              <select name="race_id" id="race_id">
                @foreach ($races as $race)
                  <option value="{{ $race->id }}">{{ $race->name }}</option>
                @endforeach
              </select>
          </div>
          @error('race_id')
            <span class="text-red-400 text-l ml-[50px]">
              <span>{{ $message }}</span>
            </span>
          @enderror
      </div>

      <div class="-mx-3 mb-5 pl-[250px]">
        <div class="w-[50%] px-3">
            <label for="" class="text-l font-semibold px-1">Choix des élements</label>
            
            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
              @foreach ($elements as $element)
                <input name="element_id[]" id="element_id" type="checkbox" value="{{ $element->id }}">{{ $element->name }}</option>
              @endforeach
        </div>
        @error('element_id')
          <span class="text-red-400 text-l ml-[50px]">
            <span>{{ $message }}</span>
          </span>
        @enderror
    </div>

        <div class="-mx-3 mb-5 pl-[250px]">
          <div class="w-[50%] px-3">
              <label for="" class="text-l font-semibold px-1">Image du build</label>
              <div class="flex">
                  <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                  <input id="image_path" name="image_path" type="file" class="w-full -ml-10 pl-10 pr-3 py-2">
              </div>
          </div>
          @error('image_path')
            <span class="text-red-400 text-l ml-[50px]">
              <span>{{ $message }}</span>
            </span>
          @enderror
      </div>

      <div class="-mx-3 mb-12 pl-[250px]">
        <div class="w-[50%] px-3">
            <label for="" class="text-l font-semibold px-1">Lien du build</label>
            <div class="flex">
                <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                <input id="build_link" name="build_link" type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="https://dofusroom.com/....">
            </div>
        </div>
        @error('build_link')
          <span class="text-red-400 text-l ml-[50px]">
            <span>{{ $message }}</span>
          </span>
        @enderror
    </div>

        <div class="flex justify-center -mx-3">
            <div class="w-full px-3 mb-5">
                <button type="submit" class="block w-full max-w-xs mx-auto bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white rounded-lg px-3 py-3 font-semibold">VALIDER</button>
            </div>
        </div>
      </div>
    </form>
@endsection