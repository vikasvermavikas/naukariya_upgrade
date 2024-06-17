<?php

namespace App\Http\Controllers;


use App\Models\SubUser;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubUserDashboardController extends Controller
{
    public function dashboard()
    {
        $subuserId =Session::get('user')['id'];

        $data['totalAdded']= Tracker::where('added_by',$subuserId)->count();

        $data['resumeUploaded']= Tracker::where('added_by',$subuserId)->whereNotNull('resume')->count();

        $data['resumeNotUploaded']= Tracker::where('added_by',$subuserId)->whereNull('resume')->count();

        return response()->json(['data' => $data]);
    }
  
}
