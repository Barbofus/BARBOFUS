<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Skins\GetSkinChunk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class MyUnityskinsChunk extends Component
{
    /**
     * @var int[]
     */
    public $skinIds;

    public int $page;

    public int $itemsPerPage;

    /**
     * @return View
     */
    public function render()
    {
        $skins = DB::table('unity_skins')
            ->select('id', 'image_path', 'user_id', 'created_at', 'status', 'name')
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
            ->addSelect([ DB::raw('true as is_unity_skin') ])
            ->whereIn('id', $this->skinIds)
            ->get();

        foreach ($skins as $skin) {
            $skin->created_at = new Carbon($skin->created_at);
        }

        $orderedSkins = collect($this->skinIds)->map(function ($id) use ($skins) {
            return $skins->where('id', $id)->first();
        });

        return view('livewire.user-panel.my-unityskins-chunk', [
            'skins' => $orderedSkins,
        ]);
    }
}
