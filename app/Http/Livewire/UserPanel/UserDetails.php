<?php

namespace App\Http\Livewire\UserPanel;

use App\Models\UserNotificationPreferences;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class UserDetails extends Component
{
    /**
     * @return object|null
     */
    public function QueryUser()
    {
        $skinsIDCol = DB::table('skins')
            ->select('id')
            ->where('user_id', auth()->id())->get();

        $skinIDs = [];

        foreach ($skinsIDCol as $skinIDCol) {
            $skinIDs[] = $skinIDCol->id;
        }

        $user = DB::table('users')
            ->select('id', 'created_at', 'name', 'email')
            ->addSelect([
                'skin_count' => DB::table('skins')
                    ->selectRaw('count(id)')
                    ->whereColumn('user_id', 'users.id'),

                'like_given' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereColumn('user_id', 'users.id'),

                'like_received' => DB::table('likes')
                    ->selectRaw('count(id)')
                    ->whereIn('skin_id', $skinIDs),

                'ocre_wins' => DB::table('rewards')
                    ->selectRaw('count(id)')
                    ->whereIn('skin_id', $skinIDs)
                    ->where('rank', 1),

                'emerald_wins' => DB::table('rewards')
                    ->selectRaw('count(id)')
                    ->whereIn('skin_id', $skinIDs)
                    ->where('rank', 2),

                'cawotte_wins' => DB::table('rewards')
                    ->selectRaw('count(id)')
                    ->whereIn('skin_id', $skinIDs)
                    ->where('rank', 3),

                'mail_skin_validation_preference' => DB::table('user_notification_preferences')
                    ->selectRaw('value')
                    ->whereColumn('user_id', 'users.id')
                    ->where('notification_type', 'mail_skin_validation'),

                'mail_skin_winner_preference' => DB::table('user_notification_preferences')
                    ->selectRaw('value')
                    ->whereColumn('user_id', 'users.id')
                    ->where('notification_type', 'mail_skin_winner'),
            ])
            ->where('id', auth()->id())
            ->first();

        $user->created_at = new Carbon($user->created_at);

        return $user;
    }

    /**
     * @return void
     */
    public function togglePreference(string $pref, bool $currentValue)
    {
        UserNotificationPreferences::where('user_id', auth()->id())->where('notification_type', $pref)->delete();

        UserNotificationPreferences::create([
            'user_id' => auth()->id(),
            'notification_type' => $pref,
            'value' => ! $currentValue,
        ]);

        $this->dispatchBrowserEvent('alert-event', ['message' => 'Préférences enregistrées']);
    }

    /**
     * @return View
     */
    public function render()
    {
        return view('livewire.user-panel.user-details', [
            'user' => $this->QueryUser(),
        ]);
    }
}
