<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    //

    public function index()
    {
        return view('user_page.user-dashboard');
    }
}
