<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packagemanager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackagemanagerController extends Controller
{

    public function index()
    {
        $data = Packagemanager::all();
        return response()->json(['data' => $data], 200);
    }

    public function getpackagejobseeker()
    {
        $package_type = "Jobseeker";
        $data = DB::table('packagemanagers') //current table
        ->orderBy('id', 'desc')
            ->where('package_for', $package_type)
            ->Where('package_status', 'Yes')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function getpackageemployer()

    {
        $package_type = "Employer";
        //$active="Yes";
        $data = DB::table('packagemanagers') //current table
        ->orderBy('id', 'desc')
            ->where('package_for', $package_type)
            ->Where('package_status', 'Yes')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'package_name' => 'required',
            'package_price' => 'required',
        ]);

        $package = new Packagemanager();

        $package->package_name = $request->package_name;
        $package->package_description = $request->package_description;
        $package->package_price = $request->package_price;
        $package->package_total_jobs = $request->package_total_jobs;
        $package->package_total_resume_downloads = $request->package_total_resume_downloads;
        $package->package_total_excel_export = $request->package_total_excel_export;
        $package->package_total_resume_views = $request->package_total_resume_views;
        $package->package_total_resume_forward = $request->package_total_resume_forward;
        $package->package_total_resume_search = $request->package_total_resume_search;
        $package->package_total_email = $request->package_total_email;
        $package->package_total_sms = $request->package_total_sms;
        $package->validity = $request->validity;
        $package->package_recruitment_service = $request->package_recruitment_service;
        $package->package_for = $request->package_for;
        $package->basic_job = $request->basic_job;
        $package->hot_job = $request->hot_job;
        $package->premium_job = $request->premium_job;
        $package->package_service = $request->package_service;
        $package->service_name = $request->service_name;
        $package->service_description = $request->service_description;

        $package->add_by = Auth::user()->id;
        $package->save();
    }

    public function show($id)
    {
        $data = Packagemanager::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function edit($id)
    {
        $data = Packagemanager::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'package_name' => 'required',
            'package_price' => 'required',
        ]);
        $package = Packagemanager::find($id);

        $package->package_name = $request->package_name;
        $package->package_description = $request->package_description;
        $package->package_price = $request->package_price;
        $package->package_total_jobs = $request->package_total_jobs;
        $package->package_total_resume_downloads = $request->package_total_resume_downloads;
        $package->package_total_excel_export = $request->package_total_excel_export;
        $package->package_total_resume_views = $request->package_total_resume_views;
        $package->package_total_resume_forward = $request->package_total_resume_forward;
        $package->package_total_resume_search = $request->package_total_resume_search;
        $package->package_total_email = $request->package_total_email;
        $package->package_total_sms = $request->package_total_sms;
        $package->validity = $request->validity;
        $package->package_recruitment_service = $request->package_recruitment_service;
        $package->package_for = $request->package_for;
        $package->basic_job = $request->basic_job;
        $package->hot_job = $request->hot_job;
        $package->premium_job = $request->premium_job;
        $package->package_service = $request->package_service;
        $package->service_name = $request->service_name;
        $package->service_description = $request->service_description;

        $package->add_by = Auth::user()->id;
        $package->save();
    }

    public function deactive($id)
    {
        $package = Packagemanager::find($id);
        $package->package_status = "No";
        $package->save();
    }

    public function active($id)
    {
        $package = Packagemanager::find($id);
        $package->package_status = "Yes";
        $package->save();
    }

    public function destroy($id)
    {
        $package = Packagemanager::find($id);
        $package->delete();
    }
}
