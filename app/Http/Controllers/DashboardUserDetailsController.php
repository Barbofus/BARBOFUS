<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardUserDetailsController extends Controller
{
    //

    public function index()
    {
        return view('user_page.dashboardUserDetails');
    }
}
