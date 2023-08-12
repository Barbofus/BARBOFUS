@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='{{ route('verification.send', ['id' => Route::current()->parameter('id')]) }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">
                @if (session('status') == 'verification-link-sent')
                    <p class="mb-8 text-center px-8 py-4 border-2 border-green-600 bg-green-200 font-light rounded-md text-md text-green-600">Un e-mail de vérification a été réenvoyer !</p>
                @endif

                <h2 class="text-2xl font-thin text-center -mt-10 mb-8">L'adresse mail doit être validé pour se connecter.</h2>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8">Un email de vérification a été envoyé.</h2>
                <h2 class="text-2xl font-light text-center -mt-10 mb-8">Merci de cliquer sur le lien dans le mail.</h2>
                    <h2 class="text-xl font-thin text-center -mt-10 mb-8">Pense à vérifier tes spams/indésirables.</h2>

                <x-forms.submit>Réenvoyer l'e-mail de validation</x-forms.submit>
            </div>
        </form>
    </div>
@endsection
