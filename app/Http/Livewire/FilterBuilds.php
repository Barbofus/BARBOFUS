<?php

namespace App\Http\Livewire;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Livewire\Component;

class FilterBuilds extends Component
{
    public $selectedElements = []; // Liste des élements selectionnés
    public $unselectedElements = []; // Liste des éléments deselectionnés

    public $selectedRaces = []; // Liste des classes selectionnés

    public $secondaryElementFilter = true; // Boolean pour activer ou non le filtrage stricte
    public $primaryElementFilter = true; // Boolean pour activer ou non le filtrage stricte

    public $showPvp = false; // Boolean pour montrer ou non les builds PVP
    public $showPvm = false; // Boolean pour montrer ou non les builds PVM

    public $allBuilds; // Tous les builds du site, permet d'appeler la BDD qu'une fois
    public $allElements; // Tous les élements du site, permet d'appeler la BDD qu'une fois
    public $allRaces; // Toutes les classes du site, permet d'appeler la BDD qu'une fois

    public $buildsToShow; // Builds qu'on va montrer sur la page


    // Fonction s'executant à l'init, comme un construct
    public function mount()
    {
        // On remplis tous no array
        Self::FillBuildsArray();

        $this->allElements = Element::all();
        $this->allRaces = Race::all();

        // Lance la fonction de deselection des elements pour remplir les deux array
        Self::UnselectAllElements();
    }

    public function FillBuildsArray()
    {
        // Récupération de tous les builds dans l'ordre de classes, puis dans l'ordre PVP / PVM
        $builds = Build::orderBy('race_id')->orderBy('is_pvp')->get();

        // On remplis un array avec les infos de la BDD
        foreach($builds as $build)
        {
            $buildElements = [];

            // On commence par remplir les élements, une colonne = un array contenant tous les élements du build,
            // chaque élement est un array contenant les infos
            for ($i=0; $i < $build->Element->count(); $i++) {
                $buildElements[] = [
                    'id'            => $build->Element[$i]->id,
                    'icon_path'     => $build->Element[$i]->icon_path,
                    'name'          => $build->Element[$i]->name,
                    'is_elemental'  => $build->Element[$i]->is_elemental,
                ];
            }

            // Puis le build en lui même, c'est un array contenant tous les builds
            // où chaque build est un array contenant 2 array (un pour les infos du build, un pour les infos des elements)
            $this->allBuilds[] = [
                'build'     => [
                    'id'            => $build->id,
                    'title'         => $build->title,
                    'build_link'    => $build->build_link,
                    'image_path'    => $build->image_path,
                    'ap_nbr'        => $build->ap_nbr,
                    'mp_nbr'        => $build->mp_nbr,
                    'is_pvp'        => $build->is_pvp,
                    'race'          => [
                        'id'            => $build->Race->id,
                        'name'          => $build->Race->name,
                        'icon_path'     => $build->Race->icon_path,
                        'banner_path'   => $build->Race->banner_path,
                    ],
                ],

                'elements'  => $buildElements,
            ];
        }

        // Commencons par faire un tableau à 5 dimensions (1 dimension par Nbr d'élements possible dans un build)
        $buildsToSort = [];

        // Puis on remplis chaque dimension en fonction du Nbr d'élements
        foreach ($this->allBuilds as $key => $value) {

            // On parcours chaque dimension
            for ($i=1; $i < 6; $i++) {

                // Si on a autant d'élements que le $i, nous sommes dans la bonne dimension
                if(count($value['elements']) === $i) {
                    $haveVariant = false;

                    // Si on a au moins 2 éléments
                    if($i > 1) {
                        // On check si le build possède une variante docri / dopou
                        foreach ($value['elements'] as $key2 => $elem) {
                            if(!$elem['is_elemental']) {
                                $haveVariant = true;
                                continue;
                            }
                        }
                    }

                    // Si oui, alors on range ce build dans la dimension inférieur, (un stuff eau/docri se doit d'être dans la dimension à 1 élément)
                    if($haveVariant){
                        $buildsToSort[$i-1][] = $value;
                        continue;
                    }

                    // Sinon on le range dans cette dimension
                    $buildsToSort[$i][] = $value;
                    continue;
                }
            }
        }

        // Pour chaque dimensions, on va trier par somme des id des élements (ce qui veux dire que les mêmes élements / multi seront ensemble et les variantes do pou / docri seront à la fin)
        foreach ($buildsToSort as $key => $value) {
            $elemSums = [];
            foreach ($buildsToSort[$key] as $key2 => $value2) {
                $currentBuildElemSum = 0;
                foreach ($buildsToSort[$key][$key2]['elements'] as $key3 => $value3) {
                    $currentBuildElemSum += 2**$value3['id']; // On utilise les puissances de 2 pour que chaque résultat n'ai qu'une combinaison possible (ex: id 3 + 6 = 9, mais aussi id 4 + 5 = 9, avec les puissances, ce cas n'es pas possible, 2**3 + 2**6 != 2**4 + 2**5)
                }
                $elemSums[] = $currentBuildElemSum;
            }

            // On trie nos résultats par ordre croissant
            asort($elemSums);

            // Puis on applique ce trie à notre liste de builds
            $buildsToSort[$key] = array_replace($elemSums, $buildsToSort[$key]);


            // On réindexe tout ça !
            $buildsToSort[$key] = array_values($buildsToSort[$key]);

            //dd($elemSums, $buildsToSort[$key]);
        }

        // Puis on réindexe en fonction des keys pour trier par Nbr d'élements
        ksort($buildsToSort);

        // On vide la variable des builds
        unset($this->allBuilds);
        $this->allBuilds = array();

        // On change notre variable contenant tous les builds pour sa version trié
        foreach ($buildsToSort as $key => $value) {
            foreach ($buildsToSort[$key] as $key2 => $value2) {
                $this->allBuilds[] = $buildsToSort[$key][$key2];
            }
        }

        // Puis on donne tout ça à la variable qui affiche nos builds
        $this->buildsToShow = $this->allBuilds;
        //dd($this->buildsToShow);
    }


