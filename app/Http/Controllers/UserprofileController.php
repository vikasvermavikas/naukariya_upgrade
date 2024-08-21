<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Jobseeker;
use App\Models\Qualification;
use App\Models\JsEducationalDetail;
use App\Models\JsProfessionalDetail;
use App\Models\JsResume;
use App\Models\JsCertification;
use App\Models\JsSocialLinks;
use App\Models\JsSkill;
use App\Models\JobType;
use App\Models\JobShift;
use App\Models\Industry;
use App\Models\AllUser;
use App\Models\Jobmanager;
use App\Models\Follower;
use App\Models\FunctionalRole;
use App\Models\Empcompaniesdetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File as FileValidator;

class UserprofileController extends Controller
{

    public function jobseeker()
    {
        $data = Session::get('user');
        return response()->json(['data' => $data], 200);
    }

    public function check_user()
    {
        $data = Session::get('user');
        if ($data == "") {
            $data = ['user_type' => 'guest'];
        }
        return response()->json(['data' => $data], 200);
    }

    public function get_blade_sessionuser()
    {
        $data = Session::get('user');
        return response()->json(['blade_data' => $data], 200);
    }

    public function logout()
    {
        if (Auth::guard('jobseeker')->check()) {
            Auth::guard('jobseeker')->logout();
        }
        if (Auth::guard('employer')->check()) {
            Auth::guard('employer')->logout();
        }
      
        Session::flush();

        return redirect()->route('home');
    }

    public function count_job()
    {
        $id = Session::get('user')['id'];
        $count = Jobmanager::where('userid', $id)->count();
        return response()->json(['data' => $count], 200);
    }

    public function count_active_job()
    {
        $id = Session::get('user')['id'];
        $count = Jobmanager::where('userid', $id)->where('status', 'Active')->count();
        return response()->json(['data' => $count], 200);
    }

    public function count_followers()
    {
        $id = Session::get('user')['company_id'];
        $count = Follower::where('employer_id', $id)->where('status', '1')->count();
        return response()->json(['data' => $count], 200);
    }

    public function qualification()
    {
        $data = Qualification::All();
        return response()->json(['data' => $data], 200);
    }

    public function jobtype()
    {
        $data = JobType::All();
        return response()->json(['data' => $data], 200);
    }

    public function jobshift()
    {
        $data = JobShift::All();
        return response()->json(['data' => $data], 200);
    }

    public function industry()
    {
        $data = Industry::All();
        return response()->json(['data' => $data], 200);
    }

    public function functionalrole()
    {
        $data = FunctionalRole::All();
        return response()->json(['data' => $data], 200);
    }
    public function update_personal_detail(Request $request)
    {

        $this->validate(
            $request,
            [
                'fname'    => 'required',
                'lname'    => 'required',
                'email'    => 'required',
                'contact'    => 'required',
                'dob'    => 'required',
                'gender'    => 'required',
                'candidate_type'    => 'required',
                'preferred_location'    => 'required',
            ],
            [
                'fname.required' => 'First Name is Required',
                'lname.required' => 'Last Name is Required',
                'email.required' => 'Email is required',
                'contact.required' => 'Contact Number is required',
                'dob.required' => 'Date of Birth is Required',
                'gender.required' => 'Gender is Required',
                'candidate_type.required' => 'Select Fresher or Experienced ?',
                'preferred_location.required' => 'Preferred Location is Required'
            ]
        );
        $id = Session::get('user')['id'];
        $js = Jobseeker::find($id);


        if ($request->password != NULL &&  strlen($request->password) < 15) {
            $password = Hash::make($request->password);
        } else {
            $password =  $js->password;
        }


        // if ($request->pic && $request->pic != null) {
        //     $strpos = strpos($request->pic, ';');
        //     $sub = substr($request->pic, 0, $strpos);
        //     $ex = explode('/', $sub)[1];
        //     $name = time() . "." . $ex;
        //     $img = Image::make($request->pic)->resize(200, 200);
        //     $upload_path = public_path() . "/jobseeker_profile_image/";
        //     $img->save($upload_path . $name);
        // }

        //save in jobseeker table
        $js->fname = $request->fname;
        $js->lname = $request->lname;
        $js->email = $request->email;
        $js->contact = $request->contact;
        $js->dob = $request->dob;
        $js->gender = $request->gender;
        $js->address = $request->address;
        $js->preferred_location = $request->preferred_location;
        $js->candidate_type = $request->candidate_type;
        $js->password = $password;
        $js->last_modified = Carbon::now();


        $js->save();
        $resumeData = [
            'js_userid' => $id,
            'resume_video_link' => $request->resume_video_link,
            'linkedin_resume_link' => $request->linkedin_resume_link
        ];

        $resume = JsResume::UpdateOrCreate(['js_userid' => $id], $resumeData);
    }





