<?php

namespace App\Http\Livewire\UserPanel;

use Livewire\Component;

class UserDashboard extends Component
{
    public $section = 'user-details';

    public function mount()
    {
        if(session()->has('section')){
            $this->section = session('section');
        }
    }

    public function render()
    {
        return view('livewire.user-panel.user-dashboard');
    }

    public function ChangeSection($newSection)
    {
        $this->section = $newSection;
        $this->dispatchBrowserEvent('user-dashboard-change');
    }
}
