@extends('layouts.basic-views')

@section('content')
    <div class="flex items-center justify-center mt-24">
        <form method="POST" action='{{ route('login') }}' class="flex justify-center w-[80%]">
            @csrf
            <div class="w-full px-5 py-10 flex flex-col items-center gap-y-8">

                <h1 class="text-[min(5rem,15vw)] font-normal text-center uppercase">Connexion</h1>
                <h2 class="text-2xl font-thin text-center -mt-10 mb-8 uppercase">Bienvenue sur Barbofus !</h2>

                <div class="-mx-3" x-data="{ text: '{{ (old('email')) ? old('email') : '' }}'}">
                    <div class="w-[min(90vw,350px)] px-3">
                        <div class="flex w-full h-12 group rounded-md @error('email') err-border @enderror">
                            <input x-model="text" id="email" name="email" type="email"
                                   class="h-full peer w-full p-2 pr-3 bg-primary-100 border-y-2 border-r-2 border-primary-100 rounded-r-md outline-none focus:border-goldText placeholder-inactiveText transition-all"
                                   placeholder="E-mail">

                            <div class="order-first relative bg-primary-100 h-full w-12 rounded-l-md p-2 flex justify-between items-center border-y-2 border-l-2 border-primary-100 transition-all peer-focus:border-goldText">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                     class="w-full h-full transition-all" x-cloak
                                     :class="(text) ? 'text-secondary' : 'text-inactiveText'">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>

                                <div x-cloak
                                    class="absolute left-0 border-r-2 w-full h-8 transition-all"
                                    :class="(text) ? 'border-secondary' : 'border-inactiveText'"></div>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-red-400 text-l ml-[50px]">
                        <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <div class="-mx-3" x-data="{ text: ''}">
                    <div class="w-[min(90vw,350px)] px-3">
                        <div class="flex w-full h-12 group rounded-md @error('password') err-border @enderror">
                            <input x-model="text" id="password" name="password" type="password"
                                   class="h-full peer w-full p-2 pr-3 bg-primary-100 border-y-2 border-r-2 border-primary-100 rounded-r-md outline-none focus:border-goldText placeholder-inactiveText transition-all"
                                   placeholder="Mot de passe">

                            <div class="order-first relative bg-primary-100 h-full w-12 rounded-l-md p-2 flex justify-between items-center border-y-2 border-l-2 border-primary-100 transition-all peer-focus:border-goldText">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                     class="w-full h-full transition-all" x-cloak
                                     :class="(text) ? 'text-secondary' : 'text-inactiveText'">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>


                                <div x-cloak
                                    class="absolute left-0 border-r-2 w-full h-8 transition-all"
                                    :class="(text) ? 'border-secondary' : 'border-inactiveText'"></div>
                            </div>
                        </div>
                    </div>
                    @error('password')
                    <span class="text-red-400 text-l ml-[50px]">
                        <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="block px-8 py-3 mx-auto font-thin text-white bg-yellow-500 rounded-lg hover:bg-yellow-700 focus:bg-yellow-700 uppercase">Se connecter</button>

                <p class="font-thin -ml-[min(200px,20vw)]">Aucun compte ? <a href="{{ route('register') }}" class="font-normal text-goldText hover:text-goldTextLit text-lg">S'enregistrer</a></p>
            </div>
        </form>
    </div>
@endsection
