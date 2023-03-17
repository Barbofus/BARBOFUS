<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;

class SearchbarItemsAutocomplete extends Component
{
    public $relatedModel;
    public $name;
    public $value;
    public $placeholder;

    public $selectedItem = 0;
    public $existentItem = null;

    public $query = '';

    public $previousQuery = '';
    public $itemsToShow = [];


    public function mount($value) {

        if($value){
            $this->existentItem = $this->relatedModel::where('id', '=', $value)->first();

            $this->query = $this->existentItem->name;
            $this->previousQuery = $this->query;
        }

        $this->updatedQuery($this->query);
    }

    public function resetSelection()
    {
        $this->selectedItem = 0;
    }

    public function incrementSelection()
    {
        if($this->selectedItem >= count($this->itemsToShow) - 1)
        {
            $this->selectedItem = 0;
            return;
        }

        $this->selectedItem ++;
    }

    public function decrementSelection()
    {
        if($this->selectedItem <= 0)
        {
            $this->selectedItem = count($this->itemsToShow) - 1;
            return;
        }

        $this->selectedItem --;
    }

    public function setSelection($value)
    {
        $this->selectedItem = $value;

        $this->useSelectionAsValue();
    }

    public function updatedQuery($query)
    {
        if(strlen($query) > 2 ) {

            // Si la query à changé
            if($this->previousQuery != $query) {

                // On reset la selection
                $this->resetSelection();

                // Prend les premiers items contenant la recherche en excluant le résultat exact
                $this->itemsToShow = $this->relatedModel::where('name', '!=', $query)->where('name', 'LIKE', '%'.$query.'%')->take(5)->get();

                // Si l'item exact est écris, on le dit pour changer le visuel
                $this->existentItem = $this->relatedModel::where('name', '=', $query)->first();
            }

            $this->previousQuery = $query;

            return;
        }

        $this->itemsToShow = [];
    }

    // Remplace la query par l'item selectionné
    public function useSelectionAsValue()
    {
        $this->query = $this->itemsToShow[$this->selectedItem]->name;
    }

    public function render()
    {
        $this->updatedQuery($this->query);

        return view('livewire.forms.searchbar-items-autocomplete', ['items' => $this->itemsToShow]);
    }
}
