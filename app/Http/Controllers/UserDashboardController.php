<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('user_page.user-dashboard-view');
    }
}
