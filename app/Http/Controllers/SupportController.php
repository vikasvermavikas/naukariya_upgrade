<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public $userid;
    public $companyid;
    public $usertype;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
     
            if (Auth::guard('employer')->check() ){

                $this->userid = Auth::guard('employer')->user()->id;
                $this->usertype = Auth::guard('employer')->user()->user_type;
            }
            if (Auth::guard('jobseeker')->check() ){
    
                $this->userid = Auth::guard('jobseeker')->user()->id;
                $this->usertype = Auth::guard('jobseeker')->user()->user_type;
            }

            return $next($request);
        });
    }

    public function index()
    {
     
        $userid = $this->userid;
        $get_user = $this->usertype;
        $data = DB::table('supports')
            ->orderBy('created_at', 'DESC')
            ->where('support_userid', $userid)
            ->where('support_usertype', $get_user)
            ->get();
        // return response()->json(['data'=>$data],200);
        return view('employer.support', compact('data'));
    }

    public function index_all()
    {
        $data = DB::table('supports') //current table
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function view($id)
    {
        $data = DB::table('supports') //current table
            ->where('id', $id)
            ->first();
        return response()->json(['data' => $data], 200);
    }

    public function store_employer(Request $request)
    {
        $request->validate([
            'support_subject' => 'required|size:20',
            'support_comment' => 'required|size:100',
        ]);

        // $userid = Session::get('user')['id'];
        // $fname = Session::get('user')['fname'];
        // $lname = Session::get('user')['lname'];
        // $email = Session::get('user')['email'];
        // $get_user = Session::get('user')['user_type'];
        
        $userid = Auth::guard('employer')->user()->id;
        $fname = Auth::guard('employer')->user()->fname;
        $lname = Auth::guard('employer')->user()->lname;
        $email = Auth::guard('employer')->user()->email;
        $get_user = Auth::guard('employer')->user()->user_type;
        $string = substr($get_user, 0, 3);
        $dt = time();
        $support_id = "SUP/" . $string . "/" . $userid . "/" . $dt;
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

        return redirect()->route('employer_support_list')->with(['message' => 'Message sent successfully']);
    }

    public function store_jobseeker(Request $request)
    {
        $userid = Auth::guard('jobseeker')->user()->id;
        $fname = Auth::guard('jobseeker')->user()->fname;
        $lname = Auth::guard('jobseeker')->user()->lname;
        $email = Auth::guard('jobseeker')->user()->email;
        $get_user = Auth::guard('jobseeker')->user()->user_type;
        $string = substr($get_user, 0, 3);
        $dt = time();
        $support_id = "SUP/" . $string . "/" . $userid . "/" . $dt;
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
            // return response()->json(['data' => 'Helpdesk send successfully'], 200);
        return redirect()->route('jobseeker_support_list')->with(['success' => true, 'message' => 'Message sent successfully']);

        }

        // return response()->json(['data' => 'Something went wrong.'], 201);
        return redirect()->route('jobseeker_support_list')->with(['error' => true, 'errormessage' => 'Message sent successfully']);

    }
}
