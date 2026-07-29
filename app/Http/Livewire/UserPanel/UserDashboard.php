<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\Item;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class UserDashboard extends Component
{
    public string $section = 'user-details';

    public int $skinsToComplete = 0;

    /**
     * @return void
     */
    public function mount()
    {
        if (request()->has('section')) {
            $this->section = request('section');
        }
    }

    /**
     * @return View
     */
    public function render()
    {
        if (Gate::check('admin-access')) {
            $this->skinsToComplete = Item::whereNull('asset_id')->count();
        }

        return view('livewire.user-panel.user-dashboard');
    }

    /**
     * @return void
     */
    public function ChangeSection(string $newSection)
    {
        $this->section = $newSection;
        $this->dispatchBrowserEvent('user-dashboard-change', [
            'section' => $newSection,
        ]);
    }
}
