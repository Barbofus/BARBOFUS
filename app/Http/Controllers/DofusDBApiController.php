<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DofusDBApiController extends Controller
{
    //

    public function __invoke()
    {
        if(!Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        dd('DofusDBApiController - Update');

        return back();
    }
}
