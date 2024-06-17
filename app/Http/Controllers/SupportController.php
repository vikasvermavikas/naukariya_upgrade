<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{

    public function index() {
        $userid = Session::get('user')['id'];
        $get_user = Session::get('user')['user_type'];
        $data = DB::table('supports')
            ->orderBy('created_at','DESC')
            ->where('support_userid', $userid)
            ->where('support_usertype', $get_user)
            ->get();
        return response()->json(['data'=>$data],200);
    }

    public function index_all() {
        $data= DB::table('supports') //current table
            ->orderBy('id','desc')
            ->get();
        return response()->json(['data'=>$data],200);
    }

    public function view($id) {
        $data= DB::table('supports') //current table
            ->where('id', $id)
            ->first();
        return response()->json(['data'=>$data],200);
    }

    public function store_employer(Request $request) {
        $userid = Session::get('user')['id'];
        $fname = Session::get('user')['fname'];
        $lname = Session::get('user')['lname'];
        $email = Session::get('user')['email'];
        $get_user = Session::get('user')['user_type'];
        $string = substr($get_user,0,3);
        $dt = time();
        $support_id = "SUP/".$string."/".$userid."/".$dt;
        $support = new Support();
        $support->support_id = $support_id;
        $support->support_fname = $fname;
        $support->support_lname = $lname;
        $support->support_email = $email;
        $support->support_comment = $request->support_comment;
        $support->support_subject = $request->support_subject;
        $support->support_open_date = Carbon::now();
        $support->support_userid = $userid;
        $support->support_usertype = $get_user;
        $support->save();
    }

    public function store_jobseeker(Request $request) {
        $userid=Session::get('user')['id'];
        $fname = Session::get('user')['fname'];
        $lname = Session::get('user')['lname'];
        $email = Session::get('user')['email'];
        $get_user = Session::get('user')['user_type'];
        $string = substr($get_user,0,3);
        $dt = time();
        $support_id = "SUP/".$string."/".$userid."/".$dt;
        $support = new Support();
        $support->support_id = $support_id;
        $support->support_fname = $fname;
        $support->support_lname = $lname;
        $support->support_email = $email;
        $support->support_comment = $request->support_comment;
        $support->support_subject = $request->support_subject;
        $support->support_open_date = Carbon::now();
        $support->support_userid = $userid;
        $support->support_usertype = $get_user;
        $helpdeskStore = $support->save();

        if ($helpdeskStore) {
            return response()->json(['data' => 'Helpdesk send successfully'], 200);
        }

        return response()->json(['data' => 'Something went wrong.'], 201);
    }

}
