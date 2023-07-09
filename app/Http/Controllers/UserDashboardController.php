<?php

namespace App\Http\Controllers;

class UserDashboardController extends Controller
{
    //

    public function index()
    {
        return view('user_page.user-dashboard-view');
    }
}
