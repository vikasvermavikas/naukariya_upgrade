<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Jobmanager;
use App\Models\ApplyJob;
use App\Models\JsResume;
use App\Models\Jobseeker;
use App\Models\Tag;
use App\Models\ResumeTag;
use App\Models\JsCertification;
use App\Models\JsSkill;
use App\Models\JsProfessionalDetail;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\SendMail;
use App\Jobs\ResumeViewBulkMailJob;

class viewresumeController extends Controller
{

    public function filterResume()
    {
        //$uid = Session::get('user')['id'];
        $orderBy = request('');
        $position = request('position');
        $experienceMin = request('min_exp');
        $experienceMax = request('max_exp');
        $from_salary = request('from_salary');
        $to_salary = request('to_salary');
        $current_location = request('current_location');
        $optional_keywords = request('optional_keywords');
        $mandate_keywords = request('mandate_keywords');
        $excluding_keywords =request('excluding_keywords');

        $designation = request('designation');
        $functionalrole = request('functionalrole');
        $industry = request('industry');
        $notice_period = request('notice_period');
        $profileUpdate = request('active_in');
        $resume_per_page = request('resume_per_page') ?  request('resume_per_page') :10;
        $gender = request('gender');
        
        
       
        // $profileUpdate = request('profile_update');
        // $keyword = request('keyword');
        // $gender = request('gender');
        // $salary = request('salary');
        // $location = request('location');
        // $functionalArea = request('functional_area');
        // $industry = request('industry');
        
        
       
        $today = Carbon::today();

        $dataFilter = DB::table('jobseekers')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.lname','jobseekers.email','jobseekers.contact','jobseekers.designation', 'jobseekers.preferred_location','jobseekers.current_working_location', 
            'jobseekers.gender', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.expected_salary','jobseekers.current_salary', 'js_resumes.resume','jobseekers.profile_pic_thumb', 
            'jobseekers.last_modified','jobseekers.last_login','jobseekers.functionalrole_id','jobseekers.notice_period','jobseekers.industry_id',
            'js_resumes.resume_video_link', 'js_resumes.resume_video_link');

            if (isset($position) && $position !== null) {
                $dataFilter->where('jobseekers.designation', $position);
            }
            if (isset($experienceMin) && $experienceMin !== null) {
                $dataFilter->where('jobseekers.exp_year', '>=', $experienceMin);
            }
            if (isset($experienceMax) && $experienceMax !== null) {
                $dataFilter->where('jobseekers.exp_year', '<=', $experienceMax);
            }
            if (isset($from_salary) && $from_salary !== null) {
                $dataFilter->where('jobseekers.current_salary', '>=', $from_salary);
            }
            if (isset($to_salary) && $to_salary !== null) {
                $dataFilter->where('jobseekers.current_salary', '<=', $to_salary);
            }
            if (isset($current_location) && $current_location !== null) {
                $dataFilter->where('jobseekers.current_working_location',$current_location);
            }
            if (isset($gender) && $gender !== null) {
                $dataFilter->where('jobseekers.gender',$gender);
            }
            

            
            
        if (isset($optional_keywords) && $optional_keywords !== '') {
            $dataFilter->where(function ($query) use ($optional_keywords) {
                $query->where('jobseekers.fname', 'like', "%" .$optional_keywords. "%")
                    ->orWhere('jobseekers.lname', 'like', "%" .$optional_keywords. "%")
                    ->orWhere('jobseekers.designation', 'like', "%" .$optional_keywords. "%")
                    ->orWhere('jobseekers.preferred_location', 'like', "%" .$optional_keywords. "%")
                    ->orWhere('jobseekers.email', 'like', "%" .$optional_keywords. "%")
                    ->orWhere('jobseekers.contact', 'like', "%" .$optional_keywords. "%");
            });
        }

        if (isset($mandate_keywords) && $mandate_keywords !== '') {
            $dataFilter->where(function ($query) use ($mandate_keywords) {
                $query->where('jobseekers.fname', 'like', "%".$mandate_keywords."%")
                    ->where('jobseekers.lname', 'like', "%".$mandate_keywords."%")
                    ->where('jobseekers.designation', 'like', "%".$mandate_keywords."%")
                    ->where('jobseekers.preferred_location', 'like', "%".$mandate_keywords."%")
                    ->where('jobseekers.email', 'like', "%".$mandate_keywords."%")
                    ->where('jobseekers.contact', 'like', "%".$mandate_keywords."%");
            });
        }
        if (isset($excluding_keywords) && $excluding_keywords !== '') {
            $dataFilter->where(function ($query) use ($excluding_keywords) {
                $query->WhereNotIn('jobseekers.fname', 'like', "%".$excluding_keywords."%")
                    ->WhereNotIn('jobseekers.lname', 'like', "%".$excluding_keywords."%")
                    ->WhereNotIn('jobseekers.designation', 'like', "%".$excluding_keywords."%")
                    ->WhereNotIn('jobseekers.preferred_location', 'like', "%".$excluding_keywords."%")
                    ->WhereNotIn('jobseekers.email', 'like', "%".$excluding_keywords."%")
                    ->WhereNotIn('jobseekers.contact', 'like', "%".$excluding_keywords."%");
            });
        }

