<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserPageUsersList extends Component
{
    public $users = [];

    public $currentUser;
    public $usersUptime = [];

    public $accountUptimeStr;

    public $sortType;
    public $sortSelection;

    public $roles = [];

    public $query;
    

    public function mount()
    {
        $this->sortSelection = 'created_at';
        $this->sortType = false;

        $this->query = '';

        $this->users = User::orderBy($this->sortSelection, $this->sortType ? 'Asc' : 'Desc')->get();
        $this->currentUser = Auth::user();

        $this->roles = Role::all();
        
        $this->accountUptimeStr = Self::CountUptime($this->currentUser);

        foreach($this->users as $user)
        {
            $this->usersUptime[$user->id] = Self::CountUptime($user);
        }
    }

    public function updatedQuery()
    {
        $this->users = User::where('name', 'like', '%'.$this->query.'%')
            ->orWhere('email', 'like', '%'.$this->query.'%')
            ->get();
    }

    public function ChangeSort($sType, $sSelection)
    {
        $this->sortSelection = $sSelection;
        $this->sortType = $sType;
        
        if($this->query)
        {
            $this->users = User::where('name', 'like', '%'.$this->query.'%')->orderBy($this->sortSelection, $this->sortType ? 'Asc' : 'Desc')->get();
        }
        else {
            $this->users = User::orderBy($this->sortSelection, $this->sortType ? 'Asc' : 'Desc')->get();
        }
    }

    public function DeleteUser($userName)
    {
        $userToDelete = User::where('name', $userName)->first(); 
        $userToDelete->delete();


        Self::ChangeSort($this->sortType, $this->sortSelection);
    }

    public function ChangeUserRole($userID, $newRole)
    {
        //$user = User::findOrFail($userID)->update(['role_id' => Role::findOrFail($newRole-1)->id]);
        $role = Role::find($newRole);
        $user = User::find($userID);

        $role->user()->save($user);

        session()->flash('message', $user->name.' est devenu '.$role->name.' avec succé !');
    }

    public function SearchUser($search)
    {
        dd($search);
    }

    protected function CountUptime($user)
    {
            // Récupération du temps écoulé en jours, mois, années depuis la création du compte
            $accountUptimeDay = $user->created_at->diffInDays(Carbon::now()) % 365 % 30;
            $accountUptimeMonth = $user->created_at->diffInMonths(Carbon::now()) % 12;
            $accountUptimeYear = $user->created_at->diffInYears(Carbon::now());
    
    
    
                // Création du string '3 ans, 4 mois et 87 jours'
            $str = '';
    
            if($accountUptimeYear > 0) {
                if($accountUptimeYear > 1) {
                    $str .= $accountUptimeYear.' ans ';
                }
                else {
                    $str .= $accountUptimeYear.' an ';
                }
            }
    
            if($accountUptimeMonth > 0) {
                $str .= $accountUptimeMonth.' mois ';
            }
    
            if($accountUptimeDay > 0) {
                $str .= $accountUptimeDay.' jours';
            }
            else if($accountUptimeYear > 0 || $accountUptimeMonth > 0){
                $str .= ' et moins d\'un jour';
            }
            else{
                $str .= 'Moins d\'un jour';
            }

            return $str;
    }

    
    public function render()
    {
        return view('livewire.user-page-users-list');
    }
}
