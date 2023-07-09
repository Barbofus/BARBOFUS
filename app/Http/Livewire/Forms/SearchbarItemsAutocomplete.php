<?php

namespace App\Http\Livewire\Forms;

use Illuminate\Support\Facades\DB;
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

    public function mount($value)
    {

        if ($value) {
            $existentItem = $this->ExistentQuery($value);
            $this->existentItem = collect($existentItem);
            $this->query = $this->existentItem['name'];
            $this->previousQuery = $this->query;
        }

        $this->updatedQuery($this->query);
    }

    public function ExistentQuery($value)
    {
        return collect(DB::table($this->relatedModel)
            ->select('id', 'icon_path', 'name', 'level')
            ->where('id', '=', $value)
            ->orWhere('name', '=', $value)
            ->addSelect([
                'sub_icon_path' => DB::table('dofus_items_sub_categories')
                    ->select('icon_path')
                    ->whereColumn('dofus_items_sub_categories.id', $this->relatedModel.'.dofus_items_sub_categorie_id')
                    ->take(1),
            ])
            ->addSelect([
                'sub_name' => DB::table('dofus_items_sub_categories')
                    ->select('name')
                    ->whereColumn('dofus_items_sub_categories.id', $this->relatedModel.'.dofus_items_sub_categorie_id')
                    ->take(1),
            ])
            ->first());
    }

    public function resetSelection()
    {
        // Aucun id selectionné
        $this->selectedItem = 0;

        // Vide le dropdown
        $this->itemsToShow = [];

        // Aucun item selectionné
        $this->existentItem = null;
    }

    public function incrementSelection()
    {
        if ($this->selectedItem >= count($this->itemsToShow) - 1) {
            $this->selectedItem = 0;

            return;
        }

        $this->selectedItem++;
    }

    public function decrementSelection()
    {
        if ($this->selectedItem <= 0) {
            $this->selectedItem = count($this->itemsToShow) - 1;

            return;
        }

        $this->selectedItem--;
    }

    public function setSelection($value)
    {
        $this->selectedItem = $value;

        $this->useSelectionAsValue();
    }

    public function updatedQuery($query)
    {
        // Si la recherche est trop courte
        if (strlen($query) < 3) {

            // On reset la selection
            $this->resetSelection();
            $this->previousQuery = $query;

            return;
        }

        // Prend les premiers items contenant la recherche en excluant le résultat exact
        $this->itemsToShow = DB::table($this->relatedModel)
            ->select('id', 'icon_path', 'name', 'level')
            ->where('name', '!=', $query)
            ->where('name', 'LIKE', '%'.$query.'%')
            ->addSelect([
                'sub_icon_path' => DB::table('dofus_items_sub_categories')
                    ->select('icon_path')
                    ->whereColumn('dofus_items_sub_categories.id', $this->relatedModel.'.dofus_items_sub_categorie_id')
                    ->take(1),
            ])
            ->addSelect([
                'sub_name' => DB::table('dofus_items_sub_categories')
                    ->select('name')
                    ->whereColumn('dofus_items_sub_categories.id', $this->relatedModel.'.dofus_items_sub_categorie_id')
                    ->take(1),
            ])
            ->get();

        // Si l'item exact est écrit, on le dit pour changer le visuel
        $this->existentItem = $this->ExistentQuery($query);

        $this->previousQuery = $query;

    }

    // Remplace la query par l'item selectionné
    public function useSelectionAsValue()
    {
        if (! $this->itemsToShow) {
            return;
        }

        $this->query = $this->itemsToShow[$this->selectedItem]['name'];
    }

    public function render()
    {
        $this->updatedQuery($this->query);

        return view('livewire.forms.searchbar-items-autocomplete', ['items' => $this->itemsToShow]);
    }
}
