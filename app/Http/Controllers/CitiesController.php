<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
{
    public function index(Request $request)
    {
        $state_id = $request->state_id;

        $data = DB::table('cities')
            ->where('state_id', $state_id)
            ->get();

        return response()->json(['data' => $data], 200);
    }
    public function getCityByState($id){
        $data = DB::table('cities')
            ->where('state_id', $id)
            ->get();

        return response()->json(['data' => $data], 200);
    }
    public function getCityByStateName($name){
        $state_id = DB::table('states')
        ->where('states_name', $name)
        ->first()->id;
        $data = DB::table('cities')
            ->where('state_id', $state_id)
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function show($id)
    {
        $data = DB::table('states')
            ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
            ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
            ->select('jobs.adv_id', 'jobs.designation_id', 'designations.id', 'designations.designation')
            ->where('jobs.adv_id', $id)
            ->distinct()
            ->get();

        return response()->json(['data' => $data], 200);
    }
    public function getLocationByGroup(){
        $data = DB::table('master_location')
        ->select('state')
        ->distinct('state')
        ->get();
        

       $qual = $data->map(function ($data){
        $edu = DB::table('master_location')
        ->select('master_location.id','master_location.location')
        ->where('master_location.state', $data->state)->get();

        $educations = ['location' => $edu];

        $collection = collect($data)->merge($educations);

        return $collection;
       });
        

        return response()->json(['data' => $qual], 200);
    }
    public function getLocation()
    {
        $data = DB::table('master_location')
        ->select('state','location')
        ->get();

        $topmetro =DB::table('master_location')
        ->select('state','location','status')
        ->where('state', $data->state='Top Metropolitan Cities')
        ->where('status',1)
        ->get();
        

        return response()->json(['data' => $topmetro], 200);
    }

}
