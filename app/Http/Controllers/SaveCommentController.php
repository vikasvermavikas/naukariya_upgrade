<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaveComment;
use Session;
use DB;

class SaveCommentController extends Controller
{
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
        $emp_id = Session::get('user')['id'];
        $jsid=$request->params['jsid'];
        $comment=$request->params['comment'];

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
}
