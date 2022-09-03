<?php

namespace App\Http\Livewire\UserPage;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UsersList extends Component
{
    
    public $users = []; // Liste des utilisateurs

    public $currentUser; // Utilisateur actuellement connecté
    public $usersUptime = []; // Liste des âges de comptes

    public $sortType; // Type de trie, ASC ou DESC
    public $sortSelection; // Quel catégorie sera trier (id, nom, email etc.)

    public $roles = []; // Liste des rôles

    public $query; //  Le contenu de la barre de recherche
    

    // Fonction qui s'execute à l'init, comme un construct
    public function mount()
    {
        // On remplit toutes les variables créées
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

    // Fonctionne appelé à chaque changement dans la barre de recherche
    public function updatedQuery()
    {
        // Récupère les users contenu la query dans leur nom ou email
        $this->users = User::where('name', 'like', '%'.$this->query.'%')
            ->orWhere('email', 'like', '%'.$this->query.'%')
            ->get();
    }

    // Fonction appelé par le clique des en-têtes du tableau des utilisateur, elle change la l'ordre de trie
    public function ChangeSort($sType, $sSelection)
    {
        $this->sortSelection = $sSelection;
        $this->sortType = $sType;
        
        // Si on a un texte dans la barre de recherche, le conserve avec le 'where()'
        if($this->query)
        {
            $this->users = User::where('name', 'like', '%'.$this->query.'%')->orderBy($this->sortSelection, $this->sortType ? 'Asc' : 'Desc')->get();
        }
        else {
            $this->users = User::orderBy($this->sortSelection, $this->sortType ? 'Asc' : 'Desc')->get();
        }
    }

    // Fonction appelé par le 'layouts.deleteVerify' visant à supprimé définitivement l'utilisateur
    public function ToDelete($userID)
    {
        // Récupère l'utilisateur actuel grace à son id et le supprime
        //$userToDelete = User::where('name', $userName)->first(); 
        $userToDelete = User::find($userID); 
        $deletedUserName = $userToDelete->name;

        $userToDelete->delete();

        // Envoie une notification de succé
        session()->flash('success', 'L\'utilisateur ' . $deletedUserName . ' à bien été supprimé');

        // Actualise la liste des utlisateurs
        Self::ChangeSort($this->sortType, $this->sortSelection);
    }

    // Fonction qui change le rôle du user, elle s'appele depuis la vue 'livewire.user-page.users-list'
    public function ChangeUserRole($userID, $newRole)
    {
        // Récupère le user et le rôle concerné
        $role = Role::find($newRole);
        $user = User::find($userID);

        // Applique le nouveau rôle au user
        $role->user()->save($user);

        // Lance la fonction qui réarrange l'affichage de la liste des utilisateurs
        Self::ChangeSort($this->sortType, $this->sortSelection);
        
        // Envoie une notification de succé
        session()->flash('success', $user->name.' est devenu '.$role->name.' avec succé !');
    }

    // Fonction interne qui permet de calculer depuis combien de temps un utilisateur à été créé en Années / Mois / Jours
    protected function CountUptime($user)
    {
            // Récupération du temps écoulé en jours, mois, années depuis la création du compte
            $accountUptimeDay = $user->created_at->diffInDays(Carbon::now()) % 365 % 30;
            $accountUptimeMonth = $user->created_at->diffInMonths(Carbon::now()) % 12;
            $accountUptimeYear = $user->created_at->diffInYears(Carbon::now());
    
    
    
            // Création du string '3 ans, 4 mois et 87 jours'
            $str = '';

            // Si on a plus d'un an d'ancienneté, l'écris en pluriel, si on est là depuis moins d'un an, n'ajoute rien au string
            if($accountUptimeYear > 0) {
                if($accountUptimeYear > 1) {
                    $str .= $accountUptimeYear.' ans ';
                }
                else {
                    $str .= $accountUptimeYear.' an ';
                }
            }
    
            // Si on a plus d'un mois d'ancienneté, en ajoute le nombre au string
            if($accountUptimeMonth > 0) {
                $str .= $accountUptimeMonth.' mois ';
            }
    
            // Si on a plus d'un jour d'ancienneté, en ajoute le nombre au string
            // Si on a moins d'un jour, le dit, si on a moins d'un jour mais + d'un mois ou année, change la phrase
            if($accountUptimeDay > 0) {
                $str .= $accountUptimeDay.' jours';
            }
            else if($accountUptimeYear > 0 || $accountUptimeMonth > 0){
                $str .= ' et moins d\'un jour';
            }
            else{
                $str .= 'Moins d\'un jour';
            }

            // Renvoi le résultat
            return $str;
    }

    // Affiche la vue
    public function render()
    {
        return view('livewire.user-page.users-list');
    }
}
