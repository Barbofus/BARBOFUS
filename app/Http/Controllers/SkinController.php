<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Skin;
use App\Http\Middleware\SkinsOwnerShip;
use App\Http\Requests\StoreUpdateSkinRequest;

class SkinController extends Controller
{

    public function __construct()
    {
        $this->middleware(SkinsOwnerShip::class)->only(['edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('skins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $races = Race::all();

        return view('skins.create', [
            'races' => $races,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSkinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateSkinRequest $request)
    {
        dd($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function edit(Skin $skin)
    {


        return view('skins.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSkinRequest  $request
     * @param  \App\Models\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateSkinRequest $request, Skin $skin)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skin $skin)
    {
        //
    }
}
