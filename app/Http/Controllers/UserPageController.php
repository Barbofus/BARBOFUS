<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPageController extends Controller
{
    //

    public function index() 
    {
        $currentUser = Auth::user();
        $accountUptimeStr = Self::CountUptime($currentUser);

        return view('user_page.index', ['currentUser' => $currentUser, 'accountUptime' => $accountUptimeStr]);
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
                $str .= 'moins d\'un jour';
            }

            return $str;
    }
}
