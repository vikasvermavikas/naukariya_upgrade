<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPostAs;
use Auth;
use DB;

class JobpostedtypeController extends Controller
{

    public function index()
    {
        $data=JobPostAs::all();
        return response()->json(['data'=>$data],200);
    }

    public function store(Request $request)
    {
        $posted_type = New JobPostAs();
        $posted_type->job_post_as=$request->jobposted_category;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = JobPostAs::find($id);
        return response()->json(['data'=>$data],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'job_post_as' => 'required',
        ]);

        $post = JobPostAs::find($id);

        $post->job_post_as=$request->job_post_as;
        $post->save();
    }
    
    public function deactive($id)
    {
        $post = JobPostAs::find($id);
        $post->status = "0";
       
        $post->save();
    }
    public function active($id)
    {
        $post = JobPostAs::find($id);
        $post->status = "1";
       
        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = JobPostAs::find($id);
        $posted_type->delete();
    }
}
