<?php

namespace App\Http\Livewire\UserPanel;

use Illuminate\View\View;
use Livewire\Component;

class UserDashboard extends Component
{
    public string $section = 'user-details';

    /**
     * @return void
     */
    public function mount()
    {
        if (session()->has('section')) {
            $this->section = session('section');
        }
    }

    /**
     * @return View
     */
    public function render()
    {
        return view('livewire.user-panel.user-dashboard');
    }

    /**
     * @return void
     */
    public function ChangeSection(string $newSection)
    {
        $this->section = $newSection;
        $this->dispatchBrowserEvent('user-dashboard-change');
    }
}
