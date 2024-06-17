<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\States;
use Auth;
use DB;
use Illuminate\Http\Response;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $data=States::where('country_id', '101')->get();
        return response()->json(['data'=>$data],200);
        // $data=States::all();
        // return response()->json(['data'=>$data],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            

        ]);
        $states = New States();
       $states->country_name = $request->country_name;
       $states->states_name = $request->state_name;
       //$states->add_by = Auth::user()->id;
        $states->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = States::find($id);
        return response()->json([
            'data'=>$data
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    { $this->validate($request,[
            
            'states_name'=>'required',
            'country_id'=>'required',
            

        ]);
        $states = States::find($id);
       $states->states_name = $request->state_name;
       $states->country_id = $request->country_name;
       //$states->add_by = Auth::user()->id;
        $states->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
         $states = States::find($id);
        $states->delete();
    }
}
