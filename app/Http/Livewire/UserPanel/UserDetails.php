<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Discord\ConnectToDiscord;
use App\Actions\Discord\GetDiscordUserInfo;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Connection;
use App\Models\User;
use App\Models\UserNotificationPreferences;
use App\Notifications\UserNameChangeNotification;
use App\Notifications\UserPasswordChangeNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class UserDetails extends Component
{
    public string $current_password = '';

    public string $password_confirmation = '';

    public string $password = '';

    public string $name = '';

    public string $email = '';

    /**
     * @var Connection|void
     */
    public $discord;

    public User $currentUser;

    /**
     * @return void
     */
    public function mount()
    {
        $this->currentUser = User::find(auth()->id());

        // Si on reçoit le code de l'auth discord
        if (isset($_GET['code'])) {
            $this->GetDiscordConnection($_GET['code']);
        }
    }

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

                'unity_skin_count' => DB::table('unity_skins')
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

                'mail_haven_bag_validation_preference' => DB::table('user_notification_preferences')
                    ->selectRaw('value')
                    ->whereColumn('user_id', 'users.id')
                    ->where('notification_type', 'mail_haven_bag_validation'),
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
     * @return void
     */
    public function ChangeUsername()
    {
        (new UpdateUserProfileInformation)->update($this->currentUser, ['name' => $this->name, 'email' => $this->currentUser->email]);

        $this->currentUser->notify(new UserNameChangeNotification($this->currentUser));

        $this->dispatchBrowserEvent('alert-event', ['message' => 'Nouveau pseudo enregistré']);
    }

    /**
     * @return void|null
     */
    public function ChangeUserEMail()
    {
        (new UpdateUserProfileInformation)->update($this->currentUser, ['name' => $this->currentUser->name, 'email' => $this->email]);

        session()->flash('alert-message', 'Nouvelle adresse e-mail enregistrée, valide-la dans tes emails pour te reconnecter');

        $id = auth()->id();

        Auth::logout();

        return $this->redirect(route('verification.notice', ['id' => $id]));
    }

    /**
     * @return void
     */
    public function ChangeUserPassword()
    {
        (new UpdateUserPassword)->update($this->currentUser, ['current_password' => $this->current_password, 'password' => $this->password, 'password_confirmation' => $this->password_confirmation]);

        $this->currentUser->notify(new UserPasswordChangeNotification($this->currentUser));

        $this->dispatchBrowserEvent('alert-event', ['message' => 'Nouveau mot de passe enregistré']);
    }

    /**
     * @return void
     */
    public function DiscordConnectionUrl()
    {
        $this->redirect(config('app.discord_connection_url'));
    }

    /**
     * @return void
     */
    public function GetDiscordConnection(string $code)
    {
        (new ConnectToDiscord)($code);
    }

    /**
     * @return void
     */
    public function DisconnectDiscord()
    {
        Auth::user()->Connections()->where('name', 'discord')->delete();
    }

    /**
     * @return View
     */
    public function render()
    {
        // Récupère le compte discord (s'il est link)
        $this->discord = (new GetDiscordUserInfo)(Auth::id());

        return view('livewire.user-panel.user-details', [
            'user' => $this->QueryUser(),
        ]);
    }
}
