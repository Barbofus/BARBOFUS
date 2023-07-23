<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return View
     */
    public function __invoke(Request $request)
    {

        return view('home', [
            'skins' => $this->GetLastSkins(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
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