    public function saveEducationalDetail(Request $request)
    {
        $this->validate($request, []);
        $uid = Session::get('user')['id'];

        $js_education = new JsEducationalDetail();
        $js_education->js_userid = $uid;
        $js_education->education = $request->education;
        $js_education->degree_name = $request->degree_name;
        $js_education->percentage_grade = $request->percentage_grade;
        $js_education->institute_name = $request->institute_name;
        $js_education->passing_year = $request->passing_year;
        $js_education->institute_location = $request->institute_location;
        $js_education->save();

        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
    }

    public function update_qualification_detail(Request $request, $id)
    {
        $js_education = JsEducationalDetail::find($id);
        $js_education->education = $request->education;
        $js_education->degree_name = $request->degree_name;
        $js_education->percentage_grade = $request->percentage_grade;
        $js_education->institute_name = $request->institute_name;
        $js_education->passing_year = $request->passing_year;
        $js_education->save();

        $uid = Session::get('user')['id'];
        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
    }

    public function getProfessionalDetail()
    {
        $uid = Session::get('user')['id'];
        $userProfessionalDetails = DB::table('js_professional_details')
            ->leftjoin('job_shifts', 'job_shifts.id', 'js_professional_details.job_shift')
            ->leftjoin('job_types', 'job_types.id', 'js_professional_details.job_type')
            ->leftjoin('industries', 'industries.id', 'js_professional_details.industry_name')
            ->leftjoin('functional_roles', 'functional_roles.id', 'js_professional_details.functional_role')
            ->select('js_professional_details.id', 'js_professional_details.responsibility', 'js_professional_details.designations', 'js_professional_details.from_date', 'js_professional_details.to_date', 'js_professional_details.organisation', 'job_shifts.job_shift', 'job_types.job_type', 'industries.category_name as industry_name', 'functional_roles.subcategory_name as functional_role')
            ->where('js_professional_details.js_userid', $uid)
            ->get();

        return response()->json(['data' => $userProfessionalDetails], 200);
    }

    public function editProfessionalDetail($id)
    {
        $uid = Session::get('user')['id'];
        $userProfessionalDetails = DB::table('js_professional_details')
            ->leftjoin('job_shifts', 'job_shifts.id', 'js_professional_details.job_shift')
            ->leftjoin('job_types', 'job_types.id', 'js_professional_details.job_type')
            ->leftjoin('industries', 'industries.id', 'js_professional_details.industry_name')
            ->leftjoin('functional_roles', 'functional_roles.id', 'js_professional_details.functional_role')
            ->select('js_professional_details.id', 'js_professional_details.responsibility', 'js_professional_details.designations', 'js_professional_details.from_date', 'js_professional_details.to_date', 'js_professional_details.organisation', 'job_shifts.job_shift', 'job_types.job_type', 'industries.category_name as industry_name', 'functional_roles.subcategory_name as functional_role')
            ->where('js_professional_details.js_userid', $uid)
            ->where('js_professional_details.id', $id)
            ->first();

        return response()->json(['data' => $userProfessionalDetails], 200);
    }

    public function addProfessionalDetail(Request $request)
    {
        $uid = Session::get('user')['id'];
        $js_professional = new JsProfessionalDetail();
        $js_professional->js_userid = $uid;
        $js_professional->designations = $request->designations;
        $js_professional->organisation = $request->organisation;
        $js_professional->job_type = $request->job_type;
        $js_professional->job_shift = $request->job_shift;
        $js_professional->industry_name = $request->industry_name;
        $js_professional->functional_role = $request->functional_role;
        $js_professional->from_date = $request->from_date;
        $js_professional->to_date = $request->to_date;
        $js_professional->responsibility = $request->responsibility;
        $js_professional->save();

        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
    }

