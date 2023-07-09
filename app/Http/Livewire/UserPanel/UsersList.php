<?php

namespace App\Http\Livewire\UserPanel;

use Illuminate\View\View;
use Livewire\Component;

class UsersList extends Component
{
    /**
     * @return View
     */
    public function render()
    {
        return view('livewire.user-panel.users-list');
    }
}
