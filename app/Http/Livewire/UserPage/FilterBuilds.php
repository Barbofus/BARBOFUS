<?php

namespace App\Http\Livewire\UserPage;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class FilterBuilds extends Component
{    
    
    public $selectedElements = []; // Liste des élements selectionnés
    public $unselectedElements = []; // Liste des éléments deselectionnés

    public $selectedRaces = []; // Liste des classes selectionnés


    public $wher = []; // String contenant la query des classes

    public $elementsOnly = true; // boolean pour activer ou non le filtrage stricte

    // Fonction s'executant à l'init, comme un construct
    public function mount()
    {
        // Lance la fonction de deselection des elements pour remplir les deux array
        Self::UnselectAllElements();
    }

    // Fonction de selection ou deselection d'une classes, appelé depuis 'livewire.user-page.filter-builds'
    public function SelectRaces($id)
    {
        // Si la classe est déjà selectionné, la deselectionne, et l'ajoute ou la retire au string de la query
        if(!array_keys($this->selectedRaces, $id))
        {
            $this->selectedRaces[] = $id;
            $this->wher[] = ['race_id', '=', $id, 'or'];
        }
        else {
            unset($this->selectedRaces[array_search($id, $this->selectedRaces)]);
            unset($this->wher[array_search(['race_id', '=', $id, 'or'], $this->wher)]);
        }
    }

    // Fonction appelé depuis 'livewire.user-page.filter-builds' qui vise à deselectionné toutes les classes
    public function UnselectAllRaces()
    {
        // Deselectionne les classes
        unset($this->selectedRaces);
        $this->selectedRaces = array();

        // Vide la query des classes
        unset($this->wher);
        $this->wher = array();
    }

    // Fonction qui selectionne ou deselectionne un element, appelé depuis 'livewire.user-page.filter-builds'
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
    
    // Fonction qui deselectionne tous les elements, appelé depuis 'livewire.user-page.filter-builds'
    public function UnselectAllElements()
    {
        // Deselectionne les elements
        unset($this->selectedElements);
        $this->selectedElements = array();
        
        // Vide le tableau des élements deselectionné..
        unset($this->unselectedElements);
        $this->unselectedElements = array();

        $elements = Element::all();
        
        // ..pour le remplir correctement
        foreach($elements as $el) {
            $this->unselectedElements[] = $el->id;
        }
    }

    // Fonction appelé depuis 'livewire.user-page.filter-builds' qui toggle le filtrage stricte
    public function ToggleElementsOnly()
    {
        $this->elementsOnly = !$this->elementsOnly;
    }

    // Fonction qui supprime le build selectionné, appelé depuis 'layouts.deleteVerify'
    public function ToDelete($buildId)
    {        
        // Si l'utilisateur n'es pas admin, annule le delete
        if(!Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        // Récupère le build par rapport à son id
        $buildToDelete = Build::find($buildId); 
        
        $deletedBuildName = $buildToDelete->title;

        // Supprime l'image du storage
        Storage::delete($buildToDelete->image_path);

        // Supprime le build
        $buildToDelete->delete();

        // Envoie une notification de succé
        session()->flash('success', 'Le build ' . $deletedBuildName . ' a bien été supprimé');
    
    }

    // Rendu de la page
    public function render()
    {
        // Construction de la query avec le string des classes
        $buildsQuery = Build::where($this->wher)->with('element');
        
        // Ensuite ajoute à cette query les élements sélectionnés avec la relation many to many
        foreach($this->selectedElements as $id) {
            $buildsQuery->whereHas('element', function (Builder $query) use ($id) { 
                $query->having('element_id', '=', $id, 'and'); 
            });
        }

        // Si on veux un filtrage stricte, alors on précise qu'on ne veux pas voir les élements non sélectionnés
        if($this->elementsOnly) {
            if(count($this->unselectedElements) < Element::count()) {
                foreach($this->unselectedElements as $id) {
                    $buildsQuery->doesntHave('element', 'and', function (Builder $query) use ($id) { 
                        $query->having('element_id', '=', $id, 'and'); 
                    });
                }
            }
        }

        // Trier par classes
        $response = $buildsQuery->orderBy('race_id')->get();
        
        // Et on envoie !
        return view('livewire.user-page.filter-builds', ['elements' => Element::all(), 'races' => Race::all(), 'builds' => $response]);
    }
}
