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

            <div class="flex gap-x-2 items-center justify-center text-primary font-light [&>a]:flex [&>a]:items-center [&>a]:h-12 [&>a:hover]:-skew-x-12">
                <a href="{{ route('home') }}" title="Accueil du site">Accueil</a>
                <a href="{{ route('skins.index') }}" title="Gallerie de skin">Les skins</a>
                <a href="{{ route('skins.create') }}" title="Partage ton skin">Poster un skin</a>
            </div>
        </div>
    </div>
</footer>
