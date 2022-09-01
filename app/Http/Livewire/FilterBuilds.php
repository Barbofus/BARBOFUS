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
    public $unselectedElements = [];

    public $selectedRaces = [];

    public $wher = [];

    public $elementsOnly = true;


    public function mount()
    {
        Self::UnselectAllElements();
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
            unset($this->unselectedElements[array_search($id, $this->unselectedElements)]);
        }
        else {
            unset($this->selectedElements[array_search($id, $this->selectedElements)]);
            $this->unselectedElements[] = $id;
        }
    }
    

    public function UnselectAllElements()
    {
        unset($this->selectedElements);
        $this->selectedElements = array();
        
        unset($this->unselectedElements);
        $this->unselectedElements = array();

        $elements = Element::all();

        foreach($elements as $el) {
            $this->unselectedElements[] = $el->id;
        }
    }

    public function render()
    {
        $buildsQuery = Build::where($this->wher)->with('element');
        
        foreach($this->selectedElements as $id) {
            $buildsQuery->whereHas('element', function (Builder $query) use ($id) { 
                $query->having('element_id', '=', $id, 'and'); 
            });
        }

        if($this->elementsOnly) {
            if(count($this->unselectedElements) < Element::count()) {
                foreach($this->unselectedElements as $id) {
                    $buildsQuery->doesntHave('element', 'and', function (Builder $query) use ($id) { 
                        $query->having('element_id', '=', $id, 'and'); 
                    });
                }
            }
        }

        $response = $buildsQuery->orderBy('race_id')->get();
        
        return view('livewire.filter-builds', ['elements' => Element::all(), 'races' => Race::all(), 'builds' => $response]);
    }
}
