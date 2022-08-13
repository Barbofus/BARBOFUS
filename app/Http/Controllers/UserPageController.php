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
        $users = User::all();


            // Récupération du temps écoulé en jours, mois, années depuis la création du compte
        $accountUptimeDay = $currentUser->created_at->diffInDays(Carbon::now()) % 365 % 30;
        $accountUptimeMonth = $currentUser->created_at->diffInMonths(Carbon::now()) % 12;
        $accountUptimeYear = $currentUser->created_at->diffInYears(Carbon::now());



            // Création du string '3 ans, 4 mois et 87 jours'
        $accountUptimeStr = '';

        if($accountUptimeYear > 0) {
            if($accountUptimeYear > 1) {
                $accountUptimeStr .= $accountUptimeYear.' ans ';
            }
            else {
                $accountUptimeStr .= $accountUptimeYear.' an ';
            }
        }

        if($accountUptimeMonth > 0) {
            $accountUptimeStr .= $accountUptimeMonth.' mois ';
        }

        if($accountUptimeDay > 0) {
            $accountUptimeStr .= $accountUptimeDay.' jours';
        }
        else {
            $accountUptimeStr .= ' et moins d\'un jour';
        }

        return view('user_page.index', ['users' => $users, 'currentUser' => $currentUser, 'accountUptime' => $accountUptimeStr]);
    }
}
