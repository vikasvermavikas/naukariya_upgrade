<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\AddIndustry;
use App\Mail\UpdateIndustry;
use Illuminate\Support\Facades\Mail;

class IndustryController extends Controller
{
    public function index()
    {
        $data = Industry::with(['jobmanagers' => function ($query) {
            $query->select('jobmanagers.id', 'jobmanagers.job_industry_id')->where('jobmanagers.status', 'Active');
        }])->select('industries.id', 'industries.category_name')->orderBy('industries.category_name', 'ASC')->get();

        return response()->json(['data' => $data], 200);
    }

    public function indexdemo()
    {
        $data = DB::table('industries')
        ->select('industries.*')
        ->get();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, []);

        $industry = new Industry();
        $industry->category_name = $request->industry_name;
        $industry->add_by = Auth::user()->id;
        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;
        $industry_name = $request->industry_name;

        if ($to != "") {
            Mail::to($to)->send(new AddIndustry($name, $mobile, $job_title, $industry_name));
        }
        $industry->save();
    }

    public function edit($id)
    {
        $data = Industry::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        $industry = Industry::find($id);
        $industry->category_name = $request->category_name;
        $industry->update_by = Auth::user()->id;
        $data = DB::table('industries')
            ->select('id', 'category_name')
            ->where('id', $id)
            ->first();
        $myArray = json_decode(json_encode($data), true);
        $old_industryname = $myArray['category_name'];

        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;
        $industry_name = $request->category_name;

        if ($to != "") {
            Mail::to($to)->send(new UpdateIndustry($name, $mobile, $job_title, $industry_name, $old_industryname));
        }
        $industry->save();
    }

    public function destroy($id)
    {
        $industry = Industry::find($id);
        $industry->delete();
    }

    public function getIndustries()
    {
        $industries = Industry::select('id', 'category_name')->orderby('category_name', 'ASC')->get();
        return response()->json($industries);
    }
}
