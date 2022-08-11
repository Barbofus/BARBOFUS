<?php

namespace App\Http\Livewire;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class FilterBuilds extends Component
{
    public $selectedElements = [];
    public $selectedRaces = [];

    //public $buildsQuery;
    public $wher = [];


    public function boot()
    {
        //$this->buildsQuery = Build::orderBy("race_id")->get();
    }

    public function SelectRaces($id)
    {
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

    public function UnselectAllRaces()
    {
        unset($this->selectedRaces);
        $this->selectedRaces = array();

        unset($this->wher);
        $this->wher = array();
    }

    public function SelectElements($id)
    {
        if(!array_keys($this->selectedElements, $id))
        {
            $this->selectedElements[] = $id;
        }
        else {
            unset($this->selectedElements[array_search($id, $this->selectedElements)]);
        }
    }
    

    public function UnselectAllElements()
    {
        unset($this->selectedElements);
        $this->selectedElements = array();
    }

    public function render()
    {
        $buildsQuery = Build::where($this->wher)->with('element');

        foreach($this->selectedElements as $id) {
            $buildsQuery->whereHas('element', function (Builder $query) use ($id) { 
                $query->where('element_id', '=', $id, 'and'); 
            });
        }

        $response = $buildsQuery->orderBy('race_id')->get();
        
        return view('livewire.filter-builds', ['elements' => Element::all(), 'races' => Race::all(), 'builds' => $response]);
    }
}
