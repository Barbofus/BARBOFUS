@extends('layouts.basic-views')

@section('content')
    <x-utils.userpage-title :title="'Image en vrac'" :subtitle="'Upload tous les fichiers que tu veux ici'" />

    <div class="p-16 flex flex-col gap-y-16">
        <div class="h-24 w-full mx-auto">

            <form method="POST" action="{{ route('image-en-vrac.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="w-fit flex flex-col space-y-4 mx-auto">
                    <div class="flex items-center space-x-4">
                        <input id="image_en_vrac_input" class="text-inactiveText h-fit rounded-md cursor-pointer bg-primary-100 focus:outline-none file:goldGradient file:text-primary file:h-10 file:border-0 hover:file:brightness-110 file:cursor-pointer" type="file" name="files[]" required multiple accept="image/*">

                        <input x-ref="input"
                               maxlength="30" name="name" id="name" type="text" placeholder="Nom"
                               class="w-56 h-10 rounded-md pl-4 focus:outline-none placeholder-inactiveText bg-primary-100"/>
                    </div>

                    <x-forms.submit>ENVOYER</x-forms.submit>
                </div>
            </form>
        </div>

        @if(Session::has('message'))
            <div class="bottom-4 mx-auto right-4 px-8 py-4 bg-green-100 border-l-4 border-green-700 text-green-700 text-xl max-w-[90vw] min-[1100px]:max-w-[30vw]">

                <p class="font-normal text-2xl">Succès !</p>
                <p class="font-light">{{ Session::get('message') }}</p>
            </div>
        @endif


        <div class="flex w-full justify-center flex-wrap space-y-4 space-x-4">
            @foreach($images as $image)
                <button class="relative h-fit group transition-all hover:rounded-xl overflow-hidden"
                        x-data="{
                        copied: 'COPY LINK',

                        CopyLink() {
                            if(!navigator.clipboard) return;

                            navigator.clipboard.writeText('{{ asset('storage/' . $image['path']) }}');
                            this.copied = 'Copié';
                        }
                    }"
                        x-on:mousedown="CopyLink">
                    <p class="first-letter:uppercase">{{ $image['name'] }}</p>
                    <img src="{{ asset('storage/' . $image['path']) }}" alt="Image de {{ $image['name'] }}" class="max-w-[43.75rem]">

                    <div class="absolute top-0 left-0 w-full h-full group-hover:opacity-100 opacity-0 transition-all flex items-center justify-center">
                        <div class="absolute rounded-2xl top-0 left-0 w-full h-full opacity-75 bg-black"></div>
                        <p class="relative z-10 text-2xl text-secondary" x-text="copied"></p>
                    </div>
                </button>
            @endforeach
        </div>

        <script>
            const image_en_vrac_input = document.getElementById('image_en_vrac_input');

            window.addEventListener('paste', e => {
                image_en_vrac_input.files = e.clipboardData.files;
            })
        </script>
    </div>
@endsection
