<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use Illuminate\Http\Request;

class SkinValidationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $skins = Skin::where('status', '=', 'pending')->get();

        return view('admin_panel.skins-validation', [
            'skins' => $skins
        ]);
    }
}
