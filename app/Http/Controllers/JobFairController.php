<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobfair;
use Illuminate\Support\Facades\Auth;

class JobFairController extends Controller
{

    public function index()
    {
        $data = Jobfair::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new Jobfair();
        $posted_type->events_name = $request->events_name;
        $posted_type->event_start_date = $request->event_start_date;
        $posted_type->event_end_date = $request->event_end_date;
        $posted_type->event_no_of_company = $request->event_no_of_company;
        $posted_type->event_companies_name = $request->event_companies_name;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = Jobfair::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $posted_type = Jobfair::find($id);
        $posted_type->events_name = $request->events_name;
        $posted_type->event_start_date = $request->event_start_date;
        $posted_type->event_end_date = $request->event_end_date;
        $posted_type->event_no_of_company = $request->event_no_of_company;
        $posted_type->event_companies_name = $request->event_companies_name;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function deactive($id)
    {
        $post = Jobfair::find($id);
        $post->status = "0";
        $post->save();
    }

    public function active($id)
    {
        $post = Jobfair::find($id);
        $post->status = "1";
        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = Jobfair::find($id);
        $posted_type->delete();
    }
}
