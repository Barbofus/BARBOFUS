<div class=" h-[200px] flex justify-center ">
    <div class="text-xl w-[25%]"></div>
    <div class=" h-full w-[50%] border-b ">
        <h1 class="text-8xl text-amber-400 font-bold w-full mt-3 text-center">BARBOFUS</h1>
        <h2 class="text-2xl text-amber-500 italic w-full mt-3 text-center">Retrouve et partage les meilleurs skins du Monde des Douze !</h2>
    </div>
    @auth
        <h3 class="text-xl w-[25%] text-right pr-[75px] pt-[155px] italic">Content de te revoir <span class="font-bold">{{ Auth::user()->name }}</span> !</h3>
    @endauth

    @guest
        <h3 class="text-xl w-[25%] text-right pr-[75px] pt-[155px] italic">Tu veux <span class="font-bold">poster</span> ou <span class="font-bold">liker</span> un skin ? <span class="font-bold">Inscris-toi !</span></h3>
    @endguest
</div>