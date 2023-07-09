<?php

namespace App\View\Components\userPanel;

use App\Actions\DofusDBApi\CheckDofusDBUpdate;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;

class adminPanel extends Component
{
    public bool $needDofusDBUpdate;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        $this->needDofusDBUpdate = (new CheckDofusDBUpdate)();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-panel.admin-panel', ['needDofusDBUpdate' => $this->needDofusDBUpdate]);
    }
}