        if (isset($designation) && $designation !== null) {
            $dataFilter->where('jobseekers.designation', $designation);
        }
        if (isset($functionalrole) && $functionalrole !== null) {
            $dataFilter->where('jobseekers.functionalrole_id', $functionalrole);
        }
        if (isset($functionalrole) && $functionalrole !== null) {
            $dataFilter->where('jobseekers.functionalrole_id', $functionalrole);
        }
        if (isset($industry) && $industry !== null) {
            $dataFilter->where('jobseekers.industry_id', $industry);
        }
        if (isset($notice_period) && $notice_period !== null) {
            $dataFilter->where('jobseekers.notice_period', $notice_period);
        }
        if (isset($profileUpdate) && $profileUpdate !== null) {
            $dataFilter->where('jobseekers.last_login', '>', $today->subDay($profileUpdate));
        }


        
        $data = $dataFilter->paginate($resume_per_page);

        return response()->json(['data' => $data], 200);
    }
   

    public function index()
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('jobseekers')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.designation', 'jobseekers.preferred_location', 'jobseekers.gender', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.expected_salary', 'functional_roles.subcategory_name', 'industries.category_name', 'js_resumes.resume', 'js_resumes.resume_video_link', 'js_resumes.resume_video_link')
            ->get();


        return response()->json(['data' => $data], 200);
    }

    public function exportResumes($ids)
    {
        $ids = explode(',', $ids);

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=user-export.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('jobseekers')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.designation', 'jobseekers.preferred_location', 'jobseekers.gender', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.expected_salary', 'functional_roles.subcategory_name', 'industries.category_name', 'js_resumes.resume', 'js_resumes.resume_video_link')
            ->whereIn('jobseekers.id', $ids)
            ->get();

        $list = collect($list)->map(function ($x) {
            return [
                'Name' => $x->fname . ' ' . $x->lname,
                'Gender' => $x->gender,
                'Designation' => $x->designation,
                'Experience' => $x->exp_year,
                'Preferred Location' => $x->preferred_location,
                'Expected Salary' => $x->expected_salary,
                'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                'Video Resume' => $x->resume_video_link ? 'https://www.youtube.com/watch?v=' . $x->resume_video_link : 'Not Available'
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

    public function getresume(Request $request, $keyword, $gender, $designation, $location, $industry, $functionalrole, $experience, $salary, $profile_update)
    {
        //        $name = request('name');
        //        $gender = request('gender');
        //        $salary = request('salary');
        //        $location = request('location');
        //        $functionalArea = request('functional_area');
        //        $industry = request('industry');
        //        $experienceYear = request('experience_year');
        //        $profileUpdate = request('profile_update');
        //        $designation = request('designation');

        //        $dataFilter = DB::table('jobseekers')
        //            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
        //            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
        //            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
        //            ->select('jobseekers.id as js_id','jobseekers.fname','jobseekers.designation','jobseekers.preferred_location','jobseekers.gender','jobseekers.industry_id','jobseekers.functionalrole_id','jobseekers.exp_year','jobseekers.expected_salary','functional_roles.subcategory_name','industries.category_name','js_resumes.resume');
        //
        //        if (request()->has('name')) {
        //            $dataFilter->where(function($q) use ($name) {
        //                $q->where('jobseekers.fname', 'LIKE', '%' . $name . '%')
        //                    ->orWhere('jobseekers.fname', 'LIKE', '%' . $name . '%');
        //            });
        //        }
        //        if (request()->has('gender')) {
        //            $dataFilter->where(function($q) use ($gender) {
        //                $q->orWhere('jobseekers.gender', $gender);
        //            });
        //        }
        //        if (request()->has('salary')) {
        //            $dataFilter->where(function($q) use ($salary) {
        //                $q->orWhere('jobseekers.expected_salary', $salary);
        //            });
        //        }
        //        if (request()->has('location')) {
        //            $dataFilter->where(function($q) use ($location) {
        //                $q->orWhere('jobseekers.preferred_location', $location);
        //            });
        //        }
        //        if (request()->has('industry')) {
        //            $dataFilter->where(function($q) use ($industry) {
        //                $q->orWhere('jobseekers.industry_id', $industry);
        //            });
        //        }
        //        if (request()->has('functional_area')) {
        //            $dataFilter->where(function($q) use ($functionalArea) {
        //                $q->orWhere('jobseekers.functionalrole_id', $functionalArea);
        //            });
        //        }
        //        if (request()->has('experience_year')) {
        //            $dataFilter->where(function($q) use ($experienceYear) {
        //                $q->orWhere('jobseekers.exp_year', '=', $experienceYear);
        //            });
        //        }
        //        if (request()->has('profile_update')) {
        //            $dataFilter->orWhere('jobseekers.updated_at', '>', now()->subDays($profileUpdate));
        //        }
        //        if (request()->has('designation')) {
        //            $dataFilter->where(function($q) use ($designation) {
        //                $q->orWhere('jobseekers.designation', $designation);
        //            });
        //        }
        //        $data = $dataFilter->get();

        $today = Carbon::today();

        $data = DB::table('jobseekers')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.designation', 'jobseekers.preferred_location', 'jobseekers.gender', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.expected_salary', 'functional_roles.subcategory_name', 'industries.category_name', 'js_resumes.resume', 'js_resumes.resume_video_link')
            ->orWhere('jobseekers.fname', 'like', "%$keyword%")
            ->orWhere('jobseekers.gender', 'like', "%$keyword%")
            ->orWhere('jobseekers.designation', 'like', "%$keyword%")
            ->orWhere('jobseekers.preferred_location', 'like', "%$keyword%")
            ->orWhere('jobseekers.email', 'like', "%$keyword%")
            ->orWhere('jobseekers.contact', 'like', "%$keyword%")
            ->orWhere('jobseekers.gender', $gender)
            ->orWhere('jobseekers.designation', $designation)
            ->orWhere('jobseekers.updated_at', '>', $today->subDay($profile_update))
            ->orWhere('jobseekers.preferred_location', $location)
            ->orWhere('jobseekers.industry_id', $industry)
            ->orWhere('jobseekers.functionalrole_id', $functionalrole)
            ->orWhere('jobseekers.exp_year', '<=', $experience)
            ->orWhere('jobseekers.expected_salary', '<=', $salary)
            ->get();


        return response()->json(['data' => $data], 200);
    }

    public function gettag()
    {
        $data = Tag::all();
        return response()->json(['data' => $data], 200);
    }

    public function add_resume_tag(Request $request)
    {
        $tag_id = $request->tag_id;
        $uid = Session::get('user')['id'];
        $candidate_arr = $request->jobseeker_id;
        foreach ($candidate_arr as $key => $value) {
            $tagResumes[] = array(
                'user_id' => $uid,
                'tag_id' => $tag_id,
                'candidate_id' => $value
            );
        }

        foreach ($tagResumes as $resume) {
            $resumeTag = ResumeTag::create($resume);
        }

        if (!$resumeTag) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 406);
        }

        return response()->json(['status' => 'success', 'message' => 'Resume grouped in tag.'], 201);
    }

    public function add_new_tag(Request $request)
    {
        $tag = $request->tag;
        $uid = Session::get('user')['id'];
        $tg = new Tag();
        $tg->tag = $tag;
        $tg->user_id = $uid;
        $tagCreate = $tg->save();

        if (!$tagCreate) {
            return response()->json(['status' => 'error', 'message' => 'Tag Not Created'], 406);
        }

        return response()->json(['status' => 'success', 'message' => 'Tag Created'], 201);
    }

    public function tagresume()
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('resume_tags')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'resume_tags.candidate_id')
            ->leftjoin('jobseekers', 'jobseekers.id', '=', 'resume_tags.candidate_id')
            ->leftjoin('tags', 'tags.id', '=', 'resume_tags.tag_id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.designation', 'js_resumes.resume_video_link', 'jobseekers.preferred_location', 'jobseekers.gender', 'js_resumes.resume', 'tags.tag')
            ->where('resume_tags.user_id', $uid)
            ->get();

        // If you want to group by tags then enable this query.
        //        $data = DB::table('resume_tags')
        //                ->join('tags', 'tags.id', '=', 'resume_tags.tag_id')
        //                ->select('tags.id', 'tags.tag', DB::raw('COUNT(*) AS total'))
        //                ->where('resume_tags.user_id', $uid)
        //                ->groupBy('tags.id', 'tags.tag')
        //                ->get();

        return response()->json(['data' => $data], 200);
    }

    public function searchtagresume($tagid)
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('resume_tags')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'resume_tags.candidate_id')
            ->leftjoin('jobseekers', 'jobseekers.id', '=', 'resume_tags.candidate_id')
            ->leftjoin('tags', 'tags.id', '=', 'resume_tags.tag_id')
            ->select('jobseekers.id as js_id', 'jobseekers.fname', 'jobseekers.designation', 'jobseekers.preferred_location', 'js_resumes.resume_video_link', 'jobseekers.gender', 'js_resumes.resume', 'tags.tag')
            ->where('resume_tags.user_id', $uid)
            ->where('resume_tags.tag_id', $tagid)
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function send_mail($msg, $candidate)
    {
        $from = Session::get('user')['email'];
        $candidate_arr = explode(",", $candidate);
        array_shift($candidate_arr);
        foreach ($candidate_arr as $key => $value) {
            $data = Jobseeker::select('fname', 'email')->where('id', $value)->first();
            $to = $data->email;
            $name = $data->fname;
            if ($to) {
                Mail::to($to)->send(new SendMail($name, $msg));
            }
        }
    }
    //for employer see candidate details  
    public function getJsInfo($jsid)
    {

        $jsInfo = DB::table('jobseekers')
            ->leftjoin('js_educational_details', 'js_educational_details.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_professional_details', 'js_professional_details.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_certifications', 'js_certifications.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_social_links', 'js_social_links.js_userid', '=', 'jobseekers.id')
            ->leftjoin('qualifications', 'qualifications.id', '=', 'js_educational_details.education')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'js_professional_details.functional_role')
            ->select(
                'jobseekers.*',
                'js_educational_details.*',
                'js_professional_details.*',
                'js_resumes.resume',
                'js_resumes.resume_video_link',
                'js_resumes.linkedin_resume_link',
                'js_resumes.updated_at as resume_upload_date',
                'js_certifications.*',
                'js_social_links.*',
                'qualifications.*',
                'functional_roles.*'
            )
            ->where('jobseekers.id', $jsid)
            ->first();

        return response()->json(['jsInfo' => $jsInfo], 200);
    }
    public function getCertificateInfo($jsid)
    {
        $userCertInfo = JsCertification::where('js_userid', $jsid)->get();

        return response()->json(['userCertInfo' => $userCertInfo], 200);
    }
    public function getSkillInfo($jsid)
    {
        $skills = JsSkill::where('js_userid', $jsid)->get();

        return response()->json(['data' => $skills, 'status' => 'success'], 200);
    }
    public function getEducationInfo($jsid)
    {
        $educationalDetails = DB::table('js_educational_details')
            ->leftjoin('qualifications', 'qualifications.id', 'js_educational_details.education')
            ->select('qualifications.id', 'qualifications.qualification', 'js_educational_details.*')
            ->where('js_educational_details.js_userid', $jsid)
            ->get();
        return response()->json(['educationalDetails' => $educationalDetails], 200);
    }
    public function getProffesionalInfo($jsid)
    {
        $userProfessionalDetails = DB::table('js_professional_details')
            ->leftjoin('job_shifts', 'job_shifts.id', 'js_professional_details.job_shift')
            ->leftjoin('job_types', 'job_types.id', 'js_professional_details.job_type')
            ->leftjoin('industries', 'industries.id', 'js_professional_details.industry_name')
            ->leftjoin('functional_roles', 'functional_roles.id', 'js_professional_details.functional_role')
            ->select('js_professional_details.id', 'js_professional_details.responsibility', 'js_professional_details.designations', 'js_professional_details.from_date', 'js_professional_details.to_date', 'js_professional_details.organisation', 'job_shifts.job_shift', 'job_types.job_type', 'industries.category_name as industry_name', 'functional_roles.subcategory_name as functional_role')
            ->where('js_professional_details.js_userid', $jsid)
            ->get();

        return response()->json(['data' => $userProfessionalDetails], 200);
    }
    public function ResumeViewSendMail(Request $request)
    {
        $description = $request->params['description'];
        //$from = $request->params['empEmail'];
        $subject = $request->params['subject'];
        $jobseeker_id = $request->params['jobseeker_id'];
        $candidate_arr = implode(",",$jobseeker_id);
        //array_shift($candidate_arr);
        $cand=explode(",",$candidate_arr);
        
        foreach ((array) $cand as $key => $value) {
            $data = Jobseeker::select('fname', 'email')->where('id', $value)->first();
             $to = $data->email;
            $name = $data->fname;
            
            if ($to) {
                Mail::to($to)->send(new SendMail($name,$description,$subject));
              // return $to;
            //   for queue job setup install supervisor to start
              //ResumeViewBulkMailJob::dispatch($to,$name,$description,$subject)->delay(now()->addSeconds(10));
                
            }
        }
        
    }
    
   
}
