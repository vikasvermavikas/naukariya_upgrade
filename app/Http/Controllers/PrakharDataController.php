<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobSector;
use App\Mail\InterviewScheduled;
use Carbon\Carbon;
use App\Models\Jobmanager;
use App\Models\ApplyJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\Activejobmanager;
use App\Mail\Deactivejobmanager;
use App\Mail\Updatejobmanager;
use App\Models\Notification;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Redirect;

class PrakharDataController extends Controller
{
    //getJobsbySector of PSSPL Only
    public function getJobsBySectorPsspl(){
        $prakhar_company_id =1;

        $callback = function ($query) {
            $query->select('id', 'title', 'job_sector_id', 'status', 'company_id')
            ->where('jobmanagers.company_id','=', '1')->where('status', 'Active');
        };

        $jobs = JobSector::whereHas('jobmanagers', $callback)
            ->with(['jobmanagers' => $callback])
            ->select('id', 'job_sector')->get();

        return response()->json($jobs, 200);
        
    }
    public function getJobsByCategory(Request $request)
    {
        $id = $request->sector_id;

        $jobs = DB::table('jobmanagers')
            ->leftjoin('empcompaniesdetails', 'jobmanagers.company_id', 'empcompaniesdetails.id')
            ->leftjoin('job_sectors', 'job_sectors.id', 'jobmanagers.job_sector_id')
            ->select('jobmanagers.id', 'jobmanagers.job_sector_id', 'jobmanagers.last_apply_date', 'jobmanagers.location', 'jobmanagers.job_exp', 'jobmanagers.title', 'jobmanagers.main_exp', 'jobmanagers.max_exp', 'jobmanagers.description','empcompaniesdetails.company_name')
            ->where('jobmanagers.job_sector_id', $id)
            ->where('jobmanagers.job_for', '!=', 'Consultant')
            ->where('job_sectors.status', '1')
            ->where('jobmanagers.status', 'Active')
            ->where('jobmanagers.company_id','=', '1')
            ->orderBy('jobmanagers.created_at', 'DESC')
            ->get();


        return response()->json($jobs, 200);
    }
    // public function index()
    // {
    //     $prakhar_company_id =1;
    //     $prakhar_company_name ='Prakhar Softwares Solutions PVt.Ltd';

    //     $data = DB::table('jobmanagers')
    //     ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
    //     ->select('jobmanagers.*','empcompaniesdetails.company_name')
    //     ->where('jobmanagers.company_id',$prakhar_company_id)
    //     ->where('empcompaniesdetails.company_name',$prakhar_company_name)
    //     ->where('jobmanagers.status','Active')
    //     ->get();
    //     // $data = Jobmanager::all();
    //      return response()->json(['data' => $data], 200);
    // }
    
}
