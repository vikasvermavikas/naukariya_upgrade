<?php

namespace App\Http\Controllers;


use File;
use App\Models\SubUser;
use App\Models\Tracker;
use App\Models\Reference;
use App\Models\TrackerEducation;
use App\Models\DesignationList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class EmpTrackerDetailsController extends Controller
{
    public $userid;
    public $companyid;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::guard('employer')->user()->id;
            $this->companyid = Auth::guard('employer')->user()->company_id;
            return $next($request);
        });
    }
    public function index(Request $request)
    {

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300'); // 5 minutes
        
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $source = $request->source;
        $location = $request->location;
        $skills = $request->skills;
        $experience = $request->experience;
        $ug = $request->ug;
        $pg = $request->pg;
        $min_salary = $request->min_salary;
        $max_salary = $request->max_salary;
        $applied_designation = $request->applied_designation;
        $current_designation = $request->current_designation;
        $view_per_page = $request->view_per_page ?? 50;
       
        $userid = $request->userid;
       
        // $keyword = $request->keyword;
        // $resume_upload = $request->resume_upload;
        // $uploaded = $resume_upload === 'yes';
        // $Notuploaded = $resume_upload === 'no';

        //  Session::set('keyword', $keyword);      
        $EmpId = $this->userid;
        $CompId = $this->companyid;


        $request->skills ?  $request->session()->put('skills', $skills) :  $request->session()->put('skills', '');
        $request->applied_designation ?  $request->session()->put('applied_designation', $applied_designation) :  $request->session()->put('applied_designation', '');
        $request->current_designation ?  $request->session()->put('current_designation', $current_designation) :  $request->session()->put('current_designation', '');

        $request->session()->put('location', $location);
        $request->session()->put('experience', $experience);
        $request->session()->put('from_date', $from_date);
        $request->session()->put('to_date', $to_date);
        $request->session()->put('ug', $ug);
        $request->session()->put('pg', $pg);
        $request->session()->put('userid', $userid);

        $education_data = TrackerEducation::select('id', 'tracker_candidate_id', 'graduation', 'graduation_year', 'post_graduation_year',  'post_graduation');
        if (isset($ug) && $ug != '') {
            $education_data->Where('tracker_education.graduation', $ug);
        }
        if (isset($pg) && $pg != '') {
            $education_data->Where('tracker_education.post_graduation', $pg);
        }
        $education_data = $education_data->get()->keyBy('tracker_candidate_id')->toArray();



        $data = Tracker::join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->select('trackers.*', 'sub_users.fname as sub_fname', 'sub_users.lname as sub_lname')
            // ->orWhere('trackers.company_id', $CompId)
            ->Where('trackers.employer_id', $EmpId);

        if ((isset($ug) && $ug != '') || (isset($pg) && $pg != '')) {
            $data->whereIn('trackers.id', function ($query) use ($ug, $pg) {
                $query->select('tracker_candidate_id')
                    ->from('tracker_education')
                    ->when(isset($ug) && $ug != '', function ($q) use ($ug) {
                        $q->where('graduation', $ug);
                    })
                    ->when(isset($pg) && $pg != '', function ($q) use ($pg) {
                        $q->where('post_graduation', $pg);
                    });
            });
        }

        if (isset($source) && $source != '') {
            $data->Where('reference', $source);
        }

        if (isset($applied_designation) && $applied_designation != '') {
            // $data->Where('trackers.designation', $designation);
            $data->Where('trackers.applied_designation', 'like', "%$applied_designation%");
        }

        if (isset($current_designation) && $current_designation != '') {
            // $data->Where('trackers.designation', $designation);
            $data->Where('trackers.current_designation', 'like', "%$current_designation%");
        }

        // Check if either minimum or maximum salary is provided
        if ((isset($min_salary) && $min_salary !== '') || (isset($max_salary) && $max_salary !== '')) {
            // Start building the where clause
            $data = $data->where(function ($query) use ($min_salary, $max_salary) {
                // Check if minimum salary is provided
                if (isset($min_salary) && $min_salary !== '') {
                    // Add condition for minimum salary
                    $query->where('trackers.current_ctc', '>=', (int)$min_salary);
                }
                // Check if maximum salary is provided
                if (isset($max_salary) && $max_salary !== '') {
                    // Add condition for maximum salary
                    $query->where('trackers.current_ctc', '<=', (int)$max_salary);
                }
            });
        }

        if (isset($experience) && $experience != '') {
            $data->Where('trackers.experience', $experience);
        }

        if (isset($skills) && $skills != '') {
            $key = explode(',', $skills);

            $data->Where(function ($query) use ($key) {
                for ($i = 0; $i < count($key); $i++) {
                    $query->where('key_skills', 'like',  "%$key[$i]%");
                }
            });
        }

        if (isset($from_date) && $from_date != '') {
            $data->whereDate('trackers.created_at', '>=', $from_date);
        }

        if (isset($to_date) && $to_date != '') {
            $data->whereDate('trackers.created_at', '<=', $to_date);
        }

        if (isset($from_date) && isset($to_date)) {
            $data->whereBetween('trackers.created_at', [$from_date, $to_date]);
        }

        if (isset($request->location) && $request->location != '') {
            $location = $request->location;
            $data->where(function ($query) use ($location){
                $query->where('current_location', 'like', '%' . $location . '%')
                    ->orWhere('preffered_location', 'like', '%' . $location . '%');
            });
            // $data->Where('current_location', 'like', '%' . $location . '%')
            //     ->orWhere('preffered_location', 'like', '%' . $location . '%');
        }

        if (!empty($userid) && $userid != 'undefined') {

            $data->Where('added_by', $userid);
        }
       
        $trackerList = $data->orderBy('trackers.id', 'desc')->paginate($view_per_page);

        // return response()->json(['data' => $trackerList, 'education_data' => $education_data], 200);
        return view('employer.tracker_list', ['data' => $trackerList, 'education_data' => $education_data, 'requestdata' => $request->all()]);
    }

    public function getUniqueSourceEmployer()
    {
        $employer_id = Session::get('user')['id'];
        // $company_id =Session::get('user')['company_id'];
        // $data = Reference::where('company_id', $company_id)->where('employer_id', $employer_id)->get();
        $data = Reference::where('employer_id', $employer_id)->get();

        return response()->json(['data' => $data]);
    }
    public function exportTrackerDataEmployer(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300'); // 5 minutes
        $past_experience = get_experience();
        // echo "<pre>";
        // var_dump($past_experience);
        // echo "</pre>";
        // die;
        $empId = Session::get('user')['id'];
        $today = date('d-m-Y');
        $keyskill = $request->session()->get('skills');
        $applied_designation = $request->session()->get('applied_designation');
        $current_designation = $request->session()->get('current_designation');
        $from_date = $request->session()->get('from_date');
        $to_date = $request->session()->get('to_date');
        // $applied_designation = $request->session()->get('designation');
        // $current_designation = $request->session()->get('designation');
        //$current_location = $request->session()->get('location');--work
        $location = $request->session()->get('location');
        $experience = $request->session()->get('experience');
        $ug = $request->session()->get('ug');
        $pg = $request->session()->get('pg');
        $userid = $request->session()->get('userid');

        // echo $keyskill;die;

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=Tracker' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];


        $list = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->leftJoin('tracker_education', 'tracker_education.tracker_candidate_id', '=', 'trackers.id')
            ->select('trackers.id as main_id', 'trackers.*', 'tracker_education.*', 'sub_users.email as emp_email', 'sub_users.fname as emp_name')
            ->where('trackers.employer_id', $empId)
            ->orderBy('trackers.id', 'desc');

        if ($keyskill) {
            $key = explode(',', $keyskill);
            // var_dump($key);
            // die();
            $list->Where(function ($query) use ($key) {
                for ($i = 0; $i < count($key); $i++) {
                    $query->where('key_skills', 'like',  "%$key[$i]%");
                }
            });
        }


        if ($applied_designation) {
            $list->where('trackers.applied_designation', 'like',  "%$applied_designation%");
        }
        if ($current_designation) {
            $list->where('trackers.current_designation', 'like',  "%$current_designation%");
        }
        if ($experience) {
            $list->where('trackers.experience', 'like',  "%$experience%");
        }
        if ($ug) {
            $list->where('tracker_education.graduation', 'like',  "%$ug%");
        }
        if ($pg) {
            $list->where('tracker_education.post_graduation', 'like',  "%$pg%");
        }

        if (isset($from_date) && $from_date != '') {
            $list->whereDate('trackers.created_at', '>=', $from_date);
        }

        if (isset($to_date) && $to_date != '') {
            $list->whereDate('trackers.created_at', '<=', $to_date);
        }

        if (isset($from_date) && isset($to_date)) {
            $list->whereBetween('trackers.created_at', [$from_date, $to_date]);
        }
        // if ($current_location) {
        //     $list->where('trackers.current_location', 'like',  "%$current_location%");--this is also work
        // }

        // if ($location) {
        //     $list->where('trackers.current_location', 'like',  "%$location%");
        // }
        if ($location) {
            $list->where(function ($query) use ($location) {
                $query->where('current_location', 'like', '%' . $location . '%')
                    ->orWhere('preffered_location', 'like', '%' . $location . '%');
            });
            // $list->Where('current_location', 'like', '%' . $location . '%')
            //     ->orWhere('preffered_location', 'like', '%' . $location . '%');
        }

        if (!empty($userid) && $userid != 'undefined') {

            $list->Where('added_by', $userid);
        }
        $list =   $list->get();
        // echo "<pre>";
        // var_dump($list->toSql());
        // echo "</pre>";
        // die;

        // dd($list);die;

        // foreach ($list as $key  => $value) {

        //     $value->past_exp = DB::table('tracker_past_experience')->where('tracker_candidate_id', $value->main_id)->get();

        //  foreach($value->past_exp as $pastexp){

        //     $company_name[$pastexp->company_name] = $pastexp->company_name;
        //     $value->designation = $pastexp->designation.",";
        //     if(empty($pastexp->to)){
        //         $pastexp->to = "Working";
        //     }
        //     $value->tenure = $pastexp->from."-".$pastexp->to.",";
        // }



        // }
        $no = 0;

        $list = collect($list)->map(function ($x, $no) use ($past_experience) {
            $company_name = [];
            $designation_name = [];
            $tenure_name = [];
            $exp = $x->experience;
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $exp)) {
                $exp = str_replace('-', ' to ', $exp);
            }
            // foreach ($x->past_exp as $pastexp) {

            //     $company_name[$x->main_id][$pastexp->company_name] = $pastexp->company_name;
            //     if (empty($pastexp->designation)) {
            //         $pastexp->designation = "N/A";
            //     }
            //     $designation_name[$x->main_id][$pastexp->designation] = $pastexp->designation;
            //     if (empty($pastexp->to)) {
            //         $pastexp->to = "Working";
            //     }
            //     $tenure_name[$x->main_id][$pastexp->from . "-" . $pastexp->to] = "(" . $pastexp->from . "," . $pastexp->to . ")";
            // }
            //   dd($company_name);
            return [
                'S.No' => $no + 1,
                'Name' => $x->name . '-' . $x->main_id . '' . count($company_name),
                'Email' => $x->email,
                'Contact' => $x->contact,
                'Gender' => $x->gender ? $x->gender : 'Not Available',
                'Skill Sets' => $x->key_skills ? $x->key_skills : 'Not Available',
                'Notice Period' => $x->notice_period ? $x->notice_period : 'Not Available',
                'Applied Designation' => $x->applied_designation ? $x->applied_designation : 'Not Available',
                'Current Designation' => $x->current_designation ? $x->current_designation : 'Not Available',
                'Experience(in Yr)' => $exp ? $exp : 'Not Available',
                'Expected CTC' => $x->expected_ctc ? $x->expected_ctc : 'Not Available',
                'Current CTC' => $x->current_ctc ? $x->current_ctc : 'Not Available',
                'Current Location' => $x->current_location ? $x->current_location : 'Not Available',
                'Preffered Location' => $x->preffered_location ? $x->preffered_location : 'Not Available',
                'HomeTown State' => $x->hometown_state ? $x->hometown_state : 'Not Available',
                'HomeTown City' => $x->hometown_city ? $x->hometown_city : 'Not Available',
                'Tenth Board Name' => $x->tenth_board_name ? $x->tenth_board_name :  'Not Available',
                'Tenth Percentage' => $x->tenth_percentage ? $x->tenth_percentage :  'Not Available',
                'Tenth Year' => $x->tenth_year ? $x->tenth_year : 'Not Available',
                'Twelth Board Name' => $x->twelve_board_name ? $x->twelve_board_name :  'Not Available',
                'Twelth Percentage' => $x->twelve_percentage ? $x->twelve_percentage :  'Not Available',
                'Twelth Year' => $x->twelve_year ? $x->twelve_year :  'Not Available',
                'Diploma Board Name' => $x->diploma_board ?  $x->diploma_board :  'Not Available',
                'Diploma Field' => $x->diploma_field ? $x->diploma_field :  'Not Available',
                'Diploma Percentage' => $x->diploma_percentage ? $x->diploma_percentage :  'Not Available',
                'Diploma Year' => $x->diploma_year ? $x->diploma_year : 'Not Available',
                'graduation' => $x->graduation ? $x->graduation : 'Not Available',
                'Graduation Mode' => $x->graduation_mode ? $x->graduation_mode :  'Not Available',
                'Graduation Stream' => $x->graduation_stream ? $x->graduation_stream :  'Not Available',
                'graduation Percentage' =>  $x->graduation_percentage ? $x->graduation_percentage :  'Not Available',
                'Graduation Year' => $x->graduation_year ? $x->graduation_year :  'Not Available',
                'Post Graduation' => $x->post_graduation ? $x->post_graduation :  'Not Available',
                'Post Graduation Mode' => $x->post_graduation_mode ? $x->post_graduation_mode :  'Not Available',
                'Post Graduation Stream' => $x->post_graduate_stream ? $x->post_graduate_stream :  'Not Available',
                'Post Graduation percentage' => $x->post_graduation_percentage ? $x->post_graduation_percentage :  'Not Available',

                // 'Company Name' => count($company_name) > 0 ? implode(',', $company_name[$x->main_id]) : 'Not Available',
                // 'Designation' => count($designation_name) > 0 ? implode(',', $designation_name[$x->main_id]) : 'Not Available',
                // 'Tenure' => count($tenure_name) > 0 ? implode(',', $tenure_name[$x->main_id]) : 'Not Available',

                'Company Name' => isset($past_experience[$x->main_id]) ? $past_experience[$x->main_id]->company_name : 'Not Available',
                'Designation' => isset($past_experience[$x->main_id]) ? $past_experience[$x->main_id]->designation : 'Not Available',
                'Tenure' => isset($past_experience[$x->main_id]) ? $past_experience[$x->main_id]->from_date : 'Not Available',

                'Resume' => $x->resume ? url('/tracker/resume/' . $x->resume) : 'Not Available',
                'Source' => $x->reference ? $x->reference : 'Not Available',
                'Added By' => $x->emp_email ? $x->emp_email : 'Not Available',
                'Date' => $x->created_at
                // 'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                // 'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
            ];
        })->toArray();

       
        # add headers for each column in the CSV download
        if (is_array($list) && count($list) > 0) {
            array_unshift($list, array_keys($list[0]));
        }

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers)->send();
    }
    public function ExportTrackerCheckedDataEmployer($id)
    {
        $today = date('d-m-Y');
        $ids = explode(',', $id);
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=TrackerExport' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->select('trackers.*', 'sub_users.email as emp_email', 'sub_users.fname as emp_name')
            ->orderBy('trackers.id', 'desc')
            ->whereIn('trackers.id', $ids)
            ->get();
        $no = 0;
        $list = collect($list)->map(function ($x, $no) {
            $exp = $x->experience;
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $exp)) {
                $exp = str_replace('-', ' to ', $exp);
            }
            return [
                'S.No' => $no + 1,
                'Name' => $x->name,
                'Email' => $x->email,
                'Contact' => $x->contact,
                'Gender' => $x->gender ? $x->gender : 'Not Available',
                'Skill Sets' => $x->key_skills ? $x->key_skills : 'Not Available',
                'Notice Period' => $x->notice_period ? $x->notice_period : 'Not Available',
                'Applied Designation' => $x->applied_designation ? $x->applied_designation : 'Not Available',
                'Current Designation' => $x->current_designation ? $x->current_designation : 'Not Available',
                'Experience(in Yr)' => $exp ? $exp : 'Not Available',
                'Expected CTC' => $x->expected_ctc ? $x->expected_ctc : 'Not Available',
                'Current CTC' => $x->current_ctc ? $x->current_ctc : 'Not Available',
                'Current Location' => $x->current_location ? $x->current_location : 'Not Available',
                'Preffered Location' => $x->preffered_location ? $x->preffered_location : 'Not Available',
                'Resume' => $x->resume ? url('/tracker/resume/' . $x->resume) : 'Not Available',
                'Source' => $x->reference ? $x->reference : 'Not Available',
                'Added By' => $x->emp_email ? $x->emp_email : 'Not Available',
                'Date' => $x->created_at
                // 'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                // 'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
            ];
        })->toArray();

        # add headers for each column in the CSV download
        if (is_array($list)){
            array_unshift($list, array_keys($list[0]));
        }

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function getsingleResume($id)
    {
        $data = Tracker::where('id', $id)->select('id', 'resume', 'name')->first();

        return response()->json(['data' => $data]);
    }
    public function getsingle($id)
    {
        // dd($id);
        $data = Tracker::leftJoin('tracker_education', 'tracker_education.tracker_candidate_id', '=', 'trackers.id')
            ->select('trackers.*', 'tracker_education.graduation', 'tracker_education.graduation_year', 'tracker_education.post_graduation_year',  'tracker_education.post_graduation')
            ->where('trackers.id', $id)->get()[0];

        return response()->json(['data' => $data]);
    }

    public function tracker_details($id){

        try {
        $tracker = Tracker::leftJoin('tracker_education', 'tracker_education.tracker_candidate_id', '=', 'trackers.id')
            ->select('trackers.*', 'tracker_education.graduation', 'tracker_education.post_graduation' )
            ->where('trackers.id', $id)->first();
        return view('employer.tracker_details', ['tracker' => $tracker]);
        }
        catch(throwable $exception){
            return redirect()->back()->with(['error' => true, 'message' => 'Invalid Tracker.']);
        }
  
    }
}
