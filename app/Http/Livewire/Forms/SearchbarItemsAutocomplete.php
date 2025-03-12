<?php

namespace App\Http\Livewire\Forms;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class SearchbarItemsAutocomplete extends Component
{
    public string $category;

    public string $name;

    public string $placeholder;

    public string $query = '';

    public ?int $value;

    public int $selectedID = 0;

    public ?Item $selectedItem;

    /**
     * @var Collection<int, Item>
     */
    public $items;

    /**
     * @return void
     */
    public function mount()
    {
        $this->items = new Collection;

        // Si nous avons un item dans le champ à l'initialisation
        if ($this->value) {
            $this->useValue();
        }
    }

    /**
     * S'execute depuis le mount() lorsqu'il la $value initiale n'est pas null
     *
     * @return void
     */
    private function useValue()
    {
        // Récupère l'item présent dans le champ
        $this->selectedItem = Item::whereHas('localizedName')
            ->where('dofus_id', $this->value)
            ->when($this->category != '*', function ($query) {
                $query->where('category', $this->category);
            })
            ->first();

        // Utilise son nom dans la query
        $this->query = $this->selectedItem?->name ?? '';
    }

    /**
     * Fonction qui se déclenche lorsque la query change, dans l'input depuis la vue
     *
     * @return void
     */
    public function updatedQuery()
    {
        // Remet l'item selectionné à zéro
        $this->selectedID = 0;

        // Si la query est trop courte, on vide les selections et bloque la fonction
        if (strlen($this->query) < 3) {
            $this->selectedItem = null;
            $this->items = new Collection;

            return;
        }

        $this->searchForItems();
        $this->searchForPerfect();
    }

    /**
     * S'execute depuis updatedQuery(), cherche les items correspondant à la query
     *
     * @return void
     */
    private function searchForItems()
    {
        $this->items = Item::whereHas('localizedName', function ($query) {
            $query->where('locale', app()->getLocale())
                ->where('name', 'LIKE', "%{$this->query}%")
                ->where('name', '!=', $this->query);
        })
            ->when($this->category != '*', function ($query) {
                $query->where('category', $this->category);
            })
            ->limit(20)->get();
    }

    /**
     * S'execute depuis updatedQuery(), cherche si un item possède exactement le même nom que la query
     *
     * @return void
     */
    private function searchForPerfect()
    {
        $this->selectedItem = Item::whereHas('localizedName', function ($query) {
            $query->where('locale', app()->getLocale())
                ->where('name', '=', $this->query);
        })
            ->when($this->category != '*', function ($query) {
                $query->where('category', $this->category);
            })->first();
    }

    /**
     * S'éxecute depuis le front, via un clique gauche sur un item présent dans le menu déroulant
     *
     * @return void
     */
    public function setSelection(int $id)
    {
        $this->selectedID = $id;
        $this->useSelectionAsValue();
    }

    /**
     * S'execute via setSelection() - Permet d'utiliser la selection en tant que valeur
     *
     * @return void
     */
    private function useSelectionAsValue()
    {
        // Récupère l'item selectionné
        $this->selectedItem = $this->items[$this->selectedID];

        // Utilise son nom dans la query
        $this->query = $this->selectedItem->name;
        $this->items = new Collection;

        // Remet la selection à zéro
        $this->selectedID = 0;
    }

    /**
     * @return View
     */
    public function render()
    {
        return view('livewire.forms.searchbar-items-autocomplete');
    }
}
