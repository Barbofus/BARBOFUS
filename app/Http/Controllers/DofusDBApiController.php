<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Actions\DofusDBApi\UpdateItemsFromDofusDBApi;

class DofusDBApiController extends Controller
{
    //

    public function __invoke()
    {
        if(!Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        (new UpdateItemsFromDofusDBApi)();

        return back();
    }
}
