<?php

namespace App\Http\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class SkinFilterSearchBar extends Component
{
    /**
     * @var array<int, string>
     */
    public $searchFilterInput;

    public int $selectionKey = 0;

    public string $query = '';

    public string $oldQuery = '';

    public mixed $itemToShow = [];

    /**
     * @var string[]
     */
    protected $models = [
        'users',
        'dofus_item_hats',
        'dofus_item_cloaks',
        'dofus_item_shields',
        'dofus_item_pets',
        'dofus_item_costumes',
    ];

    /**
     * @var string[]
     */
    protected $listeners = [
        'ToggleSearchedText' => 'emptyQuery',
    ];

    /**
     * @return View
     */
    public function render()
    {
        $this->findForItems($this->query);

        return view('livewire.forms.skin-filter-search-bar');
    }

    /**
     * @return void
     */
    public function findForItems(string $query)
    {

        $this->itemToShow = [];

        if ($this->oldQuery != $this->query) {
            $this->selectionKey = 0;
        }

        if (strlen($query) < 3) {
            return;
        }

        foreach ($this->models as $model) {
            $select = ['name', 'id'];

            if ($model != 'users') {
                $select[] = 'icon_path';
            }

            $items = DB::table($model)
                ->select($select)
                ->where('name', 'LIKE', '%'.$query.'%')
                ->get()
                ->toArray();

            foreach ($items as $item) {
                $item->is_user = ($model == 'users');
            }

            $this->itemToShow = array_merge($this->itemToShow, $items);
        }

        asort($this->itemToShow);
        $this->itemToShow = array_values($this->itemToShow);

        $this->oldQuery = $query;
    }

    /**
     * @return void
     */
    public function emptyQuery()
    {
        $this->query = '';
        $this->itemToShow = [];
    }

    /**
     * @return void
     */
    public function incrementSelection()
    {

        $this->selectionKey++;

        if ($this->selectionKey > count($this->itemToShow) - 1) {
            $this->selectionKey = 0;
        }
    }

    /**
     * @return void
     */
    public function decrementSelection()
    {

        $this->selectionKey--;

        if ($this->selectionKey < 0) {
            $this->selectionKey = count($this->itemToShow) - 1;
        }

    }
}
