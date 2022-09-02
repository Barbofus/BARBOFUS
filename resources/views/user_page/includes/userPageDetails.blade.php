
{{-- Page include dans le user_page.index --}}
<div x-show="selection === 'userPageDetails'" x-transition class="h-full w-full text-center pt-6">
    <p class="font-bold text-3xl">Détails du compte</p>
    <p class=" italic text-xl">Page en construction</p>

    {{-- Section stats --}}
    <div class=" flex justify-center">
        <div class="w-[80%] h-[250px] mt-6 border-t border-b border-slate-300">
            <h1 class="text-2xl font-bold italic mt-6">Tes stats :</h1>
            <p class="mt-6 text-left text-lg font-bold italic">Inscription le : <span class=" font-thin">{{ $currentUser->created_at->translatedFormat('j F Y') }}</span></p>
            <p class="font-thin text-left text-lg">Ton compte a <span class="font-normal">{{ $accountUptime }}</span></p>
        </div>
    </div>
    
    {{-- Section paramètres --}}
    <div class=" flex justify-center">
        <div class="w-[80%] min-h-[250px] mt-6 border-slate-300">
            <h1 class="text-2xl font-bold italic mt-6">Paramètres :</h1>


            {{-- Changement de mot de passe --}}
            <form method="POST" action='{{ route('user-password.update') }}'>
                @method('PUT')
                
                @if (session('status') == 'password-updated')
                    @section('alertMessage')
                        Mot de passe mis à jour avec succé !
                    @endsection

                    @include('layouts.success-alert')
                @endif


                @csrf
                <div class="mt-6 ">
                    <p class="text-left text-lg font-bold italic">Changement de mot de passe :</p>
                    <div class="flex justify-start mt-4">
                        <div>
                            <p class="text-left text-lg">Mot de passe actuel :</p>
                            <input id="current_password" name="current_password" type="password" class="w-[250px] pl-5 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="************">
                            
                            @error('current_password', 'updatePassword')
                                <div class="text-red-400 text-l text-left">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="ml-10 mr-10">
                            <p class="text-left text-lg">Nouveau mot de passe :</p>
                            <input id="password" name="password" type="password" class="w-[250px] pl-5 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="************">
                            
                            @error('password', 'updatePassword')
                                <div class="text-red-400 text-l text-left">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <p class="text-left text-lg">Confirmation du nouveau :</p>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="w-[250px] pl-5 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder="************">
                            
                            @error('password_confirmation', 'updatePassword')
                                <div class="text-red-400 text-l text-left">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <button type="submit" class="mt-5 mb-5 w-[150px] bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white rounded-lg px-3 py-2 font-semibold">VALIDER</button>
                    </div>
                </div>
            </form>


            {{-- Changement de profil --}}
            <form method="POST" action='{{ route('user-profile-information.update') }}'>
                @method('PUT')
                
                @if (session('status') == 'profile-information-updated')
                    @section('alertMessage')
                        Profil mis à jour avec succé !
                    @endsection

                    @include('layouts.success-alert')
                @endif


                @csrf
                <div class="mt-6 ">
                    <p class="text-left text-lg font-bold italic">Changement de profil :</p>
                    <div class="flex justify-start mt-4">
                        <div>
                            <p class="text-left text-lg">Pseudo :</p>
                            <input id="name" name="name" type="text" class="w-[250px] pl-5 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder={{ $currentUser->name }}>
                            
                            @error('name', 'updateProfileInformation')
                                <div class="text-red-400 text-l text-left">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="ml-10">
                            <p class="text-left text-lg">Adresse e-mail :</p>
                            <input id="email" name="email" type="email" class="w-[250px] pl-5 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500" placeholder={{ $currentUser->email }}>
                            
                            @error('email', 'updateProfileInformation')
                                <div class="text-red-400 text-l text-left">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <button type="submit" class="mt-5 mb-5 w-[150px] bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white rounded-lg px-3 py-2 font-semibold">VALIDER</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>