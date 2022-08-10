<?php

namespace App\Http\Livewire;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Livewire\Component;

class FilterBuilds extends Component
{
    //public $selectedElements = [1,2,3,4,5,6];
    //public $selectedRaces = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
    public $selectedElements = [];
    public $selectedRaces = [];

    public $builds;
    public $wher = [];
    

    // public function mount($elements, $races)
    // {
    //     $this->$elements = $elements;
    //     $this->$races = $races;
    // }

    public function boot()
    {
        $this->builds = Build::orderBy("race_id")->get();
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
        $this->builds = Build::where($this->wher)->orderBy("race_id")->get();
        return view('livewire.filter-builds', ['elements' => Element::all(), 'races' => Race::all(), 'builds' => $this->builds]);
    }
}
