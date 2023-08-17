<?php

namespace App\Http\Livewire\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class SearchbarItemsAutocomplete extends Component
{
    public string $relatedModel;

    public string $name;

    public string|int|null $value;

    public string $placeholder;

    public int $selectedItem = 0;

    /**
     * @var Collection<int|string, mixed>
     */
    public $existentItem;

    public string $query = '';

    public string $previousQuery = '';

    public mixed $itemsToShow = [];

    /**
     * @return void
     */
    public function mount(string|int|null $value)
    {

        if ($value) {
            $this->existentItem = $this->ExistentQuery($value);
            $this->query = $this->existentItem['name'];
            $this->previousQuery = $this->query;
        }

        $this->updatedQuery($this->query);
    }

    /**
     * @return void
     */
    public function emptyQuery()
    {
        $this->query = '';
        $this->itemsToShow = [];
    }

    /**
     * @return Collection<int|string, mixed>
     */
    public function ExistentQuery(string|int $value)
    {
        return new Collection(DB::table($this->relatedModel)
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

    /**
     * @return void
     */
    public function resetSelection()
    {
        // Aucun id selectionné
        $this->selectedItem = 0;

        // Vide le dropdown
        $this->itemsToShow = [];

        // Aucun item selectionné
        $this->existentItem = new Collection();
    }

    /**
     * @return void
     */
    public function incrementSelection()
    {
        if ($this->selectedItem >= count($this->itemsToShow) - 1) {
            $this->selectedItem = 0;

            return;
        }

        $this->selectedItem++;
    }

    /**
     * @return void
     */
    public function decrementSelection()
    {
        if ($this->selectedItem <= 0) {
            $this->selectedItem = count($this->itemsToShow) - 1;

            return;
        }

        $this->selectedItem--;
    }

    /**
     * @return void
     */
    public function setSelection(string|int $value)
    {
        $this->selectedItem = $value;

        $this->useSelectionAsValue();
    }

    /**
     * @return void
     */
    public function updatedQuery(string $query)
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

        if ($this->query != $this->previousQuery) {
            $this->selectedItem = 0;
        }

        $this->previousQuery = $query;

    }

    /**
     * @return void
     */
    // Remplace la query par l'item selectionné
    public function useSelectionAsValue()
    {
        if (! $this->itemsToShow) {
            return;
        }

        $this->query = [$this->itemsToShow[$this->selectedItem]][0]['name'];
    }

    /**
     * @return View
     */
    public function render()
    {
        $this->updatedQuery($this->query);

        return view('livewire.forms.searchbar-items-autocomplete', ['items' => $this->itemsToShow]);
    }
}
