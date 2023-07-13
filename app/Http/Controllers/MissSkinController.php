<?php

namespace App\Http\Controllers;

use App\Actions\MissSkin\FindWinners;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MissSkinController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if (! Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        (new FindWinners())();

        session()->flash('miss-skin', 'Les nouveaux vainqueurs Miss\'Skin ont bien été désignés');
        session()->flash('section', 'admin-panel');

        return redirect()->route('user-dashboard.index');
    }
}
