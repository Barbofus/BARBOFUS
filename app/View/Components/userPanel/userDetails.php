<?php

namespace App\View\Components\userPanel;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class userDetails extends Component
{
    /**
     * @return object|null
     */
    public function QueryUser()
    {
        $user = DB::table('users')
            ->select('id', 'created_at', 'name', 'email')
            ->addSelect([
                'skin_count' => DB::table('skins')
                    ->selectRaw('count(id)')
                    ->whereColumn('user_id', 'users.id'),

                'like_given' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('user_id', 'users.id'),
            ])
            ->where('id', auth()->id())
            ->first();

        $user->created_at = new Carbon($user->created_at);

        return $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-panel.user-details', [
            'user' => $this->QueryUser(),
        ]);
    }
}
