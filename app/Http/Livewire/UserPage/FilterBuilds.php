<?php

namespace App\Http\Livewire\UserPage;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class FilterBuilds extends Component
{    
    
    public $selectedElements = [];
    public $selectedRaces = [];


    public $wher = [];
    

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

    public function ToDelete($buildTitle)
    {        
        if(!Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        $buildToDelete = Build::where('title', $buildTitle)->first(); 
        
        $deletedBuildName = $buildToDelete->title;

        Storage::delete($buildToDelete->image_path);

        $buildToDelete->delete();

        
        session()->flash('success', 'Le build ' . $deletedBuildName . ' a bien été supprimé');
    
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
        
        return view('livewire.user-page.filter-builds', ['elements' => Element::all(), 'races' => Race::all(), 'builds' => $response]);
    }
}
