<?php

namespace App\Http\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SkinFilterSearchBar extends Component
{
    public $searchFilterInput;
    public $selectionKey = 0;

    public $query = '';
    public $oldQuery = '';

    public $itemToShow = array();

    protected $models = [
        'users',
        'dofus_item_hats',
        'dofus_item_cloaks',
        'dofus_item_shields',
        'dofus_item_pets',
        'dofus_item_costumes',
    ];



    protected $listeners = [
        'ToggleSearchedText' => 'emptyQuery',
    ];


    public function render()
    {
        $this->findForItems($this->query);

        return view('livewire.forms.skin-filter-search-bar');
    }

    public function findForItems($query)
    {

        $this->itemToShow = array();

        if($this->oldQuery != $this->query)
            $this->selectionKey = 0;

        if(strlen($query) < 3) {
            return;
        }

        foreach ($this->models as $model) {
            $select = array();
            $select[] = 'name';

            if($model != 'users')
                $select[] = 'icon_path';

            $items = DB::table($model)
                ->select($select)
                ->where('name','LIKE', '%'. $query .'%')
                ->get()
                ->toArray();

            $this->itemToShow = array_merge($this->itemToShow, $items);
        }

        asort($this->itemToShow);
        $this->itemToShow = array_values($this->itemToShow);

        $this->oldQuery = $query;
    }

    public function emptyQuery()
    {
        $this->query = '';
        $this->itemToShow = array();
    }

    public function incrementSelection () {

        $this->selectionKey ++;

        if($this->selectionKey > count($this->itemToShow) - 1)
            $this->selectionKey = 0;
    }

    public function decrementSelection () {

        $this->selectionKey --;

        if($this->selectionKey < 0)
            $this->selectionKey = count($this->itemToShow) - 1;

    }
}