    // Fonction de selection ou deselection d'une classes, appelé depuis 'livewire.filter-builds'
    public function SelectRaces($id)
    {
        // Si la classe est déjà selectionné, la deselectionne et inversement
        if(!array_keys($this->selectedRaces, $id))
        {
            $this->selectedRaces[] = $id;
        }
        else {
            unset($this->selectedRaces[array_search($id, $this->selectedRaces)]);
        }
    }

    // Fonction appelé depuis 'livewire.filter-builds' qui vise à deselectionné toutes les classes
    public function UnselectAllRaces()
    {
        // Deselectionne les classes
        unset($this->selectedRaces);
        $this->selectedRaces = array();
    }

    // Fonction qui selectionne ou deselectionne un element, appelé depuis 'livewire.filter-builds'
    public function SelectElements($id)
    {
        // Si un elements est selectionné, le deselectionne, et inversement
        if(!array_keys($this->selectedElements, $id))
        {
            $this->selectedElements[] = $id;
            unset($this->unselectedElements[array_search($id, $this->unselectedElements)]);
        }
        else {
            unset($this->selectedElements[array_search($id, $this->selectedElements)]);
            $this->unselectedElements[] = $id;
        }
    }


    // Fonction qui deselectionne tous les elements, appelé depuis 'livewire.filter-builds'
    public function UnselectAllElements()
    {
        // Deselectionne les elements
        unset($this->selectedElements);
        $this->selectedElements = array();

        // Vide le tableau des élements deselectionné..
        unset($this->unselectedElements);
        $this->unselectedElements = array();

        // ..pour le remplir correctement
        foreach($this->allElements as $element) {
            $this->unselectedElements[] = $element->id;
        }
    }

    // Fonction appelé depuis 'livewire.filter-builds' qui toggle l'apparition de variantes docri et dopou
    public function ToggleSecondaryElementFilter()
    {
        $this->secondaryElementFilter = !$this->secondaryElementFilter;
    }

    // Fonction appelé depuis 'livewire.filter-builds' qui toggle l'apparition de variantes élementaires
    public function TogglePrimaryElementFilter()
    {
        $this->primaryElementFilter = !$this->primaryElementFilter;
    }

    // Fonction appelé depuis 'livewire.filter-builds' qui toggle le filtrage PVP
    public function TogglePvp()
    {
        $this->showPvp = !$this->showPvp;
    }

    // Fonction appelé depuis 'livewire.filter-builds' qui toggle le filtrage PVM
    public function TogglePvm()
    {
        $this->showPvm = !$this->showPvm;
    }

    // Enlève tous les builds dont la race n'es pas séléctionné
    public function RemoveUnselectedRacesFromBuildsToShow()
    {
        // Liste des builds à supprimer
        $indexToDelete = [];

        // On parcours tous les builds, puis toutes les classes
        for ($i=0; $i < count($this->buildsToShow) ; $i++) {

            $getGoodRace = false;

            // Pour chaque classe séléctionné
            foreach ($this->selectedRaces as $race) {

                // Si le build possède la classe, on passe au build suivant
                if($this->buildsToShow[$i]['build']['race']['id'] === $race) {
                    $getGoodRace = true;
                    break;
                }
            }

            // Sinon si on a finis de parcourir toutes les classes selectionné et qu'on a pas obtenu de résultat, on supprime
            if(!$getGoodRace) {
                $indexToDelete[] = $i;
            }
        }

        // On supprime de l'array
        for ($i=0; $i < count($indexToDelete); $i++) {
            unset($this->buildsToShow[$indexToDelete[$i]]);
        }

        // On réindexe tout ça !
        $this->buildsToShow = array_values($this->buildsToShow);

        //dd($this->buildsToShow);
    }

