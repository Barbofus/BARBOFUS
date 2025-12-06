<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Store a newly created favorite in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'integer|required|exists:items,dofus_id',
        ]);

        Favorite::create([
            'user_id' => $request->user()->id,
            'item_id' => $validated['item_id'],
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified favorite from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'integer|required|exists:items,dofus_id',
        ]);

        Favorite::where('user_id', $request->user()->id)
            ->where('item_id', $validated['item_id'])
            ->delete();

        return response()->noContent();
    }
}
