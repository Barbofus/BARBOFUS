<?php

namespace App\Http\Livewire\UserPanel;

use App\Actions\Discord\GetDiscordUsersInfo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class UsersList extends Component
{
    public string $query = '';

    /**
     * @return View
     */
    public function render()
    {
        $users = $this->GetAllUsers();
        $discordInfos = $this->GetDiscordInfos($users);

        return view('livewire.user-panel.users-list', [
            'userCount' => User::count('id'),
            'users' => $users,
            'roles' => $this->GetRoles(),
            'discordInfos' => $discordInfos,
        ]);
    }

    /**
     * @return Collection<int, \stdClass>
     */
    public function GetRoles()
    {
        return new Collection(DB::table('roles')
            ->select('id', 'name')
            ->get());
    }

    /**
     * @return Collection<int, User>
     */
    public function GetAllUsers()
    {
        return User::query()
            ->select(['users.id', 'users.name', 'users.email'])
            ->with('roles:id,name')
            ->when($this->query, function ($query) {
                $query->where('users.name', 'LIKE', '%'.$this->query.'%');
            })
            ->orderByDesc(
                DB::table('role_user')
                    ->selectRaw('MAX(role_id)')
                    ->whereColumn('user_id', 'users.id')
            )
            ->orderBy('users.name', 'asc')
            ->limit(50)
            ->get();
    }

    /**
     * @return void
     */
    public function deleteUser(int $userID)
    {
        $user = User::find($userID, 'id');

        $this->dispatchBrowserEvent('alert-event', ['message' => 'Le compte de '.$user->name.' a été supprimé.']);

        $user->delete();
    }

    /**
     * @return void
     */
    public function ToggleRole(int $userId, int $roleId)
    {
        $user = User::with('roles')->findOrFail($userId);
        $role = Role::findOrFail($roleId);

        // Si l'utilisateur a déjà le rôle → on le retire
        if ($user->roles->contains('id', $roleId)) {
            $user->roles()->detach($roleId);

            // Événement navigateur
            $this->dispatchBrowserEvent('alert-event', [
                'message' => $user->name.' quitte '.$role->name,
            ]);
        } else {
            // Sinon, on l'ajoute
            $user->roles()->attach($roleId);

            // Événement navigateur
            $this->dispatchBrowserEvent('alert-event', [
                'message' => $user->name.' devient '.$role->name,
            ]);
        }

        // Rafraîchir les rôles dans l'instance Livewire
        $user->load('roles');
    }

    /**
     * Récupère les informations Discord pour tous les utilisateurs de manière optimisée
     *
     * @param  Collection<int, User>  $users
     * @return array<int, array<string, mixed>|null>
     */
    private function GetDiscordInfos(Collection $users): array
    {
        $userIds = $users->pluck('id');

        return (new GetDiscordUsersInfo)($userIds);
    }
}
