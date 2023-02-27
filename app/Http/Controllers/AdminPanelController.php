<?php

namespace App\Http\Controllers;

use App\Actions\DofusDBApi\CheckDofusDBUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminPanelController extends Controller
{
    //

    public function __invoke()
    {
        if(!Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        $needDofusDBUpdate = (new CheckDofusDBUpdate)();

        return view('user_page.adminPanel', ['needDofusDBUpdate' => $needDofusDBUpdate]);
    }
}
