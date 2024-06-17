<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function createJobPost(Request $request)
    {

        $data = [
            'post_name' => $request->data['job_title'],
            'post_short_desc' => $request->data['short_desc'],
            'post_long_desc' => $request->data['long_desc'],
            'skill_required' => $request->data['skill_required'],
            'min_exp' => $request->data['min_exp'],
            'max_exp' => $request->data['max_exp'],
            'total_opening' => $request->data['total_opening'],
            'current_ctc' => $request->data['ctc'],
            'interview_process' => $request->data['interview_process']
        ];

        $career = Career::create($data);

        if ($career) {
            return response()->json(['data' => 'Data inserted successfully'], 200);
        }

        return response()->json(['data' => 'Something went wrong.'], 201);
    }

    public function getJobLists()
    {
        $data = Career::whereNull('deleted_at')->orderBy('created_at', 'DESC')->get();

        return response()->json(['data' => $data], 200);
    }

    public function editJob($id)
    {
        $data = Career::where('id', $id)->first();
        if ($data) {
            return response()->json(['data' => $data], 200);
        }
        return response()->json(['data' => 'Not found'], 201);
    }

    public function updateJob(Request $request)
    {
        $data = [
            'post_name' => $request->data['job_title'],
            'post_short_desc' => $request->data['short_desc'],
            'post_long_desc' => $request->data['long_desc'],
            'skill_required' => $request->data['skill_required'],
            'min_exp' => $request->data['min_exp'],
            'max_exp' => $request->data['max_exp'],
            'total_opening' => $request->data['total_opening'],
            'current_ctc' => $request->data['ctc'],
            'interview_process' => $request->data['interview_process']
        ];

        $id = $request->data['id'];

        $dataUpdate = Career::where('id', $id)->update($data);

        if ($dataUpdate) {
            return response()->json(['data' => 'Job updated'], 200);
        }
        return response()->json(['data' => 'Job not updated'], 201);
    }

    public function deleteJob($id)
    {
        $deleteId = Career::where('id', $id)->delete();

        if ($deleteId) {
            return response()->json(['data' => 'Job deleted'], 200);
        } else {
            return response()->json(['data' => 'Something went wrong.'], 200);
        }
    }

    public function singleJob($slug)
    {
        return Career::where('slug', $slug)->first();
    }
}
