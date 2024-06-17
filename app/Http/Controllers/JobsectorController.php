<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobSector;
use Illuminate\Support\Facades\Auth;

class JobsectorController extends Controller
{

    public function index()
    {
        $data = JobSector::all();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new JobSector();
        $posted_type->job_sector = $request->job_sector;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = JobSector::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_sector' => 'required',
        ]);
        $post = JobSector::find($id);

        $post->job_sector = $request->job_sector;
        $post->save();
    }

    public function deactive($id)
    {
        $post = JobSector::find($id);
        $post->status = "0";
        $post->save();
    }

    public function active($id)
    {
        $post = JobSector::find($id);
        $post->status = "1";
        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = JobSector::find($id);
        $posted_type->delete();
    }
}
