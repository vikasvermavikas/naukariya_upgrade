<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobwalking;
use Illuminate\Support\Facades\Auth;

class JobwalkinsController extends Controller
{
    public function index()
    {
        $data = Jobwalking::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new Jobwalking();
        $posted_type->walking_name = $request->walking_name;
        $posted_type->start_date = $request->start_date;
        $posted_type->end_date = $request->end_date;
        $posted_type->time_from = $request->time_from;
        $posted_type->time_to = $request->time_to;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = Jobwalking::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $posted_type = Jobwalking::find($id);
        $posted_type->walking_name = $request->walking_name;
        $posted_type->start_date = $request->start_date;
        $posted_type->end_date = $request->end_date;
        $posted_type->time_from = $request->time_from;
        $posted_type->time_to = $request->time_to;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function deactive($id)
    {
        $post = Jobwalking::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = Jobwalking::find($id);
        $post->status = "1";

        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = Jobwalking::find($id);
        $posted_type->delete();
    }
}
