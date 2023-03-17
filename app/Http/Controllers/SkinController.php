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
        $imageName = $request->image_path->store('images/skins');

        Skin::create([
            'dofus_item_hat_id' => $request->dofus_item_hat_id,
            'dofus_item_cloak_id' => $request->dofus_item_cloak_id,
            'dofus_item_shield_id' => $request->dofus_item_shield_id,
            'dofus_item_pet_id' => $request->dofus_item_pet_id,
            'dofus_item_costume_id' => $request->dofus_item_costume_id,
            'face' => $request->face,
            'image_path' => $imageName,
            'gender' => $request->gender,
            'color_skin' => $request->color_skin,
            'color_hair' => $request->color_hair,
            'color_cloth_1' => $request->color_cloth_1,
            'color_cloth_2' => $request->color_cloth_2,
            'color_cloth_3' => $request->color_cloth_3,
            'user_id' => $request->user()->id,
            'race_id' => $request->race_id,
        ]);

        return view('skins.index');
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
