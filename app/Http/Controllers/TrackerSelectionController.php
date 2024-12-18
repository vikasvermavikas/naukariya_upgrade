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
use Illuminate\Pagination\LengthAwarePaginator; // Import at the top
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
    // public function get_resumes(Request $request, $id)
    // {
    //     $tracker = false;
    //     $jobseeker = false;
    //     $jobseekers = '';
    //     $trackers = '';
    //     $jid = $id;
    //     $type = $request->type ? $request->type : '';
    //     $jobskills = Jobmanager::select('job_skills', 'title')->where('id', $id)->first();
    //     $uid = Auth::guard('employer')->user()->id;
    //     $allskills = explode(',', $jobskills->job_skills);
    //     $allskills = array_map('trim', $allskills);

    //     if (empty($request->type) || $request->type == 'trackers') {
    //          $tracker = true;
      
    //     // Trackers record. 
    //     $trackers = Tracker::select('trackers.id', 'trackers.name', 'trackers.experience', 'trackers.expected_ctc', 'trackers.current_designation', 'trackers.resume', 'tracker_selections.status')->leftjoin('tracker_selections', function($query) use ($id) {
    //         $query->on('tracker_selections.tracker_id', '=', 'trackers.id')
    //         ->where('tracker_selections.job_id', '=', $id);
    //     })->where('trackers.employer_id', $uid);

    //     if (is_array($allskills) && count($allskills) > 0) {

    //         $trackers->Where(function ($query) use ($allskills) {

    //             for ($i = 0; $i < count($allskills); $i++) {
    //                 $query->orWhereRaw('FIND_IN_SET(?, key_skills)', [$allskills[$i]]);
    //             }
    //         });
    //     }
    //         $trackers = $trackers->paginate(1000)->withQueryString();

    //     }
    //     else {

    //         // Fetch jobseeker record.

    //         $jobseeker = true;
    //         $jobseekers = DB::table('jobseekers')
    //         ->join('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id') // Ensure skill matching is with the jobseekers
    //         ->leftJoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id'); // Include resumes if they exist
    //          $jobseekers = $jobseekers->leftJoin('apply_jobs', function ($join) use ($jid) {
    //             $join->on('apply_jobs.jsuser_id', '=', 'jobseekers.id')
    //                 ->where('apply_jobs.job_id', '=', $jid); // Match the job_id and jsuser_id
    //         });

    //          $jobseekers = $jobseekers->select(
    //         'apply_jobs.id',
    //         'apply_jobs.job_id',
    //         'apply_jobs.status',
    //         'apply_jobs.created_at',
    //         'js_resumes.resume',
    //         'jobseekers.id as jobseekerid',
    //         'jobseekers.fname',
    //         'jobseekers.lname',
    //         'jobseekers.designation',
    //         'jobseekers.expected_salary',
    //         'jobseekers.exp_year',
    //         'jobseekers.exp_month',
    //         'jobseekers.current_salary'
    //     )
    //         ->whereIn('js_skills.skill', $allskills);

    //          $jobseekers = $jobseekers->groupBy(
    //         'jobseekers.email',
    //         'apply_jobs.id',
    //         'apply_jobs.job_id',
    //         'apply_jobs.status',
    //         'apply_jobs.created_at',
    //         'js_resumes.resume',
    //         'jobseekers.id',
    //         'jobseekers.fname',
    //         'jobseekers.lname',
    //         'jobseekers.contact',
    //         'jobseekers.designation',
    //         'jobseekers.expected_salary',
    //         'jobseekers.exp_year',
    //         'jobseekers.exp_month',
    //         'jobseekers.current_salary',
    //         'jobseekers.notice_period',
    //         'jobseekers.preferred_location'
    //     )
    //         ->paginate(100)
    //         ->withQueryString();

    //     }
       

    //     return view('employer.ats.resumes', ['jobdetails' => $jobskills, 'trackers' => $trackers, 'jobid' => $id, 'is_tracker' => $tracker, 'is_jobseeker' => $jobseeker, 'jobseekers' => $jobseekers, 'type' => $type]);
    // }



    public function get_resumes(Request $request, $id)
    {
        $tracker = false;
        $jobseeker = false;
        $combinedPaginated=false;
        $jobseekers = '';
        $trackers = '';
        $trackersData = '';
        $jid = $id;
        $type = $request->type ? $request->type : '';
        $jobskills = Jobmanager::select('job_skills', 'title')->where('id', $id)->first();
        $uid = Auth::guard('employer')->user()->id;
        $allskills = explode(',', $jobskills->job_skills);
        $allskills = array_map('trim', $allskills);

        if (!empty($request->type) and $request->type == 'trackers') {
       
            $tracker = true;
      
        // Trackers record. 
        // tracker_match_skill($jid, 'trackers.id')  
        $trackersData = Tracker::select('trackers.id', 'trackers.name', 'trackers.experience', 'trackers.expected_ctc', 'trackers.current_designation', 'trackers.resume', 'tracker_selections.status')->leftjoin('tracker_selections', function($query) use ($id) {
            $query->on('tracker_selections.tracker_id', '=', 'trackers.id')
            ->where('tracker_selections.job_id', '=', $id);
        })->where('trackers.employer_id', $uid);

        if (is_array($allskills) && count($allskills) > 0) {

            $trackersData->Where(function ($query) use ($allskills) {

                for ($i = 0; $i < count($allskills); $i++) {
                    $query->orWhereRaw('FIND_IN_SET(?, key_skills)', [$allskills[$i]]);
                }
            });
        }
        
        // $trackers = $trackersData->paginate(100)->withQueryString();
        $trackers = $trackersData->get();
        foreach ($trackers as $key => $tracker) {
            // Call the helper function to calculate the match percentage
            $match_percentage = tracker_match_skill($jid, $tracker->id);
            $tracker->match_percentage = round($match_percentage,2);
        }
        $trackers = $trackers->sortByDesc('match_percentage');

        $perPage = 100; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get current page

        // Get the slice of the sorted collection for the current page
        $currentResults = $trackers->slice(($currentPage - 1) * $perPage, $perPage);

        // Create a LengthAwarePaginator instance
        $trackers = new LengthAwarePaginator(
            $currentResults,
            $trackersData->count(), // Total number of items
            $perPage, // Items per page
            $currentPage, // Current page
            // ['path' => LengthAwarePaginator::resolveCurrentPath()] // Keep query strings
            ['path' => request()->url()] // Keep query strings
        );
        $trackers = $trackers->withQueryString();

        } elseif(!empty($request->type) and $request->type == 'jobseekers') {
           
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
        );
            // ->paginate(100)->withQueryString();
            $jobseekers = $jobseekers->get();
        foreach ($jobseekers as $key => $jobseeker) {
            // Call the helper function to calculate the match percentage
            $match_percentage = jobseeker_match_skill($jid, $jobseeker->jobseekerid);
            $jobseeker->match_percentage = round($match_percentage,2);
        }
        $jobseekers = $jobseekers->sortByDesc('match_percentage');

        $perPage = 100; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get current page

        // Get the slice of the sorted collection for the current page
        $currentResults = $jobseekers->slice(($currentPage - 1) * $perPage, $perPage);

        // Create a LengthAwarePaginator instance
        $jobseekers = new LengthAwarePaginator(
            $currentResults,
            $jobseekers->count(), // Total number of items
            $perPage, // Items per page
            $currentPage, // Current page
            // ['path' => LengthAwarePaginator::resolveCurrentPath()] // Keep query strings
            ['path' => request()->url()] // Keep query strings
        );
        $jobseekers = $jobseekers->withQueryString();

        }
        else {
          
            $trackers = Tracker::select(
                DB::raw("'tracker' as type"), // Add a type column to differentiate
                'trackers.id as id',
                'trackers.name as fname',
                'trackers.experience as experience',
                'trackers.expected_ctc as expected_salary',
                'trackers.current_designation as designation',
                'trackers.resume',
                'tracker_selections.status as status'
            )
            ->leftJoin('tracker_selections', function ($query) use ($id) {
                $query->on('tracker_selections.tracker_id', '=', 'trackers.id')
                    ->where('tracker_selections.job_id', '=', $id);
            })
            ->where('trackers.employer_id', $uid);
        
            if (is_array($allskills) && count($allskills) > 0) {
                $trackers->where(function ($query) use ($allskills) {
                    foreach ($allskills as $skill) {
                        $query->orWhereRaw('FIND_IN_SET(?, key_skills)', [$skill]);
                    }
                });
            }
            $trackers = $trackers->get(); // Fetch all trackers without pagination
        
            // Fetch jobseekers
            $jobseekers = DB::table('jobseekers')
                ->join('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id')
                ->leftJoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
                ->leftJoin('apply_jobs', function ($join) use ($jid) {
                    $join->on('apply_jobs.jsuser_id', '=', 'jobseekers.id')
                        ->where('apply_jobs.job_id', '=', $jid);
                })
                ->select(
                    DB::raw("'jobseeker' as type"), // Add a type column to differentiate
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
                ->whereIn('js_skills.skill', $allskills)
                ->groupBy(
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
                ->get(); // Fetch all jobseekers without pagination
        
            // Combine the datasets
            // $combined = collect($trackers)->merge($jobseekers);
            $combined = collect();
            // dd(get_class($trackers), get_class($jobseekers), $trackers, $jobseekers);
            foreach ($trackers as $key => $trackerData) {
                // Call the helper function to calculate the match percentage
                $match_percentage = tracker_match_skill($jid, $trackerData->id);
                $trackerData->match_percentage = round($match_percentage,2);
            }
            // print_r($tracker->match_percentage);
            // die();
            $trackers = $trackers->map(function ($tracker) {
                return [
                    'type' => 'tracker',
                    'jobseekerid' => $tracker->id,
                    'fname' => $tracker->fname,
                    'lname' => null, // Default value for lname
                    'job_id' => null,
                    'experience' => $tracker->experience ?? 0,
                    'expected_salary' => $tracker->expected_salary ?? 0,
                    'designation' => $tracker->designation ?? '',
                    'resume' => $tracker->resume ?? '',
                    'status' => $tracker->status ?? null,
                    'exp_year' => $tracker->exp_year ?? null, // Add if applicable
                    'exp_month' => $tracker->exp_month ?? null, // Add if applicable
                    'match_percentage'=> $tracker->match_percentage ??NULL,
                ];
            });

            foreach ($jobseekers as $key => $jobseekerData) {
                // Call the helper function to calculate the match percentage
                $match_percentage = jobseeker_match_skill($jid, $jobseekerData->jobseekerid);
                $jobseekerData->match_percentage = round($match_percentage,2);
            }
            // print_r($jobseeker->match_percentage);
            // die();
            
            $jobseekers = $jobseekers->map(function ($jobseeker) {
                return [
                    'type' => 'jobseeker',
                    'jobseekerid' => $jobseeker->jobseekerid,
                    'fname' => $jobseeker->fname,
                    'lname' => $jobseeker->lname,
                    'job_id' =>$jobseeker->job_id,
                    'experience' => null, // Default value for fields not present in jobseekers
                    'expected_salary' => $jobseeker->expected_salary ?? 0,
                    'designation' => $jobseeker->designation ?? '',
                    'resume' => $jobseeker->resume ?? '',
                    'status' => $jobseeker->status ?? null,
                    'exp_year' => $jobseeker->exp_year ?? null,
                    'exp_month' => $jobseeker->exp_month ?? null,
                    'match_percentage'=> $jobseeker->match_percentage ??NULL,
                ];
            });
            //  echo"<pre>";
            // //  print_r($jobseekers);
            // //  print_r($trackers);
            //  echo"</pre>";
            // die();
            

            // Merge only if both have data
            if (!$trackers->isEmpty() && !$jobseekers->isEmpty()) {
                $combined = $trackers->merge($jobseekers);
            } elseif (!$trackers->isEmpty()) {
                $combined = $trackers; // Only trackers
            } elseif (!$jobseekers->isEmpty()) {
                $combined = $jobseekers; // Only jobseekers
            }
            
          
           
            $combined = $combined->sortByDesc('match_percentage');
            // print_r($combined->count());
            // die();
            // Paginate the combined dataset manually
            $perPage = 100; // Records per page
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage);
            $combinedPaginated = new LengthAwarePaginator(
                $currentItems,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        //  print_r($combinedPaginated); 
        // die;
        }
       

        return view('employer.ats.resumes', ['jobdetails' => $jobskills, 'trackers' => $trackers, 'jobid' => $id, 'is_tracker' => $tracker, 'is_jobseeker' => $jobseeker, 'jobseekers' => $jobseekers, 'combinedPaginated' => $combinedPaginated,'type' => $type]);
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
