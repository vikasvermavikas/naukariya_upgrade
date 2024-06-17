<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{

    public function index()
    {
        $uid = Session::get('user')['id'];
        $userType = Session::get('user')['user_type'];
        $data = DB::table('package_subscriptions')
            ->leftjoin('packagemanagers', 'packagemanagers.id', '=', 'package_subscriptions.package_id')
            ->select('package_subscriptions.*', 'packagemanagers.*')
            ->where('package_subscriptions.user_id', $uid)
            ->where('package_subscriptions.user_type', $userType)
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function bydate($from, $to)
    {
        $from_time = "00:00:01";
        $to_time = "23:59:59";

        $from_date = $from . " " . $from_time;
        $to_date = $to . " " . $to_time;
        $uid = Session::get('user')['id'];
        $data = DB::table('apply_jobs')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
            ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
            ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
            ->select('jobmanagers.*', 'jobseekers.fname', 'jobseekers.designation', 'jobseekers.preferred_location', 'jobseekers.gender', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.exp_year', 'jobseekers.expected_salary', 'functional_roles.subcategory_name', 'industries.category_name', 'js_resumes.resume', 'jobseekers.notice_period', 'apply_jobs.created_at as cdt')
            ->where('jobmanagers.userid', $uid)
            ->whereBetween('apply_jobs.created_at', [$from_date, $to_date])
            ->get();

        return response()->json(['data' => $data], 200);
    }


    public function SubscriberPackageInfo($id)
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('package_subscriptions')
            ->leftjoin('packagemanagers', 'packagemanagers.id', '=', 'package_subscriptions.package_id')
            ->select('package_subscriptions.id as package_subs_id', 'package_subscriptions.package_id', 'package_subscriptions.user_id', 'package_subscriptions.user_type', 'package_subscriptions.payment_status', 'package_subscriptions.package_status', 'package_subscriptions.created_at', 'package_subscriptions.payment_mode', 'package_subscriptions.payment_date', 'packagemanagers.*')
            ->where('package_subscriptions.user_id', $uid)
            ->where('package_subscriptions.package_id', $id)
            ->first();

        return response()->json(['data' => $data], 200);
    }

    public function AllPackageInfo()
    {

        $data = DB::table('packagemanagers')
            ->select('*')
            ->where('package_for', 'Consultant')
            ->get();

        return response()->json(['data' => $data], 200);
    }
}
