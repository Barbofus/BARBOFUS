<?php

namespace App\Http\Controllers;

use App\Actions\Images\ResizeImages;
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
     * @param  \App\Http\Requests\StoreUpdateSkinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateSkinRequest $request)
    {

        // Resize de l'image, on affichera que 200px max
        $imagePath = (new ResizeImages)($request->image_path, 'images/skins', [
            'width' => 200,
            'height' => null ]);

        Skin::create([
            'dofus_item_hat_id' => $request->dofus_item_hat_id,
            'dofus_item_cloak_id' => $request->dofus_item_cloak_id,
            'dofus_item_shield_id' => $request->dofus_item_shield_id,
            'dofus_item_pet_id' => $request->dofus_item_pet_id,
            'dofus_item_costume_id' => $request->dofus_item_costume_id,
            'face' => $request->face,
            'image_path' => $imagePath,
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
        $races = Race::all();

        return view('skins.edit', [
            'races' => $races,
            'skin' => $skin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateSkinRequest  $request
     * @param  \App\Models\Skin  $skin
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateSkinRequest $request, Skin $skin)
    {
        $imagePath = $skin->image_path;

        // Si on change l'image, supprime l'ancienne et s'occupe de la nouvelle
        if($request->image_path) {
            \Storage::delete($skin->image_path);

            // Resize de l'image, on affichera que 200px max
            $imagePath = (new ResizeImages)($request->image_path, 'images/skins', [
                'width' => 200,
                'height' => null ]);
        }

        $skin->update([
            'dofus_item_hat_id' => $request->dofus_item_hat_id,
            'dofus_item_cloak_id' => $request->dofus_item_cloak_id,
            'dofus_item_shield_id' => $request->dofus_item_shield_id,
            'dofus_item_pet_id' => $request->dofus_item_pet_id,
            'dofus_item_costume_id' => $request->dofus_item_costume_id,
            'face' => $request->face,
            'image_path' => $imagePath,
            'gender' => $request->gender,
            'color_skin' => $request->color_skin,
            'color_hair' => $request->color_hair,
            'color_cloth_1' => $request->color_cloth_1,
            'color_cloth_2' => $request->color_cloth_2,
            'color_cloth_3' => $request->color_cloth_3,
            'race_id' => $request->race_id,
        ]);

        return view('skins.index');
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
