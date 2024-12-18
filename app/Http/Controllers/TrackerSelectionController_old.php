<?php

namespace App\Http\Controllers;

use App\Models\TrackerSelection;
use App\Models\TrackerInterview;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use DB;
use App\Models\ApplyJob;
use App\Models\Jobmanager;
use App\Models\Tracker;
use App\Models\Jobseeker;
class TrackerSelectionController extends Controller
{
    /**
     * Display a listing of the ats.
     */
    public function ats()
    {
        $uid = Auth::guard('employer')->user()->id;
        $data = DB::table('jobmanagers')
            ->leftjoin('job_categories', 'job_categories.id', 'jobmanagers.job_category_id')
            ->leftjoin('client_names', 'client_names.id', 'jobmanagers.client_id')
            ->select('jobmanagers.id', 'jobmanagers.title', 'jobmanagers.status', 'jobmanagers.last_apply_date',  'jobmanagers.created_at',  'jobmanagers.updated_at', 'job_categories.job_category', 'client_names.name')
            ->where('jobmanagers.userid', $uid)
            ->where('jobmanagers.status', 'Active')
            ->orderBy('jobmanagers.created_at', 'DESC');


        $data = $data->paginate(10);
        foreach ($data as $value) {
            $value->total_applications = $this->count_applyjob($value->id);
            $value->total_resumes = $this->count_relevant_resumes($value->id);
        }
        return view('employer.ats.index', ['data' => $data]);
    }

    /**
     * Get Interview Details.
     */
    public function interview_details(Request $request)
    {
       $info = TrackerInterview::select('interview_date', 'interview_details')->where([
            'tracker_id' => $request->tracker_id,
            'job_id' => $request->job_id
        ])->first();

        if ($info) {
            return response()->json(['success' => true, 'details' => $info], 200);
        }
        return response()->json(['success' => false, 'message' => 'Interview Not Scheduled']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'job_id' => 'required|integer',
            'tracker_id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $employer_id = Auth::guard('employer')->user()->id;
        $data = $request->all();
        $data['employer_id'] = $employer_id;

        $result = TrackerSelection::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);
                
        $response = [];

        if($result){
            $response['success'] = true;
            $response['text'] = 'Tracker status changed successfully.';
            $response['title'] = 'Status updated';
            return response()->json($response, 200);
        }
        else {
            $response['success'] = false;
            $response['message'] = 'Server Error.';
            return response()->json($response, 200);
        }
    }

    /**
     * Schedule Interview.
     */
    public function schedule_interview(Request $request)
    {
        $this->validate($request, [
            'job_id' => 'required|integer',
            'tracker_id' => 'required|integer',
            'interview_date' => 'required'
        ]);

        $employer_id = Auth::guard('employer')->user()->id;
        $data = $request->all();
        $data['status'] = 'interview-scheduled';
        TrackerSelection::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);

