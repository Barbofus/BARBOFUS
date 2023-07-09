<?php

namespace App\Http\Controllers;

use App\Actions\DofusDBApi\UpdateItemsFromDofusDBApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class DofusDBApiController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        if (! Gate::allows('admin-access')) {
            abort(403, 'Autorisation requise');
        }

        (new UpdateItemsFromDofusDBApi)();

        return back();
    }
}
