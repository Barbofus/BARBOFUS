<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use App\Notifications\SkinPostedNotification;
use App\Notifications\SkinRefusedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkinValidationController extends Controller
{



    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
