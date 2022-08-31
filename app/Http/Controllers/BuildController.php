<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Build;
use App\Models\Element;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBuildRequest;
use App\Http\Requests\UpdateBuildRequest;

class BuildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('builds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('admin-access')) {  
            $races = Race::all();
            $elements = Element::all();
 
            return view('builds.create', ['races' => $races, 'elements' => $elements]);
        }
        
        abort(403, 'Autorisation requise');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreBuildRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuildRequest $request)
    {
        if(Gate::allows('admin-access')) {
            $imageName = $request->image_path->store('images/builds');

            //dd($request);

            $build = Build::create([
                'title' => $request->title,
                'build_link' => $request->build_link,
                'ap_nbr' => $request->ap_nbr,
                'mp_nbr' => $request->mp_nbr,
                'image_path' => $imageName,
                'race_id' => $request->race_id,
            ]);

            $elements = $request->element_id;

            //dd($elements);
            
            $build->Element()->sync($elements);
    
            return redirect()   ->route('userpage.index')
                                ->with('success', 'Le build ' . $build->title . ' a bien été créé')
                                ->with('selection', 'userPageBuilds');
        }
        
        abort(403, 'Autorisation requise');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::allows('admin-access')) {
            
            $build = Build::where('id', $id)->first();
            $races = Race::all();
            $elements = Element::all();

            return view('builds.edit', [
                'build' => $build,
                'races' => $races,
                'elements' => $elements
            ]);
        }
        
        abort(403, 'Autorisation requise');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateBuildRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBuildRequest $request, $id)
    {
        if(Gate::allows('admin-access')) {

            $build = Build::where('id', $id)->first();

            $elements = $request->element_id;

            //dd($elements);
            
      

            
            $arrayUpdate = [
                'title' => $request->title,
                'build_link' => $request->build_link,
                'ap_nbr' => $request->ap_nbr,
                'mp_nbr' => $request->mp_nbr,
                'race_id' => $request->race_id,
            ];

            if($request->image_path != null) {
                $imageName = $request->image_path->store('images/builds');

                $arrayUpdate = array_merge($arrayUpdate, [
                    'image_path' => $imageName
                ]);

                Storage::delete($build->image_path);
            }

            
            $build->Element()->sync($elements);

            $build->update($arrayUpdate);

    
            return redirect()   ->route('userpage.index')
                                ->with('success', 'Le build ' . $build->title . ' a bien été modifié')
                                ->with('selection', 'userPageBuilds');
        }
        
        abort(403, 'Autorisation requise');
    }
}
