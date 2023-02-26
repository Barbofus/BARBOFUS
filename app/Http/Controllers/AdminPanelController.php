<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    //

    public function index()
    {
        return view('user_page.adminPanel');
    }
}
