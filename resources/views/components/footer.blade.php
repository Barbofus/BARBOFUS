<!-- Footer -->
<footer id="footer" class="fixed bottom-2 w-full z-50 h-fit">
    <div class="p-2 bg-secondary absolute left-0 w-full h-fit transition-all duration-200 group hover:fixed hover:-translate-y-[calc(100%-0.5rem)]">

        <!-- Hovered extension -->
        <div class="flex justify-between absolute w-36 h-4 -top-4 left-[calc(50%-4.5rem)]">
            <div class="w-8 h-full rotate-180 bg-secondary clip-path-triangle-down"></div>
            <div class="w-8 h-full rotate-180 bg-secondary clip-path-triangle-down"></div>
            <div class="absolute h-full rotate-180 bg-secondary w-28 left-4">
                <div class="transition-transform duration-200 group-hover:rotate-180 absolute top-0 left-[calc(50%-0.5rem)] w-4 h-3 bg-primary clip-path-triangle-down"></div>
            </div>
        </div>

        <!-- Footer content -->
        <div>

            <!-- Réseaux sociaux -->
            <x-utils.socials />

            <p class="text-primary text-center text-sm font-light">Dofus est un MMORPG édité par <a target="_blank" href="https://www.ankama.com/fr" title="Site web d'Ankama" class="underline">Ankama</a>. "BARBOFUS" est un site non-officiel sans aucun lien avec Ankama.<br>
                Certaines illustrations sont la propriété d'Ankama Studio et de Dofus - Tous droits réservés</p>

            <div class="grid grid-cols-2 min-[500px]:grid-cols-3 w-fit mx-auto gap-x-2 items-center justify-center text-primary my-4 [&>a]:h-8 [&>a:hover]:-skew-x-12 uppercase">
                <a href="{{ route('home') }}" title="Accueil du site">Accueil</a>
                <a href="{{ route('unity-skins.index') }}" title="Gallerie de skin">Les skins</a>
                <a href="{{ route('unity-skins.create') }}" title="Partage ton skin">Poster un skin</a>
                <a href="{{ route('havre-sacs.index') }}" title="Gallerie de havre-sacs">Havre-sacs</a>
                <a href="{{ route('tools') }}" title="Barb'outils">Barb'Outils</a>
                <a href="{{ route('mentions-legales') }}" title="Mentions légales">Mentions légales</a>
            </div>

            <p class="text-primary font-light text-center">© {{date('Y')}} Barbofus - Tous droits réservés</p>
            <p class="text-primary font-light italic text-center">Votre vision, notre code – <a href="https://www.malt.fr/profile/charlymollard" class="text-admin-accent-500 hover:underline font-normal">EminensWeb</a></p>
        </div>
    </div>
</footer>