    public function update_professional_detail(Request $request)
    {
        $id = $request->professionalInfo['id'];
        $designation = $request->professionalInfo['designation'];
        $organization = $request->professionalInfo['organisation'];
        $jobType = $request->professionalInfo['job_type'];
        $jonShift = $request->professionalInfo['job_shift'];
        $industryName = $request->professionalInfo['industry_name'];
        $functionalRole = $request->professionalInfo['functional_role'];
        $formDate = $request->professionalInfo['from_date'];
        $toDate = $request->professionalInfo['to_date'];
        $responsibility = $request->professionalInfo['responsibility'];

        $professional = JsProfessionalDetail::where('id', $id)->update([
            'designations' => $designation,
            'organisation' => $organization,
            'job_type' => $jobType,
            'job_shift' => $jonShift,
            'industry_name' => $industryName,
            'functional_role' => $functionalRole,
            'from_date' => $formDate,
            'to_date' => $toDate,
            'responsibility' => $responsibility
        ]);

        $uid = Session::get('user')['id'];
        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();

        if ($professional) {
            return response()->json(['success' => 'Professional Detail Updated Successfully'], 200);
        } else {
            return response()->json(['error' => 'Somethings went wrong.']);
        }
    }

    public function deleteProfessionalDetail($id)
    {
        $uid = Session::get('user')['id'];
        $professionalDetail = JsProfessionalDetail::find($id);
        $professionalDetail->delete($uid);

        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();

        if (!$professionalDetail) {
            return response()->json(['error' => 'Professional Detail not Deleted']);
        }

        return response()->json(['success' => 'Professional Detail Deleted Successfully']);
    }

    public function update_certification_detail(Request $request)
    {

        $uid = Session::get('user')['id'];
        $js_certificate = new JsCertification();
        $js_certificate->js_userid = $uid;
        $js_certificate->course = $request->course;
        $js_certificate->certificate_institute_name = $request->certificate_institute_name;
        $js_certificate->cert_from_date = $request->cert_from_date;
        $js_certificate->cert_to_date = $request->cert_to_date;
        $js_certificate->grade = $request->grade;
        $js_certificate->certification_type = $request->certification_type;
        $js_certificate->description = $request->description;
        $js_certificate->save();


        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
    }

    public function update_sociallinks_detail(Request $request)
    {
        $uid = Session::get('user')['id'];
        $res = JsSocialLinks::select('js_userid')->where('js_userid', $uid)->count();
        if ($res <= 0) {
            $js_social = new JsSocialLinks();
            $js_social->js_userid = $uid;
            $js_social->facebook_link = $request->facebook_link;
            $js_social->linkedin_link = $request->linkedin_link;
            $js_social->google_plus_link = $request->google_plus_link;
            $js_social->twitter_link = $request->twitter_link;
            $js_social->github_link = $request->github_link;
            $js_social->blog_link = $request->blog_link;
            $js_social->save();

            $uid = Session::get('user')['id'];
            $updateLastModifiedDate = Jobseeker::find($uid);
            $updateLastModifiedDate->last_modified = Carbon::now();
            $updateLastModifiedDate->save();
        } else {
            $res2 = JsSocialLinks::select('id')->where('js_userid', $uid)->first();
            $id = $res2->id;
            $js_social = JsSocialLinks::find($id);
            $js_social->facebook_link = $request->facebook_link;
            $js_social->linkedin_link = $request->linkedin_link;
            $js_social->google_plus_link = $request->google_plus_link;
            $js_social->twitter_link = $request->twitter_link;
            $js_social->github_link = $request->github_link;
            $js_social->blog_link = $request->blog_link;
            $js_social->save();

            $uid = Session::get('user')['id'];
            $updateLastModifiedDate = Jobseeker::find($uid);
            $updateLastModifiedDate->last_modified = Carbon::now();
            $updateLastModifiedDate->save();
        }
    }


