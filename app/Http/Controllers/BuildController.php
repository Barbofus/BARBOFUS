<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuildRequest;
use App\Models\Build;
use App\Models\Element;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
            
            foreach($elements as $element) {
                $build->Element()->attach($element);
            }
    
            return redirect()->route('builds.index');
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
            //return view('builds.create');
        }
        
        abort(403, 'Autorisation requise');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::allows('admin-access')) {
            //return view('builds.create');
        }
        
        abort(403, 'Autorisation requise');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('admin-access')) {
            //return view('builds.create');
        }
        
        abort(403, 'Autorisation requise');
    }
}
