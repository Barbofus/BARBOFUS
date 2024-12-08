@extends('layouts.basic-views')

@section('content')

    <h1 class="text-[min(4rem,15vw)] mt-10 font-normal text-center uppercase">Barb'Outils</h1>
    <p class="text-2xl font-thin text-center -mt-3 mb-16 uppercase">Voici une liste d'outils qui seront utiles pour votre aventure !</p>

    <div class="w-[calc(100%-1rem)] min-[800px]:w-[80%] mx-auto my-24 text-md min-[800px]:text-lg">

        {{-- Tougli - All Dofus --}}
        <div class="border-y border-secondary px-0 py-4 min-[800px]:px-8 min-[800px]:py-8 flex flex-col min-[1200px]:flex-row items-center gap-16">
            <img src="{{ asset('storage/images/misc_ui/logo_Tougli.png') }}" alt="Logo Tougli" class="h-40">
            <div>
                <h2 class="text-xl min-[800px]:text-4xl mb-4 font-light">Carnet d'aventurier - Le parcours des Dofus</h2>
                <p class="font-thin">Ce Google Sheet vous permet de suivre une route optimisée pour vos Dofus, d'avoir la liste des ressources requises et d'enregistrer votre progression.
                <br>Toutes les quêtes nécessaires à l'obtention du Dofus seront listées dans un ordre efficace, et le document garde en mémoire les quêtes achevées pour suivre votre avancée facilement.</p>
                <a href="https://docs.google.com/spreadsheets/d/1uL7svJ0E0MjhqHVLU7O4Q8v7iGwPd4bsI9qV-Pdhdds/edit?usp=sharing" title="Tougli - Dofus Opti" target="_blank" class="text-goldText font-light italic underline hover:text-goldTextLit transition-all">Cliquez ici pour ouvrir le doc</a>
            </div>
        </div>

    </div>

@endsection
