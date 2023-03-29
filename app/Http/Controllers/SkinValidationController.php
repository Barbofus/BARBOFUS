<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use App\Notifications\SkinPostedNotification;
use App\Notifications\SkinRefusedNotification;
use Illuminate\Http\Request;

class SkinValidationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skins = Skin::where('status', '=', 'pending')->get();

        return view('admin_panel.skins-validation', [
            'skins' => $skins
        ]);
    }

    public function accept(Request $request, Skin $skin)
    {
        $skin->update([
           'status' => 'Posted'
        ]);

        $skin->User->notify(new SkinPostedNotification($skin));

        return back();
    }

    public function refuse(Request $request, Skin $skin)
    {
        $skin->update([
            'status' => 'Refused',
            'refused_reason' => $request->reason
        ]);

        $skin->User->notify(new SkinRefusedNotification($skin));

        return back();
    }
}
