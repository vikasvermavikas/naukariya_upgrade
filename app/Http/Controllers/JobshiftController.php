<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobShift;
use Auth;
use DB;

class JobshiftController extends Controller
{

    public function index()
    {
        $data = JobShift::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new JobShift();
        $posted_type->job_shift = $request->job_shift;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = JobShift::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_shift' => 'required',
        ]);
        $post = JobShift::find($id);

        $post->job_shift = $request->job_shift;
        $post->save();
    }

    public function deactive($id)
    {
        $post = JobShift::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = JobShift::find($id);
        $post->status = "1";

        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = JobShift::find($id);
        $posted_type->delete();
    }
}