    public function update_resume_detail(Request $request)
    {
        $this->validate($request, [
            'resume'    => 'required',

        ]);
        $uid = Session::get('user')['id'];
        $res = JsResume::select('js_userid')->where('js_userid', $uid)->count();

        if ($res <= 0) {
            $data = $request->resume;
            $explode = explode(',', $data);
            $ex = explode('/', $data)[1];
            $extension = explode(';', $ex)[0];
            $valid_extention = ['pdf'];
            if (in_array($extension, $valid_extention)) {
                $data = base64_decode($explode[1]);
                $filename = rand(10000000, 999999999) . "." . $extension;
                $url = public_path() . '/resume/' . $filename;
                file_put_contents($url, $data);
            } else {
                return response()->json(['error' => 'please upload pdf file']);
            }

            $js_resume = new JsResume();

            if (isset($request->resume_video_link) && $request->resume_video_link != '') {
                $url = $request->resume_video_link;
                $get_url = parse_url($url);
                $youtube_res_link = parse_str($get_url['query'], $params);
                $video_link = $params['v'];
            } else {
                $video_link = null;
            }

            $js_resume->js_userid = $uid;
            $js_resume->resume = $filename;
            $js_resume->resume_video_link = $video_link;
            $js_resume->cover_letter = $request->cover_letter;
            $js_resume->linkedin_resume_link = $request->linkedin_resume_link;
            $js_resume->save();
        } else {
            $res2 = JsResume::select('id')->where('js_userid', $uid)->first();
            $id = $res2->id;
            $js_resume = JsResume::find($id);
            if ($request->resume != $js_resume->resume) {
                $data = $request->resume;
                $explode = explode(',', $data);
                $ex = explode('/', $data)[1];
                $extension = explode(';', $ex)[0];
                $valid_extention = ['pdf'];
                if (in_array($extension, $valid_extention)) {
                    $data = base64_decode($explode[1]);
                    $filename = rand(10000000, 999999999) . "." . $extension;
                    $url = public_path() . '/resume/' . $filename;
                    file_put_contents($url, $data);
                } else {
                    return response()->json(['error' => 'please upload pdf file']);
                }
            } else {
                $filename = $js_resume->resume;
            }

            if (isset($request->resume_video_link) && $request->resume_video_link != '') {
                $url = $request->resume_video_link;
                $get_url = parse_url($url);
                $youtube_res_link = parse_str($get_url['query'], $params);
                $video_link = $params['v'];
            } else {
                $video_link = null;
            }

            $js_resume->resume = $filename;
            $js_resume->resume_video_link = $video_link;
            $js_resume->cover_letter = $request->cover_letter;
            $js_resume->linkedin_resume_link = $request->linkedin_resume_link;
            $js_resume->save();
        }
    }

    public function jobseeker_profile()
    {
        // $id = Session::get('user')['id'];
        $id = Auth::guard('jobseeker')->user()->id;

        $data = DB::table('jobseekers')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->select(
                'jobseekers.*',
                // 'js_educational_details.*',
                // 'js_professional_details.*',
                // 'js_certifications.*',
                // 'js_social_links.*',
                // 'qualifications.*',
                // 'functional_roles.*',
                // 'js_resumes.js_userid',
                // 'js_resumes.resume',
                'js_resumes.resume',
                // 'js_resumes.resume_video_link',
                // 'js_resumes.linkedin_resume_link',
                // 'js_resumes.cover_letter',
                // 'js_resumes.updated_at as resume_upload_date'
            )
            ->where('jobseekers.id', $id)
            ->first();

        // if ($data->resume_video_link) {
        //     $old_link = $data->resume_video_link;
        //     $new_link = "https://www.youtube.com/watch?v=" . $old_link;
        //     $data->resume_video_link = $new_link;
        // }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        
        // die();
        // return response()->json(['data' => $data], 200);
        $professionalDetails = JsProfessionalDetail::where('js_userid', $id)->get();

        return view('jobseeker.myProfile', ['alldata' => $data, 'professionalDetails' => $professionalDetails]);
    }

    public function getResumeLink()
    {
        $id = Session::get('user')['id'];
        $resume = JsResume::select('id', 'resume_video_link')->where('js_userid', $id)->first();
        return response()->json(['data' => $resume], 200);
    }


