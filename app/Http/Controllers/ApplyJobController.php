<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyJob;
use App\Models\Jobmanager;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Events\JobApplied;
use stdclass;

class ApplyJobController extends Controller
{
    public function test(){
        $id = 4;
        $job =DB::table('jobmanagers')
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
        ->leftjoin('all_users', 'all_users.company_id', '=', 'jobmanagers.company_id')
        ->select('empcompaniesdetails.com_email','jobmanagers.title','all_users.fname','all_users.user_type')
        ->where('jobmanagers.id', $id)
        ->first();
        return response()->json($job);
        // $job_title ="Hr Executive";
        // $admin = DB::table('admins')
        // ->select('name','email','job_title')
        // ->where('job_title',$job_title)
        // ->get();
        // return response()->json($admin);
    }

    public function getsingleapplyjob($id)
    {
        $data = DB::table('jobmanagers')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
            ->leftjoin('qualifications', 'qualifications.id', '=', 'jobmanagers.job_qualification_id')
            ->select('jobmanagers.*', 'empcompaniesdetails.company_name', 'qualifications.qualification')
            ->where('jobmanagers.id', $id)
            ->first();

        return response()->json([$data], 200);
    }

    public function applyJobList(Request $request)
    {
        // $uid = Session::get('user')['id'];

         $uid = Auth::guard('jobseeker')->user()->id;

        $data = DB::table('apply_jobs')
            ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
            ->select('apply_jobs.*', 'jobmanagers.title', 'empcompaniesdetails.company_name')
            ->where('jsuser_id', $uid)
            ->orWhere('job_id', 'jobmanagers.id')
            ->orderBy('apply_jobs.created_at', 'DESC')
            ->get();


            return view('jobseeker.applied_jobs',[
                'data' => $data,
            ]);
        // return response()->json(['data' => $data], 200);
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, []);
        if (Auth::guard('jobseeker')->check()){
            $employer = Jobmanager::select('userid')->where('id', $id)->first();
            // If user has completed his profile.
            if (Auth::guard('jobseeker')->user()->savestage == 6){
                $userid = Auth::guard('jobseeker')->user()->id;
                $application_id = "NKR/" . $userid . "/" . $id;
                $applyjob = new ApplyJob();
                $applyjob->jsuser_id = $userid;
                $applyjob->job_id = $id;
                $applyjob->application_id = $application_id;
                $applyjob->username = Auth::guard('jobseeker')->user()->email;
                $applyjob->save();

                // call the event
                $data = new stdclass();
                $data->jobseeker_id = $userid;
                $data->job_id = $id;
                $data->employer_id = $employer->userid;
                event(new JobApplied($data));

                return redirect()->back()->with(['success' => true , 'message' => 'Job successfully applied']);
            }
            return redirect()->back()->with(['error' => true, 'message' => 'Please complete your profile first']);

        }
        else {
            return redirect()->route('login', ['job' => $id])->with(['error' => 'You must be logged in to apply for a job']);
        }

       
    }
}
