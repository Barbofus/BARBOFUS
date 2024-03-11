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

        $newItems = (new UpdateItemsFromDofusDBApi)();

        session()->put('newItems', $newItems);
        return redirect()->route('user-dashboard.index', 'section=admin-panel');
    }
}
