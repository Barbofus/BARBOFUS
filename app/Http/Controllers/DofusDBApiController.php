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

        /*$testArray = [
            [
                'Crâne de Truche',
                'images/icons/items/hats/16814.png',
            ],
            [
                'Crâne de Trouche',
                'images/icons/items/hats/16346.png',
            ],
            [
                'Croune de Trâche',
                'images/icons/items/hats/16804.png',
            ],
        ];*/

        //dd($newItems, $testArray);

        return redirect()->route('user-dashboard.index', 'section=admin-panel')->with('newItems', $newItems);
    }
}
