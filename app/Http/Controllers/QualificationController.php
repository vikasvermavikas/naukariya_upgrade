<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;
use Auth;
use DB;

class QualificationController extends Controller
{

    public function getQualificationByGroup()
    {
        $data = DB::table('qualifications')
        ->select('group')
        ->distinct('group')
        ->get();
        

       $qual = $data->map(function ($data){
        $edu = DB::table('qualifications')
        ->select('qualifications.id', 'qualifications.qualification','qualifications.group')
        ->where('qualifications.group', $data->group)->get();

        $educations = ['qualification' => $edu];

        $collection = collect($data)->merge($educations);

        return $collection;
       });
        

        return response()->json(['data' => $qual], 200);
    }
    public function index()
    {
        $data = Qualification::with(['jobmanagers' => function ($query) {
            $query->select('jobmanagers.id', 'jobmanagers.job_qualification_id')->where('jobmanagers.status', 'Active');
        }])->select('qualifications.id', 'qualifications.qualification','qualifications.group')->get();

        return response()->json(['data' => $data], 200);
    }

    public function browsejob()
    {
        $data = Qualification::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new Qualification();
        $posted_type->qualification = $request->qualification;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = Qualification::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qualification' => 'required',
        ]);
        $post = Qualification::find($id);

        $post->qualification = $request->qualification;
        $post->save();
    }

    public function deactive($id)
    {
        $post = Qualification::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = Qualification::find($id);
        $post->status = "1";

        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = Qualification::find($id);
        $posted_type->delete();
    }
}
