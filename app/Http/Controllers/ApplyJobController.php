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

    public function applyJobList()
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('apply_jobs')
            ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
            ->select('apply_jobs.*', 'jobmanagers.title', 'empcompaniesdetails.company_name')
            ->where('jsuser_id', $uid)
            ->orWhere('job_id', 'jobmanagers.id')
            ->orderBy('apply_jobs.created_at', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, []);

        $userid = Session::get('user')['id'];
        $application_id = "NKR/" . $userid . "/" . $id;

        $applyjob = new ApplyJob();
        $applyjob->jsuser_id = Session::get('user')['id'];
        $applyjob->job_id = $id;
        $applyjob->application_id = $application_id;
        $applyjob->username = Session::get('user')['email'];
        $applyjob->save();
        //send Mail to recruitmentMail(It can be changed to Employer email that will be job posted by him)
        $job =DB::table('jobmanagers')
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
        ->leftjoin('all_users', 'all_users.company_id', '=', 'jobmanagers.company_id')
        ->select('empcompaniesdetails.com_email','jobmanagers.title','all_users.fname','all_users.user_type')
        ->where('jobmanagers.id', $id)
        ->first();
        
        $rec_email=$job->com_email;
        $rec_name =$job->fname;
        $rec_usertype =$job->user_type;
        $rec_title =$job->title;
        $data = [
            'application_id' => $application_id,
            'jobseeker_email' => Session::get('user')['email'],
            'name' =>$rec_name,
            'usertype' =>$rec_usertype,
            'title' =>$rec_title
        ];

        // Mail::send('SendMail.ApplyJobMailRecruiter', $data, function ($message) use ($rec_email) {
        //     $message->to($rec_email)
        //         ->subject("New Job Apply Request");
        //     //$message->from(env('MAIL_USERNAME'),"Naukriyan.com");
        //     $message->from(env('TEST_USEREMAIL'), "Naukriyan.com");
        // });
        //send mail to jobseeker
        // $data = [
        //     'application_id' => $application_id,
        //     'title' =>$rec_title
        // ];
        // $email=Session::get('user')['email'];
        // Mail::send('SendMail.ApplyJobMailCandidate', $data, function ($message) use ($email) {
        //     $message->to($email)
        //         ->subject("Job Apply");
        //     //$message->from(env('MAIL_USERNAME'),"Naukriyan.com");
        //     $message->from(env('TEST_USEREMAIL'), "Naukriyan.com");
        // });
    }
}
