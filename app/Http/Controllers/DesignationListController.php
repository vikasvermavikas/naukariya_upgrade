<?php

namespace App\Http\Controllers;

use App\Models\DesignationList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesignationListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industries = DesignationList::pluck('designation')->toArray();

        return $industries;
    }
    
    public function getTrackerDesignation(Request $request)
    {
        $data = DesignationList::select('id', 'designation','employer_id')->whereNotNull('designation')->where('designation','!=','')
        ->orderBy('designation','asc')
        ->get();

        return response()->json(['data' =>$data]);
    }
    // public function test(){

    //     $data = DesignationList::select('id', 'designation','employer_id')->whereNotNull('designation')->where('designation','!=','')
    //     ->orderBy('id','asc')
    //     ->get();
     
    //     foreach($data as $d){
            
    //         // if(strpos($d['designation'], '/')){
    //             // $des = explode("/",$d['designation']);            
    //             // foreach($des as $a){
    //             $a = trim($d['designation']);
    //                 // return response()->json(['data' => $a]);        
    //                 DesignationList::updateOrCreate(['id' => $d['id']], ['designation' => $a ]);
    //             // }
               
    //         // }
            
        
           
    //     };

      
        // return response()->json(['data' => $data]);
        // print_r($data);

    // }
}
