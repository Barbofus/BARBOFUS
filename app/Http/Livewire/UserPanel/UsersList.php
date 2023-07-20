<?php

namespace App\Http\Livewire\UserPanel;

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
        return view('livewire.user-panel.users-list', [
            'users' => $this->GetAllUsers(),
            'roles' => $this->GetRoles(),
        ]);
    }

    /**
     * @return Collection<int, array<string, string|int>>
     */
    public function GetRoles()
    {
        return new Collection(DB::table('roles')
            ->select('id', 'name')
            ->get());
    }

    /**
     * @return Collection<int, array<string, string|int>>
     */
    public function GetAllUsers()
    {
        return new Collection(DB::table('users')
            ->select('id', 'role_id', 'name')
            ->addSelect([
                'role_name' => DB::table('roles')
                    ->select('name')
                    ->whereColumn('id', 'role_id')
                    ->take(1),
            ])
            ->where('name', 'LIKE', '%'.$this->query.'%')
            ->orderBy('role_id', 'DESC')
            ->orderBy('name', 'ASC')
            ->get());
    }

    /**
     * @param int $userID
     * @return void
     */
    public function deleteUser(int $userID)
    {
        $user = User::find($userID);

        $this->dispatchBrowserEvent('alert-event', ['message' => 'Le compte de '.$user->name.' a été supprimé.']);

        $user->delete();
    }

    /**
     * @return void
     */
    public function ChangeRole(int $userID, int $newRoleID)
    {
        $user = User::find($userID);

        $user->update([
            'role_id' => $newRoleID,
        ]);

        $this->dispatchBrowserEvent('alert-event', ['message' => $user->name.' devient '.$user->Role->name]);
    }
}
