<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;
use Illuminate\Support\Facades\Auth;

class JobtypeController extends Controller
{

    public function index()
    {
        $data = JobType::with(['jobManagers' => function ($query) {
                $query->select('jobmanagers.id', 'jobmanagers.job_type_id')->where('jobmanagers.status', 'Active');
            }])->select('job_types.id', 'job_types.job_type')->get();
        

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new JobType();
        $posted_type->job_type = $request->job_type;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = JobType::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_type' => 'required',
        ]);
        $post = JobType::find($id);

        $post->job_type = $request->job_type;
        $post->save();
    }

    public function deactive($id)
    {
        $post = JobType::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = JobType::find($id);
        $post->status = "1";

        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = JobType::find($id);
        $posted_type->delete();
    }
}