    public function employer_profile()
    {
        $id = Session::get('user')['id'];

        $data = DB::table('all_users')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select(
                'all_users.*',
                'empcompaniesdetails.company_name',
                'empcompaniesdetails.company_logo',
                'empcompaniesdetails.cover_image',
                'empcompaniesdetails.company_state as state',
                'empcompaniesdetails.company_city as city',
                'empcompaniesdetails.company_industry as com_industry',
                'empcompaniesdetails.owner_name as owner_name',
                'empcompaniesdetails.com_email as com_email',
                'empcompaniesdetails.com_contact as com_contact',
                'empcompaniesdetails.website as website',
                'empcompaniesdetails.tagline as tagline',
                'empcompaniesdetails.no_of_employee as employee_no',
                'empcompaniesdetails.company_capital as revenue',
                'empcompaniesdetails.cin_no as cin_no',
                'empcompaniesdetails.about as com_summary',
                'empcompaniesdetails.address as address',
                'empcompaniesdetails.establish_date as established_year',
                'empcompaniesdetails.facebook_url as com_facebook',
                'empcompaniesdetails.twitter_url as com_twitter',
                'empcompaniesdetails.linkedin_url as com_linkedin',
                'empcompaniesdetails.additional as additional',
                'empcompaniesdetails.company_country as country',
                'empcompaniesdetails.company_video'
            )
            ->where('all_users.id', $id)
            ->first();

        return response()->json(['data' => $data], 200);
    }

