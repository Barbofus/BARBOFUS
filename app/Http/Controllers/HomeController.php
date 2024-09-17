<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Skin;
use App\Models\UnitySkin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            'skinCount' => $this->getSkinCount(),
            'userCount' => $this->getUserCount(),
            'racesName' => $this->getRacesName(),
        ]);
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRacesName()
    {
        return Race::select('name')->get();
    }

    /**
     * @return float|int
     */
    public function getSkinCount()
    {
        return floor((Skin::count() + UnitySkin::count()) / 10) * 10;
    }

    /**
     * @return float|int
     */
    public function getUserCount()
    {
        return floor(User::count() / 10) * 10;
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public function GetLastSkins()
    {
        return DB::table('unity_skins')
            ->select('id', 'image_path', 'user_id', 'updated_at', 'status')
            ->where('status', 'posted')
            ->addSelect([
                'user_name' => DB::table('users')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.user_id')
                    ->take(1),
            ])
            ->addSelect([
                'race_name' => DB::table('races')
                    ->select('name')
                    ->whereColumn('id', 'unity_skins.race_id')
                    ->take(1),
            ])
            ->inRandomOrder()
            ->take(10)
            ->get();
    }
}
