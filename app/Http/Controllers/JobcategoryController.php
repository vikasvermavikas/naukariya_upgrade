<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Auth;


class JobcategoryController extends Controller
{

    public function index()
    {
        $data = JobCategory::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new JobCategory();
        $posted_type->job_category = $request->job_category;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = JobCategory::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_category' => 'required',
        ]);

        $post = JobCategory::find($id);
        $post->job_category = $request->job_category;
        $post->save();
    }

    public function deactive($id)
    {
        $post = JobCategory::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = JobCategory::find($id);
        $post->status = "1";
        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = JobCategory::find($id);
        $posted_type->delete();
    }
}
