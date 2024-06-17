<?php

namespace App\Http\Controllers;

use File;
use App\Models\SubUser;
use App\Models\Tracker;
use App\Models\DesignationList;
use App\Models\TrackerEducation;
use App\Models\TrackerPastExperience;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;


class TrackerController extends Controller
{

    public function index(Request $request)
    {

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $source = $request->source;
        $location = $request->location;
        $skills = $request->skills;
        $uploadstatus = $request->uploadstatus;
        $keyword = $request->keyword;
        $subuser_id = Session::get('user')['id'];

        $data = Tracker::where('added_by', $subuser_id)->orderBy('id', 'desc');

        if (isset($source) && $source != '') {
            $data->Where('reference', $source);
        }


        if (isset($from_date) && $from_date != '') {
            $data->whereDate('created_at', '>=', $from_date);
        }

        if (isset($to_date) && $to_date != '') {
            $data->whereDate('created_at', '<=', $to_date);
        }

        if (isset($from_date) && isset($to_date)) {
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        if (isset($keyword) && $keyword !== '') {
            $data->where(function ($query) use ($keyword) {
                $query->where('current_location', 'like', "%$keyword%")
                    ->orwhere('preffered_location', 'like', "%$keyword%")
                    ->orWhere('key_skills', 'like', "%$keyword%")
                    ->orwhere('reference', 'like', "%$keyword%")
                    ->orWhere('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('contact', $keyword)
                    ->orWhere('gender', $keyword)
                    ->orWhere('current_designation', 'like', "%$keyword%")
                    ->orWhere('experience', 'like', "%$keyword%")
                    ->orWhere('current_ctc', 'like', "%$keyword%")
                    ->orWhere('expected_ctc', 'like', "%$keyword%");
            });
        }


        if (isset($location) && $location != '') {
            $data->Where('current_location', 'like', "%$location%")
                ->orWhere('preffered_location', 'like', "%$location%");
        }

        // if (isset($skills) && $skills != '') {
        //     $data->Where('key_skills', 'like', "%$skills%");
        // }
        if (isset($skills) && $skills != '') {
            $key = explode(',', $skills);
            $data->Where(function ($query) use ($key) {
                for ($i = 0; $i < count($key); $i++) {
                    $query->orwhere('key_skills', 'like',  '%' . $key[$i] . '%');
                }
            });
        }
        if (isset($uploadstatus)) {

            if ($uploadstatus === 'yes') {
                $data->WhereNotNull('resume');
            }
            if ($uploadstatus === 'no') {
                $data->WhereNull('resume');
            }
        }


        $trackerList = $data->paginate(50);


        return response()->json(['data' => $trackerList], 200);
    }

    public function store(Request $request)
    {
        //dd($request);
        $subuser_id = Session::get('user')['id'];
        $company_id = Session::get('user')['company_id'];
        $addedbyEmployerId = SubUser::where('id', $subuser_id)->first();

        $tracker = new Tracker();

        $tracker->name = $request->name;
        $tracker->email = $request->email;
        $tracker->contact = $request->contact;
        $tracker->dob = $request->dob;
        $tracker->maritial_status = $request->maritial_status;
        $tracker->intrested_job_type = $request->intrested_job_type;
        $tracker->hometown_state = $request->hometown_state;
        $tracker->hometown_city = $request->hometown_city;
        $tracker->applied_designation = $request->applied_designation;
        $tracker->current_designation = $request->current_designation;
        $tracker->key_skills = $request->skills;
        $tracker->experience = $request->experience;
        $tracker->current_ctc = $request->current_ctc;
        $tracker->expected_ctc = $request->expected_ctc;
        $tracker->notice_period = $request->notice_period;
        //if (!empty($project->project_file)
        if ($request->hasFile('resume')) {

            $filename = time() . '.' . $request->resume->getClientOriginalExtension();
            $tracker->resume = $filename;
            //unlink($path,$tracker->resume);
        }

        $tracker->gender = $request->gender;
        $tracker->remarks = $request->remarks;
        $tracker->current_location = $request->current_location;
        $tracker->preffered_location = $request->preffered_location;
        $tracker->reference = $request->reference;
        $tracker->company_id = $company_id;
        $tracker->employer_id = $addedbyEmployerId->created_by;
        $tracker->added_by = $subuser_id;


        $data = $tracker->save();
        if ($data) {

            //resume upload
            if ($request->hasFile('resume')) {
                //in local
                $path = 'public/tracker/resume/';
                //in live server
                //$path='public/tracker/resume/';
                //   return response()->json(['data' => $filename], 500);
                $upload = $request->resume->move($path, $filename);



                //unlink($path,$tracker->resume);
            }


            // if ($request->tenth_board != '' || $request->twelve_board != '' || $request->diploma_board != '' || $request->graduation_mode != '' || $request->post_graduation_mode != '') {
            $trackerEdu = new TrackerEducation();

            $trackerEdu->tracker_candidate_id = $tracker->id;

            $trackerEdu->tenth_board_name = $request->tenth_board ? $request->tenth_board : NULL;
            $trackerEdu->tenth_percentage = $request->tenth_percentage ? $request->tenth_percentage : NULL;
            $trackerEdu->tenth_year = $request->tenth_year ? $request->tenth_year : NULL;

            $trackerEdu->twelve_board_name = $request->twelth_board ? $request->twelth_board : NULL;
            $trackerEdu->twelve_percentage = $request->twelth_percentage ? $request->twelth_percentage : NULL;
            $trackerEdu->twelve_year = $request->twelth_year ? $request->twelth_year : NULL;

            $trackerEdu->diploma_board = $request->diploma_board ? $request->diploma_board : NULL;
            $trackerEdu->diploma_field = $request->diploma_field ? $request->diploma_field : NULL;
            $trackerEdu->diploma_percentage = $request->diploma_percentage ? $request->diploma_percentage : NULL;
            $trackerEdu->diploma_year = $request->diploma_year ? $request->diploma_year : NULL;

            $trackerEdu->graduation = $request->graduation ? $request->graduation : NULL;
            $trackerEdu->graduation_mode = $request->graduation_mode ? $request->graduation_mode : NULL;
            $trackerEdu->graduation_stream = $request->graduation_stream ? $request->graduation_stream : NULL;
            $trackerEdu->graduation_percentage = $request->graduation_percentage ? $request->graduation_percentage : NULL;
            $trackerEdu->graduation_year = $request->graduation_year ? $request->graduation_year : NULL;

            $trackerEdu->post_graduation = $request->post_graduation ? $request->post_graduation : NULL;
            $trackerEdu->post_graduation_mode = $request->post_graduation_mode ? $request->post_graduation_mode : NULL;
            $trackerEdu->post_graduate_stream = $request->post_graduate_stream ? $request->post_graduate_stream : NULL;
            $trackerEdu->post_graduation_percentage = $request->post_graduation_percentage ? $request->post_graduation_percentage : NULL;
            $trackerEdu->post_graduation_year = $request->post_graduation_year ? $request->post_graduation_year : NULL;

            $trackerEdu->save();
            // }


            $companyName = explode(",", $request->company_name);
            $count = count($companyName);


            if ($count > 0) {


                for ($i = 0; $i < $count; $i++) {
                    $trackerExp = new TrackerPastExperience();

                    $designation = explode(",", $request->working_as);
                    $from = explode(",", $request->from);
                    $to = explode(",", $request->to);

                    $trackerExp->tracker_candidate_id = $tracker->id;
                    $trackerExp->company_name = $companyName[$i];
                    $trackerExp->designation = $designation[$i];

                    $trackerExp->currently_working = ($i == 0 && $request->currentlyWork == 1) ? '1' : NULL;

                    $trackerExp->from = $from[$i];
                    $trackerExp->to = $to[$i];

                    $trackerExp->save();
                }
            }



            //new designation add(if exist)
            if (isset($request->designation)) {
                $designation = Str::upper($request->designation);
                $desList = DesignationList::where('designation', $designation)->first();
                $designationList = Str::upper($desList);

                if ($designationList === null || $designationList === "") {
                    $add = new DesignationList();
                    $add->designation = $designation;
                    $add->employer_id = $addedbyEmployerId->created_by;
                    $add->added_by = $subuser_id;
                    $add->save();
                }
            }
        }
        //return response()->json(['data' => $data], 200);

    }

    public function edit($id)
    {
        $Details = Tracker::leftJoin('tracker_education', 'tracker_education.tracker_candidate_id', '=', 'trackers.id')
            ->select('*')
            ->where('trackers.id', $id)
            ->first();

        $experience = TrackerPastExperience::where('tracker_candidate_id', $id)->get();
        return response()->json(['data' => $Details, 'experience' => $experience]);
    }

    public function update(Request $request, Tracker $tracker)
    {
        //dd($request->all());
        $subuser_id = Session::get('user')['id'];
        $company_id = Session::get('user')['company_id'];
        $addedbyEmployerId = SubUser::where('id', $subuser_id)->first();

        $id = $request->id;

        $tracker = Tracker::find($id);

        $tracker->name = $request->name;
        $tracker->email = $request->email;
        $tracker->contact = $request->contact;
        $tracker->current_designation = $request->current_designation;
        $tracker->key_skills = $request->key_skills;
        $tracker->experience = $request->experience;
        $tracker->current_ctc = $request->current_ctc;
        $tracker->expected_ctc = $request->expected_ctc;
        $tracker->notice_period = $request->notice_period;
        $tracker->gender = $request->gender;
        $tracker->remarks = $request->remarks;
        $tracker->company_id = $company_id;
        $tracker->employer_id = $addedbyEmployerId->created_by;
        $tracker->added_by = $subuser_id;
        $tracker->current_location = $request->current_location;
        $tracker->preffered_location = $request->preffered_location;
        $tracker->reference = $request->reference;

        $tracker->dob = $request->dob;
        $tracker->maritial_status = $request->maritial_status;
        $tracker->intrested_job_type = $request->intrested_job_type;
        $tracker->hometown_state = $request->hometown_state;
        $tracker->hometown_city = $request->hometown_city;
        $tracker->applied_designation = $request->applied_designation;

        $data = $tracker->save();

        $educationrecord = TrackerEducation::where('tracker_candidate_id', $id);
        //  Update the education details.
        if ($educationrecord->exists()) {
            $trackerEdu = $educationrecord->first();
        }
        else{
            $trackerEdu = new TrackerEducation();
            $trackerEdu->tracker_candidate_id = $id;
        }
            $trackerEdu->tenth_board_name = $request->tenth_board_name ? $request->tenth_board_name : NULL;
            $trackerEdu->tenth_percentage = $request->tenth_percentage ? $request->tenth_percentage : NULL;
            $trackerEdu->tenth_year = $request->tenth_year ? $request->tenth_year : NULL;

            $trackerEdu->twelve_board_name = $request->twelve_board_name ? $request->twelve_board_name : NULL;
            $trackerEdu->twelve_percentage = $request->twelve_percentage ? $request->twelve_percentage : NULL;
            $trackerEdu->twelve_year = $request->twelve_year ? $request->twelve_year : NULL;

            $trackerEdu->diploma_board = $request->diploma_board ? $request->diploma_board : NULL;
            $trackerEdu->diploma_field = $request->diploma_field ? $request->diploma_field : NULL;
            $trackerEdu->diploma_percentage = $request->diploma_percentage ? $request->diploma_percentage : NULL;
            $trackerEdu->diploma_year = $request->diploma_year ? $request->diploma_year : NULL;

            $trackerEdu->graduation = $request->graduation ? $request->graduation : NULL;
            $trackerEdu->graduation_mode = $request->graduation_mode ? $request->graduation_mode : NULL;
            $trackerEdu->graduation_stream = $request->graduation_stream ? $request->graduation_stream : NULL;
            $trackerEdu->graduation_percentage = $request->graduation_percentage ? $request->graduation_percentage : NULL;
            $trackerEdu->graduation_year = $request->graduation_year ? $request->graduation_year : NULL;

            $trackerEdu->post_graduation = $request->post_graduation ? $request->post_graduation : NULL;
            $trackerEdu->post_graduation_mode = $request->post_graduation_mode ? $request->post_graduation_mode : NULL;
            $trackerEdu->post_graduate_stream = $request->post_graduate_stream ? $request->post_graduate_stream : NULL;
            $trackerEdu->post_graduation_percentage = $request->post_graduation_percentage ? $request->post_graduation_percentage : NULL;
            $trackerEdu->post_graduation_year = $request->post_graduation_year ? $request->post_graduation_year : NULL;

            $trackerEdu->save();
        

        // Update experience information.
        $experiencedetails = $request->experience_details;
        $allexperience = 0;
        if ($experiencedetails) {
            $allexperience = count($experiencedetails);
        }

        if ($allexperience > 0) {
            for ($i = 0; $i < $allexperience; $i++) {
                if (isset($experiencedetails[$i]['id'])) {
                    // Update existing record.
                    $existrecord = TrackerPastExperience::find($experiencedetails[$i]['id']);
                } else {
                    // Create new record.
                    $existrecord = new TrackerPastExperience;
                    $existrecord->tracker_candidate_id = $id;
                }
                // Set current working record.
                if (isset($experiencedetails[$i]['currently_working'])){
                    $existrecord->currently_working = $experiencedetails[$i]['currently_working'];
                }
                else{
                    $existrecord->currently_working = Null; 
                }


                $existrecord->company_name = $experiencedetails[$i]['company_name'];
                $existrecord->designation = $experiencedetails[$i]['designation'];
                $existrecord->from = $experiencedetails[$i]['from'];
                $existrecord->to = $experiencedetails[$i]['to'];
                $existrecord->save();
            }
        }

        // Delete removed experciend records.
        $removed_experienced = $request->removed_experiences;
        if ($removed_experienced) {
            $removed_items = count($removed_experienced);
            if ($removed_items > 0) {
                for ($i = 0; $i < $removed_items; $i++) {
                    $deleterecord = TrackerPastExperience::find($removed_experienced[$i]);
                    $deleterecord->delete();
                }
            }
        }

        if ($data) {
            // New designation add if designation is not exist in our record.
            if (isset($request->current_designation) && $request->current_designation !== '') {
                $designation = Str::upper($request->current_designation);
                $desList = DesignationList::where('designation', $designation)->first();
                $designationList = Str::upper($desList);

                if ($designationList === null || $designationList === "") {
                    $add = new DesignationList();
                    $add->designation = $designation;
                    $add->employer_id = $addedbyEmployerId->created_by;
                    $add->added_by = $subuser_id;
                    $add->save();
                }
            }
        }
        return response()->json(['data' => $data], 200);
    }
    public function uploadResume(Request $request)
    {
        //dd($request->all());
        $id = $request->id;
        $tracker = Tracker::find($id);
        $old_res = $tracker->resume;
        if (isset($request->resume)) {
            $filename = time() . '.' . $request->resume->getClientOriginalExtension();
            $resumeData = [
                'resume' => $filename,
            ];

            $path = 'public/tracker/resume/';
            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            Tracker::updateOrCreate(['id' => $id], $resumeData);


            $upload = $request->resume->move($path, $filename);
        }
    }
    public function getUniqueSourceEmployer()
    {
        $data = Tracker::distinct()->pluck('reference');


        return response()->json(['data' => $data]);
    }
    public function exportTrackerDataEmployer()
    {
        $subuserId = Session::get('user')['id'];
        $today = date('d-m-Y');

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=Tracker' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            // ->leftJoin('tracker_education', 'tracker_education.tracker_candidate_id', '=', 'trackers.id')
            ->select(
                'trackers.*',
                'sub_users.email as emp_email',
                'sub_users.fname as emp_name',
                // 'tracker_education.tenth_board_name',
                // 'tracker_education.tenth_percentage',
                // 'tracker_education.tenth_year',
                // 'tracker_education.twelve_board_name',
                // 'tracker_education.twelve_percentage',
                // 'tracker_education.twelve_year',
                // 'tracker_education.diploma_board',
                // 'tracker_education.diploma_field',
                // 'tracker_education.diploma_percentage',
                // 'tracker_education.diploma_year',
                // 'tracker_education.graduation',
                // 'tracker_education.graduation_mode',
                // 'tracker_education.graduation_percentage',
                // 'tracker_education.graduation_year',
                // 'tracker_education.post_graduation',
                // 'tracker_education.post_graduation_mode',
                // 'tracker_education.post_graduation_percentage',
                // 'tracker_education.post_graduation_year'
            )
            ->where('added_by', $subuserId)
            ->orderBy('id', 'desc')
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
                'Maritial Status' => $x->maritial_status ? $x->maritial_status : 'Not Available',
                'Skill Sets' => $x->key_skills ? $x->key_skills : 'Not Available',
                'Notice Period' => $x->notice_period ? $x->notice_period : 'Not Available',
                'Current Designation' => $x->current_designation ? $x->current_designation : 'Not Available',
                'Applied Designation' => $x->applied_designation ? $x->applied_designation : 'Not Available',
                'Experience(in Yr)' => $exp ? $exp : 'Not Available',
                'Expected CTC' => $x->expected_ctc ? $x->expected_ctc : 'Not Available',
                'Current CTC' => $x->current_ctc ? $x->current_ctc : 'Not Available',
                'Current Location' => $x->current_location ? $x->current_location : 'Not Available',
                'Preffered Location' => $x->preffered_location ? $x->preffered_location : 'Not Available',
                'Resume' => $x->resume ? url('/tracker/resume/' . $x->resume) : 'Not Available',
                // 'Tenth Board Name' => $x->tenth_board_name ? $x->tenth_board_name : 'Not Available',
                // 'Tenth Percentage' => $x->tenth_percentage ? $x->tenth_percentage : 'Not Available',
                // 'Tenth Year' => $x->tenth_year ? $x->tenth_year : 'Not Available',
                // 'Twelth Board Name ' => $x->twelve_board_name ? $x->twelve_board_name : 'Not Available',
                // 'Twelth Percentage ' => $x->twelve_percentage ? $x->twelve_percentage : 'Not Available',
                // 'Twelth Year ' => $x->twelve_year ? $x->twelve_year : 'Not Available',
                // 'Diploma Board' => $x->diploma_board ? $x->diploma_board : 'Not Available',
                // 'Diploma Field' => $x->diploma_field ? $x->diploma_field : 'Not Available',
                // 'Diploma Percentage' => $x->diploma_percentage ? $x->diploma_percentage : 'Not Available',
                // 'Diploma Year' => $x->diploma_year ? $x->diploma_year : 'Not Available',
                // 'Graduation' => $x->graduation ? $x->graduation : 'Not Available',
                // 'Graduation Mode' => $x->graduation_mode ? $x->graduation_mode : 'Not Available',
                // 'Graduation Percentage' => $x->graduation_percentage ? $x->graduation_percentage : 'Not Available',
                // 'Graduation Year' => $x->graduation_year ? $x->graduation_year : 'Not Available',
                // 'Post Graduation' => $x->post_graduation ? $x->post_graduation : 'Not Available',
                // 'Post Graduation Mode' => $x->post_graduation_mode ? $x->post_graduation_mode : 'Not Available',
                // 'Post Graduation Percentage' => $x->post_graduation_percentage ? $x->post_graduation_percentage : 'Not Available',
                // 'Post Graduation Year' => $x->post_graduation_year ? $x->post_graduation_year : 'Not Available',
                'Source' => $x->reference ? $x->reference : 'Not Available',
                'Added By' => $x->emp_email ? $x->emp_email : 'Not Available',
                'Date' => $x->created_at,
                ''
                // 'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                // 'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
            ];
        })->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
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
            ->orderBy('id', 'desc')
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
                'Designation' => $x->designation ? $x->designation : 'Not Available',
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
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
    //for Admin List Only
    public function showAdmin(Request $request)
    {
        $keyword = $request->keyword;
        $multikeyword = $request->multikeyword;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $source = $request->source;
        $addedby = $request->added_by;

        $location = $request->location;
        $skills = $request->skills;


        $data = Tracker::Join('sub_users', 'sub_users.id', 'trackers.added_by')
            ->join('all_users', 'all_users.id', 'trackers.employer_id')
            ->join('empcompaniesdetails', 'empcompaniesdetails.id', 'all_users.company_id')
            ->select('trackers.*', 'sub_users.fname', 'sub_users.lname', 'sub_users.email as emp_email', 'empcompaniesdetails.company_name')
            ->orderBy('id', 'desc');

        if (isset($source) && $source != '') {
            $data->Where('trackers.reference', $source);
        }
        if (isset($addedby) && $addedby != '') {
            $data->Where('added_by', $addedby);
        }

        if (isset($from_date) && $from_date != '') {
            $data->whereDate('trackers.created_at', '>=', $from_date);
        }

        if (isset($to_date) && $to_date != '') {
            $data->whereDate('trackers.created_at', '<=', $to_date);
        }

        if (isset($location) && $location != '') {
            $data->Where('trackers.current_location', 'like', "%$location%")
                ->orWhere('trackers.preffered_location', 'like', "%$location%");
        }

        if (isset($skills) && $skills != '') {
            $data->Where('trackers.key_skills', 'like', "%$skills%");
        }


        if (isset($keyword) && $keyword != '') {
            $data->Where('trackers.name', 'like', "%$keyword%")
                ->orWhere('trackers.email', 'like', "%$keyword%")
                ->orWhere('trackers.contact', 'like', "%$keyword%")
                ->orWhere('trackers.current_ctc', 'like', "%$keyword%")
                ->orWhere('trackers.expected_ctc', 'like', "%$keyword%")
                ->orWhere('trackers.designation', 'like', "%$keyword%")
                ->orWhere('trackers.current_location', 'like', "%$keyword%")
                ->orWhere('trackers.preffered_location', 'like', "%$keyword%")
                ->orWhere('trackers.key_skills', 'like', "%$keyword%")
                ->orWhere('trackers.experience', 'like', "%$keyword%");
        }
        if (isset($multikeyword) && $multikeyword != '') {
            $key = explode(',', $multikeyword);
            //type1
            $data->whereIn('trackers.name', $key)
                ->orwhereIn('trackers.email', $key)
                ->orwhereIn('trackers.contact', $key)
                ->orwhereIn('trackers.current_ctc', $key)
                ->orwhereIn('trackers.expected_ctc', $key)
                ->orwhereIn('trackers.designation', $key)
                ->orwhereIn('trackers.current_location', $key)
                ->orwhereIn('trackers.preffered_location', $key)
                ->orwhereIn('trackers.key_skills', $key)
                ->orwhereIn('trackers.experience', $key);
        }

        $data = $data->paginate(100);
        return response()->json(['data' => $data], 200);
    }
    public function getUniqueSource()
    {
        $data = Tracker::distinct()->pluck('reference');
        $dataUser = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->join('all_users', 'all_users.id', 'trackers.employer_id')
            ->join('empcompaniesdetails', 'empcompaniesdetails.id', 'all_users.company_id')
            ->select('trackers.added_by', 'sub_users.email', 'sub_users.fname', 'sub_users.lname', 'empcompaniesdetails.company_name')->distinct()->get();
        // $dataUser =Tracker::Join('sub_users','all_users.id','trackers.employer_id')->distinct()->pluck('all_users.email');

        return response()->json(['data' => $data, 'addedBy' => $dataUser]);
    }

