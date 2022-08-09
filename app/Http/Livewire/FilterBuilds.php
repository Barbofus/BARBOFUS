<?php

namespace App\Http\Livewire;

use App\Models\Element;
use App\Models\Race;
use Livewire\Component;

class FilterBuilds extends Component
{
    //public $selectedElements = [1,2,3,4,5,6];
    //public $selectedRaces = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
    public $selectedElements = [];
    public $selectedRaces = [];

    // public function mount($elements, $races)
    // {
    //     $this->$elements = $elements;
    //     $this->$races = $races;
    // }

    public function SelectRaces($id)
    {
        if(!array_keys($this->selectedRaces, $id))
        {
            $this->selectedRaces[] = $id;
        }
        else {
            unset($this->selectedRaces[array_search($id, $this->selectedRaces)]);
        }
    }

    public function UnselectAllRaces()
    {
        unset($this->selectedRaces);
        $this->selectedRaces = array();
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
        return view('livewire.filter-builds', ['elements' => Element::all(), 'races' => Race::all()]);
    }
}
