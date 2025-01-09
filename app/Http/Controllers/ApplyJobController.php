<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyJob;
use App\Models\Jobmanager;
use App\Models\Admin;
use App\Models\JobResume;
use App\Models\Empcompaniesdetail;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\ApplyJobMail;
use App\Events\JobApplied;
use stdclass;
use Illuminate\Validation\Rules\File;

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
        DB::beginTransaction();
        try {
                $this->validate($request, [
                'resume' => ['required', File::types(['pdf', 'doc', 'docx'])->max('3mb')]
            ]);
        $file = $request->file('resume');
        $orignal_file_name = $file->getClientOriginalName();
        $filename = time() . '.' . $file->extension();
        $path = public_path() . '/resume/';

        if (Auth::guard('jobseeker')->check()){
            $jobseeker_name = Auth::guard('jobseeker')->user()->fname." ".Auth::guard('jobseeker')->user()->lname;
            $jobseeker_email = Auth::guard('jobseeker')->user()->email;
            $employer = Jobmanager::select('userid', 'title', 'company_id')->where('id', $id)->first();
            $company = Empcompaniesdetail::where('id', $employer->company_id)->value('company_name');
            // If user has completed his profile.
            // if (Auth::guard('jobseeker')->user()->savestage == 6){
                $userid = Auth::guard('jobseeker')->user()->id;
                $application_id = "NKR/" . $userid . "/" . $id;
              $applyjob = ApplyJob::create([
                'jsuser_id' => $userid,
                'job_id' => $id,
                'application_id' => $application_id,
                'username' => Auth::guard('jobseeker')->user()->email
                ]);
                
               if ($applyjob->id) {
                    $file->move($path, $filename);
                    JobResume::create([
                        'job_id' => $id,
                        'jobseeker_id' => $userid,
                        'resume' => $filename,
                        'filename' => $orignal_file_name
                    ]);
               }
                // call the event
                $data = new stdclass();
                $data->jobseeker_id = $userid;
                $data->job_id = $id;
                $data->employer_id = $employer->userid;
                event(new JobApplied($data));
                
                // Mail sent to jobseeker.
                  $mailData = [
                    'name' => $jobseeker_name,
                    'job_title' => $employer->title,
                    'company' => $company 
                    ];
                Mail::to($jobseeker_email)->send(new ApplyJobMail($mailData));

                DB::commit();
                return response()->json(['success' => true , 'message' => 'Job successfully applied']);
                // return redirect()->back()->with(['success' => true , 'message' => 'Job successfully applied']);
            // }
            // return redirect()->back()->with(['error' => true, 'message' => 'Please complete your profile first']);

        }
        else {
            DB::rollBack();
            return redirect()->route('login', ['job' => $id])->with(['error' => 'You must be logged in to apply for a job']);
        }
        }
        catch(Throwable $th){
            DB::rollBack();
            return response()->json(['error' => true , 'message' => 'Server Error.']);        
        }
    }
}
