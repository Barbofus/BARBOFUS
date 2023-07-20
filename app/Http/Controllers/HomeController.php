<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        return view('home', [
            'skins' => $this->GetLastSkins(),
        ]);
    }

    public function GetLastSkins()
    {
        return DB::table('skins')
            ->select('id', 'image_path', 'user_id', 'updated_at', 'status')
            ->where('status', 'posted')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'skins.user_id')
                    ->take(1),
            ])
            ->orderBy('updated_at', 'DESC')
            ->take(10)
            ->get();
    }
}