        $result = TrackerInterview::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);

        return redirect()->back()->with(['success' => 'true', 'message' => 'Interview Scheduled Successfully.']);

    }

    /**
     * Get relevant count of resumes.
     * params jobid int
     * return totalresumes int
     */
    public function count_relevant_resumes($id)
    {
        $employerid = auth()->guard('employer')->user()->id;
        $jobskiils = Jobmanager::select('job_skills')->where('id', $id)->first();
        $allskills = explode(',', $jobskiils->job_skills);
        $allskills = array_map('trim', $allskills);

        // Trackers Count.
        $trackercount = Tracker::where('employer_id', $employerid)
            ->Where(function ($query) use ($allskills) {
                for ($i = 0; $i < count($allskills); $i++) {
                    $query->orWhereRaw('FIND_IN_SET(?, key_skills)', [$allskills[$i]]);
                }
            })->count();

        // JobSeekers Count.
        $jobseekercount = Jobseeker::join('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id')
            ->whereIn('js_skills.skill', $allskills)->distinct('jobseekers.id')->count('jobseekers.id');  

        return $trackercount + $jobseekercount;

    }

    /**
     * Update the specified resource in storage.
     */
    public function get_resumes(Request $request, $id)
    {
        $tracker = false;
        $jobseeker = false;
        $jobseekers = '';
        $trackers = '';
        $jid = $id;
        $type = $request->type ? $request->type : '';
        $jobskills = Jobmanager::select('job_skills', 'title')->where('id', $id)->first();
        $uid = Auth::guard('employer')->user()->id;
        $allskills = explode(',', $jobskills->job_skills);
        $allskills = array_map('trim', $allskills);

        if (empty($request->type) || $request->type == 'trackers') {
             $tracker = true;
      
        // Trackers record. 
        $trackers = Tracker::select('trackers.id', 'trackers.name', 'trackers.experience', 'trackers.expected_ctc', 'trackers.current_designation', 'trackers.resume', 'tracker_selections.status')->leftjoin('tracker_selections', function($query) use ($id) {
            $query->on('tracker_selections.tracker_id', '=', 'trackers.id')
            ->where('tracker_selections.job_id', '=', $id);
        })->where('trackers.employer_id', $uid);

        if (is_array($allskills) && count($allskills) > 0) {

            $trackers->Where(function ($query) use ($allskills) {

                for ($i = 0; $i < count($allskills); $i++) {
                    $query->orWhereRaw('FIND_IN_SET(?, key_skills)', [$allskills[$i]]);
                }
            });
        }
            $trackers = $trackers->paginate(1000)->withQueryString();

        }
        else {

            // Fetch jobseeker record.

            $jobseeker = true;
            $jobseekers = DB::table('jobseekers')
            ->join('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id') // Ensure skill matching is with the jobseekers
            ->leftJoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id'); // Include resumes if they exist
             $jobseekers = $jobseekers->leftJoin('apply_jobs', function ($join) use ($jid) {
                $join->on('apply_jobs.jsuser_id', '=', 'jobseekers.id')
                    ->where('apply_jobs.job_id', '=', $jid); // Match the job_id and jsuser_id
            });

             $jobseekers = $jobseekers->select(
            'apply_jobs.id',
            'apply_jobs.job_id',
            'apply_jobs.status',
            'apply_jobs.created_at',
            'js_resumes.resume',
            'jobseekers.id as jobseekerid',
            'jobseekers.fname',
            'jobseekers.lname',
            'jobseekers.designation',
            'jobseekers.expected_salary',
            'jobseekers.exp_year',
            'jobseekers.exp_month',
            'jobseekers.current_salary'
        )
            ->whereIn('js_skills.skill', $allskills);

             $jobseekers = $jobseekers->groupBy(
            'jobseekers.email',
            'apply_jobs.id',
            'apply_jobs.job_id',
            'apply_jobs.status',
            'apply_jobs.created_at',
            'js_resumes.resume',
            'jobseekers.id',
            'jobseekers.fname',
            'jobseekers.lname',
            'jobseekers.contact',
            'jobseekers.designation',
            'jobseekers.expected_salary',
            'jobseekers.exp_year',
            'jobseekers.exp_month',
            'jobseekers.current_salary',
            'jobseekers.notice_period',
            'jobseekers.preferred_location'
        )
            ->paginate(100)
            ->withQueryString();

        }
       

        return view('employer.ats.resumes', ['jobdetails' => $jobskills, 'trackers' => $trackers, 'jobid' => $id, 'is_tracker' => $tracker, 'is_jobseeker' => $jobseeker, 'jobseekers' => $jobseekers, 'type' => $type]);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function count_applyjob($id)
    {
        $jobskiils = Jobmanager::select('job_skills')->where('id', $id)->first();
        $allskills = explode(',', $jobskiils->job_skills);
        $allskills = array_map('trim', $allskills);

        $data = ApplyJob::join('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')->join('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id')->where('apply_jobs.job_id', $id)
            ->where('apply_jobs.status', 1)
            ->whereIn('js_skills.skill', $allskills)
            ->distinct('jobseekers.id')->count('jobseekers.id');
        // return response($data);
        return $data;
    }

    public function view_job($id)
    {
        try {
            $job = Jobmanager::select(
                'jobmanagers.id',
                'jobmanagers.qualification_for_gov',
                'jobmanagers.location',
                'jobmanagers.department',
                'jobmanagers.attachment',
                'jobmanagers.company_id',
                'jobmanagers.job_preference',
                'jobmanagers.job_exp',
                'jobmanagers.title',
                'jobmanagers.responsibility',
                'jobmanagers.job_skills',
                'jobmanagers.job_address',
                'jobmanagers.description',
                'jobmanagers.offered_sal_min',
                'jobmanagers.offered_sal_max',
                'jobmanagers.main_exp',
                'jobmanagers.max_exp',
                'jobmanagers.job_vaccancy',
                'job_shifts.job_shift',
                'job_types.job_type',
                'jobmanagers.government_apply_link',
                'jobmanagers.start_apply_date',
                'jobmanagers.last_apply_date',
                'jobmanagers.sal_disclosed'
            )->leftjoin('job_types', 'job_types.id', 'jobmanagers.job_type_id')
                ->leftjoin('job_shifts', 'job_shifts.id', 'jobmanagers.job_shift_id')->findOrFail($id);
            return view('employer.ats.job_description', ['job' => $job]);
        } catch (Throwable $e) {
        }
    }
}
