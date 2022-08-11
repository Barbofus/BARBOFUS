<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    //

    public function index() 
    {
        return view('user_page.index');
    }
}