    public function update_employer_personaldetail(Request $request)
    {
        $uid = Auth::guard('employer')->user()->id;

        $this->validate(
            $request,
            [
                'fname'    => 'required|alpha:ascii',
                'lname'    => 'required|alpha:ascii',
                'email'    => ['required', 'email', Rule::unique('all_users')->ignore($uid)],
                'contact'  => 'required|numeric|min:10',
                'gender'   => 'required',
                'aadhar_no' => 'required|numeric|min:12',
                'designation' => 'required|alpha:ascii',
                'emp_image' => [FileValidator::image()
                    ->min('1kb')
                    ->max('1mb')
                    ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))]
            ],
            [
                'fname.required' => 'First name is required.',
                'fname.alpha' => 'First name should contain only alphabets.',
                'lname.required' => 'Last name is required.',
                'lname.alpha' => 'Last name should contain only alphabets.',
                'designation.alpha' => 'Designation should contain only alphabets.',

            ]

        );

        $employerDetail = AllUser::where('id', $uid)->first();

        // If user upload the image.

        if (isset($request->emp_image)) {

            // Get old image path.
            $old_res = Auth::guard('employer')->user()->profile_pic_thumb;

            $filename = time() . '.' . $request->emp_image->extension();
            $path = public_path() . "/emp_profile_image/";

            // Delete old image if exists.
            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            // Now move the image to destination.
            $request->emp_image->move($path, $filename);
            $employerDetail->profile_pic_thumb =  $filename;
        }


        $employerDetail->fname = request('fname');
        $employerDetail->lname = request('lname');
        $employerDetail->email = request('email');
        $employerDetail->contact = request('contact');
        $employerDetail->dob   = request('dob');
        $employerDetail->gender = request('gender');
        $employerDetail->aadhar_no = request('aadhar_no');
        $employerDetail->designation = request('designation');
        $employerDetail->industry_id = request('industry_id');
        $employerDetail->functionalrole_id = request('functionalrole_id');
        $employerDetail->facebook_url = request('facebook_url');
        $employerDetail->twitter_url = request('twitter_url');
        $employerDetail->linkedin_url = request('linkedin_url');
        $employerDetail->save();

        return redirect()->route('employer_edit_profile')->with(['success' => true, 'message' => 'Profile updated successfully.']);
    }

    public function EmployerProfileImageUpload(Request $request)
    {
        $id = Session::get('user')['id'];
        $tracker = AllUser::find($id);
        $old_res = $tracker->profile_pic_thumb;
        if (isset($request->emp_image)) {
            $filename = time() . '.' . $request->emp_image->extension();

            $path = public_path() . "/emp_profile_image/";
            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            AllUser::where('id', $id)->update(['profile_pic_thumb' => $filename]);


            $upload = $request->emp_image->move($path, $filename);
        }
    }
    public function EmployerLogoUpload(Request $request)
    {
        $id = Session::get('user')['id'];
        $com_id = Session::get('user')['company_id'];
        $res = Empcompaniesdetail::find($com_id);
        $old_res = $res->company_logo;

        if (isset($request->emp_logo)) {
            $filename = time() . '.' . $request->emp_logo->extension();

            $path = public_path() . "/company_logo/";

            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            Empcompaniesdetail::where('emp_userid', $id)->update(['company_logo' => $filename]);


            $upload = $request->emp_logo->move($path, $filename);
        }
    }
    public function EmployerBannerUpload(Request $request)
    {
        $id = Session::get('user')['id'];
        $com_id = Session::get('user')['company_id'];
        $res = Empcompaniesdetail::find($com_id);
        $old_res = $res->cover_image;

        if (isset($request->emp_banner)) {
            $filename = time() . '.' . $request->emp_banner->extension();

            $path = public_path() . "/company_cover/";

            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            Empcompaniesdetail::where('emp_userid', $id)->update(['cover_image' => $filename]);


            $upload = $request->emp_banner->move($path, $filename);
        }
    }

    public function update_employer_companydetail(Request $request)
    {

        $this->validate(
            $request,
            [
                'emp_logo' => [FileValidator::image()
                    ->min('1kb')
                    ->max('1mb')
                    ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))],
                'emp_banner' => [FileValidator::image()
                    ->min('1kb')
                    ->max('1mb')],
                'company_name'    => 'required|string',
                'com_industry'    => 'required',
                'owner_name'    => 'required|string',
                'tagline'    => 'required|string',
                'com_email'    => 'required|email',
                'com_contact'    => 'required|min:10|max:12',
                'established_year'    => 'required',
                'address'    => 'required',
                'employee_no'    => 'required',
                'website'    => 'required',
                'country'    => 'required',
                'state'    => 'required',
                'city'    => 'required',
                'cin_no'    => 'required',


            ], //custom message
            [
                // 'banner.mimes' => 'Only jpeg,jpg,png images are allowed',
                // 'banner.max' => 'Sorry! Maximum allowed size for an image is 1MB',
                'com_industry.required' => 'Company Industry Is required',
                'com_email.required' => 'Company Email Is required',
                'com_contact.required' => 'Company Landline number or Mobile number is required',

            ]
        );
        $uid = Auth::guard('employer')->user()->id;
        $com_id = Auth::guard('employer')->user()->company_id;
        $emp_personal = Empcompaniesdetail::find($com_id);

        // If user upload company logo.
        if ($request->emp_logo) {
            // Get old company logo.
            $old_res = $emp_personal->company_logo;

            $filename = time() . '.' . $request->emp_logo->extension();

            $path = public_path() . "/company_logo/";

            if (isset($old_res)) {
                File::delete($path . $old_res);
            }

            // Finally move the files.
            $request->emp_logo->move($path, $filename);
            $emp_personal->company_logo = $filename;
        }

        // If user upload company banner.
        if ($request->emp_banner) {
            $old_res = $emp_personal->cover_image;

            if (isset($request->emp_banner)) {
                $filename = time() . '.' . $request->emp_banner->extension();

                $path = public_path() . "/company_cover/";

                if (isset($old_res)) {
                    File::delete($path . $old_res);
                }

                // Finally move the files.
                $request->emp_banner->move($path, $filename);
                $emp_personal->cover_image = $filename;
            }
        }
        // $url = $request->company_video;
        // $get_url = parse_url($url);
        // $youtube = parse_str($get_url['query'], $params);
        //return $params['v'];
        $emp_personal->company_name = $request->company_name;
        $emp_personal->com_email = $request->com_email;
        $emp_personal->com_contact = $request->com_contact;
        $emp_personal->website = $request->website;
        $emp_personal->no_of_employee = $request->employee_no;
        $emp_personal->tagline = $request->tagline;
        $emp_personal->establish_date = $request->established_year;
        $emp_personal->address = $request->address;
        $emp_personal->company_country = $request->country;
        $emp_personal->company_state = $request->state;
        $emp_personal->company_city = $request->city;
        $emp_personal->company_industry = $request->com_industry;
        $emp_personal->company_capital = $request->revenue;
        $emp_personal->cin_no = $request->cin_no;
        $emp_personal->facebook_url = $request->com_facebook;
        $emp_personal->twitter_url = $request->com_twitter;
        $emp_personal->owner_name = $request->owner_name;
        $emp_personal->linkedin_url = $request->com_linkedin;
        $emp_personal->about = $request->com_summary;
        $emp_personal->additional = $request->additional;
        $emp_personal->company_video = $request->company_video;
        $emp_personal->emp_userid = $uid;
        $emp_personal->save();
        return redirect()->route('employer_edit_profile')->with(['success' => true, 'message' => 'Company Profile updated successfully.']);
    }


    public function jobpost_employerid(Request $request)
    {
        $id = Session::get('user')['id'];
        $data = DB::table('jobmanagers')
            ->leftjoin('all_users', 'all_users.id', '=', 'jobmanagers.userid')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('jobmanagers.*', 'empcompaniesdetails.company_name')
            ->where('jobmanagers.userid', $id)
            ->get();
        return response()->json(['data' => $data], 200);
    }


    public function update_skills_detail(Request $request)
    {
        $data = [];
        $request = $request->all();
        $uid = Session::get('user')['id'];

        foreach ($request as $key => $value) {
            foreach ($value as $d) {
                $data[] = [
                    'skill' => $d['skill'],
                    'expert_level' => $d['skill_level'],
                    'js_userid' => $uid
                ];
            }
        }

        $data = JsSkill::insert($data);


        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
        if ($data) {
            return response()->json(['success' => 'Skills Inserted'], 200);
        } else {
            return response()->json(['error' => 'Somethings went wrong. Please try again'], 201);
        }
    }

    public function getUserSkill()
    {
        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('jobseeker')->user()->id;
        $skills = JsSkill::select('skill')->where('js_userid', $uid)->get();
        return response()->json(['data' => $skills, 'status' => 'success'], 200);
    }

    public function deleteUserSkill($id)
    {
        $uid = Session::get('user')['id'];
        $skillInfo = JsSkill::find($id);
        $skillInfo->delete($uid);


        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
        if ($skillInfo) {
            return response()->json(['success' => 'Skill Deleted Successfully']);
        } else {
            return response()->json(['error' => 'Skill not Deleted']);
        }
    }

    public function editUserSkill($id)
    {
        $uid = Session::get('user')['id'];
        $userSkillInfo = JsSkill::select('id', 'js_userid', 'skill', 'expert_level')->where('id', $id)->where('js_userid', $uid)->first();
        return response()->json(['data' => $userSkillInfo], 200);
    }

    public function updateUserSkill(Request $request)
    {
        $id = $request->skillInfo['id'];
        $skill = $request->skillInfo['skill'];
        $expertLevel = $request->skillInfo['expert_level'];
        $skillInfo = JsSkill::where('id', $id)->update(['skill' => $skill, 'expert_level' => $expertLevel]);

        $uid = Session::get('user')['id'];
        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();

        if ($skillInfo) {
            return response()->json(['success' => 'Skill Information Updated Successfully']);
        } else {
            return response()->json(['error' => 'Somethings went wrong.']);
        }
    }

    public function getUserCertInfo()
    {
        $uid = Session::get('user')['id'];
        $userCertInfo = JsCertification::where('js_userid', $uid)->get();

        return response()->json(['userCertInfo' => $userCertInfo], 200);
    }

    public function deleteUserCertInfo($id)
    {
        $uid = Session::get('user')['id'];
        $delUserCertInfo = JsCertification::where('js_userid', $uid)->where('id', $id)->delete();


        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
        if ($delUserCertInfo) {
            return response()->json(['status' => 'Success'], 200);
        }

        return response()->json(['error' => 'Something went wrong.'], 201);
    }

    public function editUserCertInfo($id)
    {
        $uid = Session::get('user')['id'];
        $userCertInfo = JsCertification::where('id', $id)->where('js_userid', $uid)->first();

        return response()->json(['data' => $userCertInfo], 200);
    }

    public function updateUserCertInfo(Request $request)
    {
        $id = $request->certInfo['id'];
        $data = [
            'course' => $request->certInfo['course'],
            'certificate_institute_name' => $request->certInfo['certificate_institute_name'],
            'cert_from_date' => $request->certInfo['cert_from_date'],
            'cert_to_date' => $request->certInfo['cert_to_date'],
            'grade' => $request->certInfo['grade'],
            'certification_type' => $request->certInfo['certification_type'],
            'description' => $request->certInfo['description'],
        ];

        $certInfo = JsCertification::where('id', $id)->update($data);

        $uid = Session::get('user')['id'];
        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
        if ($certInfo) {
            return response()->json(['success' => 'Certificate Information Updated Successfully']);
        } else {
            return response()->json(['error' => 'Somethings went wrong.']);
        }
    }

    public function getEducationalInfo()
    {
        $uid = Session::get('user')['id'];
        $educationalDetails = DB::table('js_educational_details')
            ->leftjoin('qualifications', 'qualifications.id', 'js_educational_details.education')
            ->select('qualifications.id', 'qualifications.qualification', 'js_educational_details.*')
            ->where('js_educational_details.js_userid', $uid)
            ->get();
        return response()->json(['educationalDetails' => $educationalDetails], 200);
    }

    public function deleteEducationalDetail($id)
    {
        $uid = Session::get('user')['id'];
        $educationalDetail = JsEducationalDetail::find($id);
        $educationalDetail->delete($uid);

        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
        if ($educationalDetail) {
            return response()->json(['success' => 'Educational Detail Deleted Successfully']);
        } else {
            return response()->json(['error' => 'Educational Detail not Deleted']);
        }
    }

    public function editEducationalInfo($id)
    {
        $uid = Session::get('user')['id'];
        $educationalDetails = DB::table('js_educational_details')
            ->leftjoin('qualifications', 'qualifications.id', 'js_educational_details.education')
            ->select('qualifications.id', 'qualifications.qualification', 'js_educational_details.*')
            ->where('js_educational_details.id', $id)
            ->where('js_educational_details.js_userid', $uid)
            ->first();

        return response()->json(['educationalDetails' => $educationalDetails], 200);
    }

    public function updateEducationalInfo(Request $request)
    {
        $id = $request->editEducationalData['id'];
        $js_education = JsEducationalDetail::find($id);
        $js_education->education = $request->editEducationalData['education'];
        $js_education->degree_name = $request->editEducationalData['degree_name'];
        $js_education->percentage_grade = $request->editEducationalData['percentage_grade'];
        $js_education->institute_name = $request->editEducationalData['institute_name'];
        $js_education->passing_year = $request->editEducationalData['passing_year'];
        $js_education->save();

        $uid = Session::get('user')['id'];
        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();

        return response()->json(['success' => 'Educational Detail Updated', 200]);
    }


    public function userInfo()
    {
        $uid = Session::get('user')['id'];
        $userInfo = Jobseeker::select('id', 'fname', 'lname', 'email', 'contact')->where('id', $uid)->first();

        return response()->json(['userInfo' => $userInfo], 200);
    }
    public function checkEmailtest()
    {
        $email = 'rupakgupta265@gmail.com';
        $data = [
            'token' => 'Testing',
            'emailId' => $email
        ];
        $email = 'rupakgupta265@gmail.com';
        Mail::send('SendMail.testmail', $data, function ($message) use ($email) {
            $message->to($email)
                ->subject("Test Mail");
            //$message->from(env('MAIL_USERNAME'),"Naukriyan.com");
            $message->from('info@naukriyan.com', "Naukriyan.com");
        });
    }
    public function update_others_detail(Request $request)
    {

        $uid = Session::get('user')['id'];
        $js = Jobseeker::where('id', $uid)->first();
        //save in jobseeker table
        $js->nationality = $request->nationality;
        $js->aadhar_no = $request->aadhar_no;
        $js->designation = $request->designation;
        $js->functionalrole_id = $request->functionalrole_id;
        $js->industry_id = $request->industry_id;
        $js->exp_year = $request->exp_year;
        $js->exp_month = $request->exp_month;
        $js->job_type = $request->job_type_personal;
        $js->current_salary = $request->current_salary;
        $js->expected_salary = $request->expected_salary;
        $js->current_working_location = $request->current_working_location;
        $js->notice_period = $request->notice_period;
        $js->other_id_type = $request->other_id_type;
        $js->id_number = $request->id_number;
        $js->save();

        $updateLastModifiedDate = Jobseeker::find($uid);
        $updateLastModifiedDate->last_modified = Carbon::now();
        $updateLastModifiedDate->save();
    }
    public function UpdateEmployerPostJob(Request $request)
    {
        $uid = Session::get('user')['id'];
        $com_id = Session::get('user')['company_id'];
        $emp_personal = Empcompaniesdetail::find($com_id);
        if (isset($request->com_email)) {
            $emp_personal->com_email = $request->com_email;
            $emp_personal->emp_userid = $uid;
            $emp_personal->save();
        }
        if (isset($request->com_contact)) {
            $emp_personal->com_contact = $request->com_contact;
            $emp_personal->emp_userid = $uid;
            $emp_personal->save();
        }
        if (isset($request->com_email) && isset($request->com_contact)) {
            $emp_personal->com_contact = $request->com_contact;
            $emp_personal->com_email = $request->com_email;
            $emp_personal->emp_userid = $uid;
            $emp_personal->save();
        }
    }
}
