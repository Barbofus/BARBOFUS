<?php

namespace App\Http\Controllers;

use App\Http\Middleware\HavenBagsOwnerShip;
use App\Models\HavenBag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HavenBagController extends Controller
{

    public function __construct()
    {
        $this->middleware(HavenBagsOwnerShip::class)->only(['edit', 'update', 'destroy']);
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('haven-bags.index');
    }

    public function edit(HavenBag $havenBag)
    {

    }
}
