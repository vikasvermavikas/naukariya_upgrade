<?php

namespace App\Http\Controllers;


use App\Models\SubUser;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SubUserDashboardController extends Controller
{
    public function dashboard()
    {
        // $subuserId =Session::get('user')['id'];
        $subuserId = Auth::guard('subuser')->user()->id;

        $data['totalAdded']= Tracker::where('added_by',$subuserId)->count();

        $data['resumeUploaded']= Tracker::where('added_by',$subuserId)->whereNotNull('resume')->count();

        $data['resumeNotUploaded']= Tracker::where('added_by',$subuserId)->whereNull('resume')->count();

        return view('sub_user.dashboard', ['data' => $data]);
    }

    public function logout(Request $request) {
        Auth::guard('subuser')->logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        Session::flush();

       return redirect()->route('home');
    }
  
}