    public function exportBulkData()
    {
        $today = date('d-m-Y');
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=tracker-export' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->select('trackers.*', 'sub_users.email as emp_email', 'sub_users.fname as emp_name')
            ->orderBy('id', 'desc')
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
                'Designation' => $x->designation ? $x->designation : 'Not Available',
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
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function ExportBulkCheckedData($id)
    {
        $today = date('d-m-Y');
        $ids = explode(',', $id);
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=tracker-export' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('trackers')
            ->join('sub_users', 'sub_users.id', '=', 'trackers.added_by')
            ->select('trackers.*', 'sub_users.email as emp_email', 'sub_users.fname as emp_name')
            ->orderBy('id', 'desc')
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
                'Designation' => $x->designation ? $x->designation : 'Not Available',
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
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function DeleteCheckedData($id)
    {
        $ids = explode(',', $id);

        $list = DB::table('trackers')
            ->whereIn('id', $ids)
            ->delete();
    }
    public function checkEmailTracker($email)
    {

        $companyId = Session::get('user')['company_id'];
        $data = Tracker::select('email')->where('email', $email)->where('company_id', $companyId)->first();
        //$res=sizeof($data)

        return response()->json([
            'data' => $data
        ], 200);
    }
    public function getsingleTrackerDetails($id)
    {
        $data = Tracker::Join('sub_users', 'sub_users.id', 'trackers.added_by')
            ->join('all_users', 'all_users.id', 'trackers.employer_id')
            ->join('empcompaniesdetails', 'empcompaniesdetails.id', 'all_users.company_id')
            ->select('trackers.*', 'sub_users.fname', 'sub_users.lname', 'sub_users.email as emp_email', 'empcompaniesdetails.company_name')
            ->where('trackers.id', $id)
            ->first();

        return response()->json(['data' => $data]);
    }
}
