<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaveComment;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;

class SaveCommentController extends Controller
{
    public $emp_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->emp_id = Auth::guard('employer')->user()->id;
            return $next($request);
        });
    }

    public function index()
    {
        $emp_id = Session::get('user')['id'];
        $getComment = DB::table('save_comments')
            ->where('emp_userid', $emp_id)
            ->get();
        return response()->json(['data' => $getComment], 200);
    }
    public function store(Request $request)
    {

        // $emp_id = Session::get('user')['id'];
        $emp_id = $this->emp_id;
        $jsid = $request->jsid;
        $comment = $request->comment;

        $add = new SaveComment();
        $add->comment = $comment;
        $add->emp_userid = $emp_id;
        $add->js_userid = $jsid;
        $add->save();

        if (!$add) {
            return response()->json(['status' => 'error', 'message' => 'Not Added'], 406);
        }

        return response()->json(['status' => 'success', 'message' => 'Comment Added successfully'], 201);
    }

    public function get_resume_comments(Request $request){
        $js_id = $request->js_id;
        $getComment = DB::table('save_comments')
            ->select('id', 'comment')
            ->where('js_userid', $js_id)
            ->get();
        return response()->json(['data' => $getComment], 200);
    }
}