    // Enlève tous les builds dont les élements ne sont pas séléctionnés
    public function RemoveUnselectedElementsFromBuildsToShow()
    {
        // Liste des builds à supprimer
        $indexToDelete = [];

        // On parcours tous les builds restant
        for ($i=0; $i < count($this->buildsToShow) ; $i++) {

            $getGoodElement = 0;
            $extraElementIsSecondary = false;

            // Pour chaque élement dans le build
            for ($j=0; $j < count($this->buildsToShow[$i]['elements']); $j++) {

                // Pour chaque élement séléctionné
                foreach ($this->selectedElements as $element) {

                    // Si le build possède un des élements sélectionné, on fait +1
                    if($this->buildsToShow[$i]['elements'][$j]['id'] === $element) {
                        $getGoodElement ++;
                    }
                }

                // Si on veux voir au moins une des variantes
                if($this->secondaryElementFilter || $this->primaryElementFilter) {

                    // On fouille tous les élements non selectionné
                    foreach ($this->unselectedElements as $element) {

                        // On vérifie s'il est secondaire
                        if(!$this->allElements->find($element)->is_elemental) {

                            // Si notre build possède cette élement et qu'il est secondaire, alors le compte
                            if($element === $this->buildsToShow[$i]['elements'][$j]['id']) {
                                $extraElementIsSecondary = true;
                                break;
                            }
                        }
                    }
                }
            }

            // Si on a pas trouvé tous les élements séléctionné, ça dégage
            if($getGoodElement < count($this->selectedElements)) {
                $indexToDelete[] = $i;
                continue;
            }

            // On laisse passer les builds avec autant d'élements que ceux séléctionnés
            if($getGoodElement === count($this->buildsToShow[$i]['elements']))
                continue;

            // Pour accepter les variantes do pou / do cri
            if($this->secondaryElementFilter) {

                // Si le build possède un élement de plus que ceux trouvés et que c'est un élement secondaire, on prend
                if($getGoodElement + 1 === count($this->buildsToShow[$i]['elements']) && $extraElementIsSecondary)
                    continue;

                // Si on accepte également les variantes élementaires
                if($this->primaryElementFilter) {

                    // Si le build possède plus d'élements que ceux trouvés, on prend
                    if($getGoodElement < count($this->buildsToShow[$i]['elements']))
                        continue;
                }
            }

            // Pour accepter les variantes élementaires
            if($this->primaryElementFilter) {

                // Si le build possède plus d'élements que ceux trouvés et qu'ils ne sont pas secondaire, on prend
                if($getGoodElement < count($this->buildsToShow[$i]['elements']) &! $extraElementIsSecondary)
                    continue;

            }

            // Tous le reste ça dégage
            $indexToDelete[] = $i;
        }

        // On supprime de l'array
        for ($i=0; $i < count($indexToDelete); $i++) {
            unset($this->buildsToShow[$indexToDelete[$i]]);
        }

        // On réindexe tout ça !
        $this->buildsToShow = array_values($this->buildsToShow);
    }

    // Fonction qui retire les build PVM
    public function ShowOnlyPVP()
    {
        // Liste des builds à supprimer
        $indexToDelete = [];

        // On parcours tous les builds restant
        for ($i=0; $i < count($this->buildsToShow) ; $i++) {

            // Supprime les PVM
            if(!$this->buildsToShow[$i]['build']['is_pvp'])
                $indexToDelete[] = $i;
        }

        // On supprime de l'array
        for ($i=0; $i < count($indexToDelete); $i++) {
            unset($this->buildsToShow[$indexToDelete[$i]]);
        }

        // On réindexe tout ça !
        $this->buildsToShow = array_values($this->buildsToShow);
    }

    // Fonction qui retire les build PVP
    public function ShowOnlyPVM()
    {
        // Liste des builds à supprimer
        $indexToDelete = [];

        // On parcours tous les builds restant
        for ($i=0; $i < count($this->buildsToShow) ; $i++) {

            // Supprime les PVP
            if($this->buildsToShow[$i]['build']['is_pvp'])
                $indexToDelete[] = $i;
        }

        // On supprime de l'array
        for ($i=0; $i < count($indexToDelete); $i++) {
            unset($this->buildsToShow[$indexToDelete[$i]]);
        }

        // On réindexe tout ça !
        $this->buildsToShow = array_values($this->buildsToShow);
    }

    // Rendu de la page
    public function render()
    {
        // Reset des builds à montrer
        $this->buildsToShow = $this->allBuilds;

        // On commence par trier les classes
        if(count($this->selectedRaces) > 0)
            Self::RemoveUnselectedRacesFromBuildsToShow();

        // Ensuite on trie les élements
        if(count($this->selectedElements) > 0)
            Self::RemoveUnselectedElementsFromBuildsToShow();

        // Si seul le PVM est actif
        if($this->showPvm && !$this->showPvp)
        {
            Self::ShowOnlyPVM();
        }
        elseif(!$this->showPvm && $this->showPvp) // Si seul le PVP est actif
        {
            Self::ShowOnlyPVP();
        }

        // Et on envoie !
        return view('livewire.filter-builds', ['elements' => $this->allElements, 'races' => $this->allRaces, 'builds' => $this->buildsToShow]);
    }
}
