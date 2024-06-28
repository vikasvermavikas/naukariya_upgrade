<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\ApplyJob;
use App\Models\Follower;
use App\Models\Jobmanager;
use App\Models\Empcompaniesdetail;
use App\Models\Tracker;
use App\Models\ClientName;
use App\Models\SubUser;
use App\Models\Jobseeker;
use App\Models\MyInbox;
use App\Models\PackageSubscription;
use App\Models\SavedJob;
use App\Models\Support;
use App\Models\ConsolidateData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function countAllDataForJobEmployer()
    {
        $loggedUserId = Session::get('user')['id'];
        $loggedUserType = Session::get('user')['user_type'];
        $loggedCompanyId = Session::get('user')['company_id'];

        $data['job_posted_by_me'] = Jobmanager::where('userid', $loggedUserId)->count();

        $data['active_jobs'] = Jobmanager::where('userid', $loggedUserId)
            ->where('status', 'Active')
            ->count();

        $data['followers'] = Follower::where('employer_id', $loggedCompanyId)
            ->where('status', '1')
            ->count();

        $data['package_subscription'] = PackageSubscription::where('user_id', $loggedUserId)
            ->where('user_type', $loggedUserType)
            ->count();

        $data['reports'] = PackageSubscription::where('user_id', $loggedUserId)
            ->where('user_type', $loggedUserType)
            ->count();

        $data['helpdesk'] = Support::where('support_userid', $loggedUserId)
            ->where('support_usertype', $loggedUserType)
            ->where('support_close_date', null)
            ->count();

        $uid = Session::get('user')['id'];
        $data['scheduled_interview'] = DB::table('apply_jobs')
            ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
            ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
            ->where('jobmanagers.userid', $uid)
            ->where('apply_jobs.status', '2')
            ->select('apply_jobs.*', 'jobmanagers.title as applied_for', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.email', 'jobseekers.contact', 'jobseekers.designation', 'jobseekers.expected_salary', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.current_salary', 'jobseekers.expected_salary', 'jobseekers.notice_period', 'jobseekers.preferred_location')
            ->count();
            
        $data['totalTrackercandidate'] =Tracker::where('employer_id',$uid)
            ->count();

            $data['totalSubuser'] = SubUser::where('created_by',$uid)
            ->count();   
            
            $data['totalClient'] = ClientName::where('company_id',$loggedCompanyId)->where('created_by',$uid)
            ->count();

            // dd($loggedUserId);

            if($loggedUserId == 2){
                $data['consolidateData']=ConsolidateData::select('id')
                ->count();
            }



            //subuser data count

            $empID =Session::get('user')['id'];

            $subUser =SubUser::leftjoin('trackers','trackers.added_by','sub_users.id')
            ->select('sub_users.id','sub_users.fname','sub_users.lname','sub_users.email',DB::raw("count(trackers.id) as total"))
            ->where('created_by',$empID)
            ->groupBy('sub_users.id','sub_users.fname','sub_users.lname','sub_users.email')
            ->get();


        // return response()->json(['data' => $data], 200);

        return view('employer.dashboard',[
            'data' => $data,
            'sub_user_data' => $subUser
        ]);
    }

    public function countAllDataForJobSeeker()
    {
        $loggedUserId = Session::get('user')['id'];
        $loggedUserType = Session::get('user')['user_type'];

        // COUNT APPLIED JOBS
        $data['applied_jobs'] = ApplyJob::where('jsuser_id', $loggedUserId)->count();

        // COUNT SAVED JOBS
        $applyJobID = array();
        $applyJobs = ApplyJob::where('jsuser_id', $loggedUserId)->select('job_id')->get();
        foreach ($applyJobs as $applyJob) {
            $applyJobID[] = $applyJob->job_id;
        }

        $data['saved_jobs'] = DB::table('saved_jobs')
            ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'saved_jobs.job_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'jobmanagers.company_id')
            ->leftjoin('job_types', 'job_types.id', '=', 'jobmanagers.job_type_id')
            ->select('saved_jobs.*', 'empcompaniesdetails.company_name', 'job_types.job_type', 'jobmanagers.*')
            ->where('jsuser_id', $loggedUserId)
            ->whereNotIn('job_id', $applyJobID)
            ->orWhere('job_id', 'saved_jobs.id')
            ->orderBy('saved_jobs.created_at', 'DESC')
            ->count();

        // COUNT FOLLOWING
        $data['following'] = Follower::where('user_id', $loggedUserId)
            ->where('status', '1')
            ->where('user_type', $loggedUserType)
            ->count();

        $getRelevantKeywords = Jobseeker::with(['skills' => function ($q) {
            $q->select('js_userid', 'skill', 'expert_level');
        }])->select('id', 'industry_id', 'functionalrole_id', 'preferred_location', 'job_type')
            ->where('id', $loggedUserId)
            ->get();

        $skills = array();
        foreach ($getRelevantKeywords as $skillKeyword) {
            foreach ($skillKeyword['skills'] as $skill) {
                $skills[] = $skill->skill;
            }
        }

        if (!empty($skills)) {
            $data['recommended_jobs'] = Jobmanager::where(function ($q) use ($skills) {

                foreach ($skills as $key => $skill) {
                    if ($key == 0) {
                        $q->where('job_skills', 'like', '%' . $skill . '%');
                    } else {
                        $q->orWhere('job_skills', 'like', '%' . $skill . '%');
                    }
                }

                return $q;

            })->count();

        } else {
            $data['recommended_jobs'] = 0;
        }

        // COUNT RECUITER MESSAGES
        $loggedUserType = Session::get('user')['user_type'];
        $loggedUserEmail = Session::get('user')['email'];

        $data['recruiterMessages'] = MyInbox::where('receiver_email', $loggedUserEmail)->where('receiver_usertype', $loggedUserType)->where('read_status', '0')->count();

        // return response()->json(['data' => $data], 200);

        return view('jobseeker.jobseekerDashboard', compact('data'));



    }
    public function CountSubuserActivity()
    {
        $empID =Session::get('user')['id'];
        $subUser =SubUser::leftjoin('trackers','trackers.added_by','sub_users.id')
        ->select('sub_users.id','sub_users.fname','sub_users.lname','sub_users.email',DB::raw("count(trackers.id) as total"))
        ->where('created_by',$empID)
        ->groupBy('sub_users.id','sub_users.fname','sub_users.lname','sub_users.email')
        ->get();

        return response()->json(['data' => $subUser], 200);
    }
    public function CheckEmpProfileComplete()
    {
        $empID =Session::get('user')['id'];
        $company_id =Session::get('user')['company_id'];
        $data = Empcompaniesdetail::join('all_users', 'all_users.company_id', 'empcompaniesdetails.id')->select('empcompaniesdetails.id','com_email','company_name','establish_date','website','cin_no','owner_name','com_contact','address', 'all_users.id as empid')
        ->where('empcompaniesdetails.id',$company_id)->where('all_users.id',$empID)->first();

        return response()->json(['data' => $data], 200);
    }
}
