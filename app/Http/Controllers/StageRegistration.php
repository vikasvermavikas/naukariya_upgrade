<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobseeker;
use App\Models\JsEducationalDetail;
use App\Models\JsProfessionalDetail;
use App\Models\JsResume;
use App\Models\JsCertification;
use App\Models\JsSkill;
use App\Models\Institute;
use App\Models\Industry;
use App\Models\FunctionalRole;
use App\Models\Qualification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use DB;
use throwable;

class StageRegistration extends Controller
{
    public function addProfessionalDetail(Request $request)
    {

        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('jobseeker')->user()->id;
        // $data = [];
        // $uid = 1215;
        $update = 0;
        $create = 0;

        // Delete records of professional.
        if (count($request->removedprofessional) > 0 && isset($request->removedprofessional[0])) {
            JsProfessionalDetail::whereIn(
                'id',
                explode(",", $request->removedprofessional[0])
            )->delete();
        }

        // Update or add records of professional.
        if ($request->professional_experience != 'fresher') {
            for ($i = 0; $i < count($request->designation); $i++) {

                // If company is already exist, then update else create.

                // if ($request->index[$i] != null) {
                if (JsProfessionalDetail::where([
                    'js_userid' => $uid,
                    'organisation' => $request->organization[$i]
                ])->exists()) {
                    JsProfessionalDetail::where([
                        'js_userid' => $uid,
                        'organisation' => $request->organization[$i]
                    ])
                        ->update([
                            'designations' =>  $request->designation[$i],
                            'organisation' => $request->organization[$i],
                            'job_type' => $request->jobtype[$i],
                            'from_date' => $request->fromdate[$i],
                            'to_date' => $request->todate[$i],
                            'salary' => $request->salary[$i],
                            // 'sal_confidential' => $request->sal_confidential[$i],
                            'responsibility' => $request->responsibility[$i],
                            'key_skill' => $request->key_skills[$i],
                            'currently_work_here' => $request->todate[$i] ? NULL : 1

                        ]);
                    ++$update;
                } else {
                    $js_professional = new JsProfessionalDetail();
                    $js_professional->js_userid = $uid;
                    $js_professional->designations = $request->designation[$i];
                    $js_professional->organisation = $request->organization[$i];
                    $js_professional->job_type = $request->jobtype[$i];
                    // $js_professional->job_shift = $request->job_shift;
                    // $js_professional->industry_name = $request->industry_name;
                    // $js_professional->functional_role = $request->functional_role;
                    $js_professional->from_date = $request->fromdate[$i];
                    $js_professional->to_date = $request->todate[$i];
                    $js_professional->salary = $request->salary[$i];
                    // $js_professional->sal_confidential = !empty($request->sal_confidential[$i]) ? $request->sal_confidential[$i] : '0';
                    $js_professional->responsibility = $request->responsibility[$i];
                    $js_professional->key_skill = $request->key_skills[$i];
                    $js_professional->currently_work_here = $request->todate[$i] ? NULL : 1;
                    $js_professional->save();
                    ++$create;
                }
            }
        }

        if ($create > 0 || $update > 0 || $request->professional_experience == 'fresher') {
            $updateLastModifiedDate = Jobseeker::find($uid);
            $updateLastModifiedDate->professional_stage = $request->professional_experience;
            $updateLastModifiedDate->last_modified = Carbon::now();
            $updateLastModifiedDate->save();
            return response()->json(['success' => true, 'message' => 'Professional details updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong, please call your administrator.']);
        // return ['created' => $create, 'update' => $update];

    }
    public function addCertificationDetail(Request $request)
    {

        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('jobseeker')->user()->id;
        // $data = [];
        // return $request->all();

        // $uid = 1215;
        $update = 0;
        $create = 0;

        // Delete records of certification.
        if ($request->removedids[0]){
            JsCertification::whereIn('id', explode(',', $request->removedids[0]))->delete();
        }

        // Submit or update certificates.
        for ($i = 0; $i < count($request->courseName); $i++) {

            if (!empty($request->certificateid[$i])) {
                JsCertification::where('id', $request->certificateid[$i])
                    ->update([
                        'course' =>  $request->courseName[$i],
                        'certificate_institute_name' => $request->instituteName[$i],
                        'certification_type' => $request->certficationtype[$i],
                        'cert_from_date' => $request->fromdate[$i],
                        'cert_to_date' => $request->todate[$i],
                        'grade' => $request->score[$i],
                        'description' => $request->description[$i],
                        'certificate_link' => $request->certificate_link[$i]
                    ]);
                ++$update;
                // return $request->all();
            } else {
                $js_certificate = new JsCertification();
                $js_certificate->js_userid = $uid;
                $js_certificate->course = $request->courseName[$i];
                $js_certificate->certificate_institute_name = $request->instituteName[$i];
                $js_certificate->certification_type = $request->certficationtype[$i];
                $js_certificate->cert_from_date = $request->fromdate[$i];
                $js_certificate->cert_to_date = $request->todate[$i];
                $js_certificate->grade = $request->score[$i];
                $js_certificate->description = $request->description[$i];
                $js_certificate->certificate_link = $request->certificate_link[$i];
                $js_certificate->save();
                ++$create;
            }
        }
        if ($create > 0 || $update > 0) {
            $updateLastModifiedDate = Jobseeker::find($uid);
            $updateLastModifiedDate->last_modified = Carbon::now();
            $updateLastModifiedDate->save();
        }
        // $stage = Jobseeker::select('stage')->where('id', $uid)->first();

        // return response()->json(['data' => $request->all(), 'stage' => $stage]);
        return response()->json(['success' => true,'message' => 'Certification details updated successfully.']);

    }
    public function addCertificate(Request $request)
    {
        $uid = Session::get('user')['id'];
        // $uid = 1215;
        if (!$request->certificate) {
            $certificate = JsCertification::where('certificate', 1)->where('js_userid', $uid)->get();
            // return count($certificate);
            if (count($certificate) == 0) {
                $js_certificate = new JsCertification();
                $js_certificate->js_userid = $uid;
                $js_certificate->certificate = "1";
                $js_certificate->save();
                $updateLastModifiedDate = Jobseeker::find($uid);
                $updateLastModifiedDate->last_modified = Carbon::now();
                $updateLastModifiedDate->save();
            }
            $updateLastModifiedDate = Jobseeker::find($uid);
            $updateLastModifiedDate->last_modified = Carbon::now();
            $updateLastModifiedDate->save();
        } else {
            $certificate = JsCertification::where('js_userid', $uid)->get();
            if (count($certificate) == 0) {
                $data = Jobseeker::select('savestage')->where('id', $uid)->get();
                $savestage = $data[0]->savestage;
                Jobseeker::where('id', $uid)->update(['savestage' => ($savestage - 1)]);
            }
            JsCertification::where('certificate', 1)->where('js_userid', $uid)->delete();
        }
    }
    public function getProfessionalDetail()
    {
        // $uid = 1215;
        $uid = Session::get('user')['id'];

        $data = JsProfessionalDetail::where('js_userid', $uid)->get();
        $professional_stage = Jobseeker::select('professional_stage')->where('id', $uid)->first();
        return  ['data' => $data->all(), 'professional_stage' => $professional_stage];
    }
    public function getCertificationDetail()
    {
        // $uid = 1215;
        $uid = Session::get('user')['id'];

        $count = JsCertification::where('certificate', 1)->where('js_userid', $uid)->get();
        // return ;
        if (count($count) > 0) {
            $data = JsCertification::select('certificate')->where('js_userid', $uid)->where('certificate', 1)->get();
            return  $data[0]->certificate;
        } else {
            $data = JsCertification::where('js_userid', $uid)->get();
            if (count($data) > 0) {

                return  $data->all();
            } else {
                $data2[0]['certificate'] = 1;
                return  $data2;
            }
        }
    }
    public function deleteProfessionalDetail($id)
    {

        $data = JsProfessionalDetail::where('id', $id)->delete();
        return  $id;
    }

    public function deleteCertificationDetail($id)
    {

        $data = JsCertification::where('id', $id)->delete();
        return  $id;
    }


    public function getSkillDetail()
    {
        $uid = Session::get('user')['id'];

        $data = JsSkill::where('js_userid', $uid)->get();
        return  $data->all();
    }

    public function addSkillDetail(Request $req)
    {
        
        // $uid = Session::get('user')['id'];
        // $uid = 1215;
        try {
            $uid = Auth::guard('jobseeker')->user()->id;
            $data = JsSkill::where('js_userid', $uid)->delete();
            if ($req->skill) {
                $skills = explode(",", $req->skill);
             
                for ($i = 0; $i < count($skills); $i++) {
        
                    $a = JsSkill::create(
                        [
                            'js_userid' => $uid,
                            'skill' => $skills[$i],
                            // 'expert_level' => (($i < count($req->expert_level)) && ($req->expert_level[$i] != "")) ? $req->expert_level[$i] : ""
                        ]
                    );
                }
            }
            return response()->json(['success' => true, 'message' => 'Skills updated successfully.'], 200);
        }
        catch (throwable $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()], 200);
        }
    }

    public function deleteSkillDetail($id)
    {
        $data = JsSkill::where('id', $id)->delete();
        return  $id;
    }

    public function getEducationDetail()
    {
        $uid = Session::get('user')['id'];

        $data = JsEducationalDetail::where('js_userid', $uid)->get();
        return  $data->all();
    }

    public function addEducationDetail(Request $req)
    {

        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('jobseeker')->user()->id;

        for ($i = 0; $i < count($req->degree); $i++) {

            $a = JsEducationalDetail::updateOrCreate(
                [
                    'js_userid' => $uid,
                    // 'id' => (isset($req->index[$i])) ? $req->index[$i] : "",
                    'education' => $i + 1,
                ],
                [
                    'degree_name' => $req->degree[$i],
                    'course_type' => (($i < count($req->course_type)) && ($req->course_type[$i] != "")) ? $req->course_type[$i] : "",
                    'percentage_grade' => $req->percentage[$i],
                    'passing_year' => $req->pass_year[$i],
                    'institute_name' => $req->ins_name[$i],
                    'institute_location' => $req->ins_loc[$i],
                    'education' => $i + 1,

                ]
            );
            // $ins = Institute::firstOrCreate(['institute_name' => $req->ins_name[$i]]);
        }
        return response()->json(['success' => true, 'message' => 'Education Details updated successfully']);
    }

    public function deleteEducationDetail($id)
    {
        $data = JsEducationalDetail::where('id', $id)->delete();
        return  $id;
    }


    public function getStage()
    {
        $uid = Session::get('user')['id'];
        // $uid = 1215;

        $data = Jobseeker::select('stage', 'savestage')->where('id', $uid)->get();
        return  $data;
    }


    public function updateStage($id)
    {
        $uid = Session::get('user')['id'];
        // $uid = 1215;

        Jobseeker::where('id', $uid)->update(['stage' => $id]);
        $data = Jobseeker::select('stage', 'savestage')->where('id', $uid)->get();
        return  $data;
    }
    public function resumeUpload(Request $req)
    {

        $uid = Session::get('user')['id'];
        $resumeup = 0;
        // $uid = 1215;
        $filename = time() . '.' . $req->resume->extension();
        $path = public_path() . '/resume/';
        $upload = $req->resume->move($path, $filename);

        $addressData = [
            'js_userid' => $uid,
            'resume' => $filename,
        ];

        JsResume::updateOrCreate(['js_userid' => $uid], $addressData);
        if ($upload) {
            $resumeup = 1;
        }
        return $resumeup;
    }
    public function resumeSave(Request $req)
    {
        //dd($request->all());
        $uid = Session::get('user')['id'];
        // $uid = 1215;
        $addressData = [
            'resume_video_link' => $req->video,
            'cover_letter' => $req->cover,
        ];

        JsResume::updateOrCreate(['js_userid' => $uid], $addressData);

        $stage = Jobseeker::select('stage')->where('id', $uid)->first();

        return response()->json(['data' => $req->all(), 'stage' => $stage]);
        // return  $req->all();
    }
    public function addPersnol(Request $req)
    {

        $uid = Auth::guard('jobseeker')->user()->id;
        // $uid = 1215;
        if (is_array($req->locationlist)) {

            $req->locationlist =  implode(',', $req->locationlist);
        } else {
            $req->locationlist = $req->locationlist;
        }

        if ($req->password != NULL &&  strlen($req->password) < 15) {
            $password = Hash::make($req->password);
        } else {
            $password =  $req->password;
        }

        $personalData = [
            'fname' => $req->fname,
            'lname' => $req->lname,
            'email' => $req->email,
            'contact' => $req->contact_no,
            'gender' => $req->gender,
            'dob' => $req->date,
            'exp_year' => $req->exp_year,
            'exp_month' => $req->exp_mon,
            'industry_id' => $req->job_industry_id,
            'functionalrole_id' => $req->job_functional_role_id,
            'preferred_location' => $req->locationlist,
            'linkedin' => $req->linkedin,
            'current_salary' => $req->curr_sal,
            'expected_salary' => $req->exp_sal,
            'notice_period' => $req->notice_period,
            'designation' => $req->designation,
            'password' => $password,
        ];

        // Upload resume.
        if ($req->resume) {
            // $uid = 1215;
            $filename = time() . '.' . $req->resume->extension();
            $path = public_path() . '/resume/';
            $req->resume->move($path, $filename);
            $addressData = [
                'js_userid' => $uid,
                'resume' => $filename,
            ];

            JsResume::updateOrCreate(['js_userid' => $uid], $addressData);
        }

        // Update image.
        if ($req->image) {
            $filename = time() . '.' . $req->image->extension();
            $path = public_path() . '/jobseeker_profile_image/';
            $req->image->move($path, $filename);
            $personalData['profile_pic_thumb'] = $filename;
        }


        Jobseeker::where('id', $uid)->update($personalData);
        return response()->json(['status' => true, 'message' => 'Profile details added successfully'], 200);
    }
    public function getPersnol(Request $req)
    {

        // $user = Session::get('user');
        // $uid = Session::get('user')['id'];
        // $uid = 1215;
        $uid = Auth::guard('jobseeker')->user()->id;
        $data = Jobseeker::where('id', $uid)->select(
            'professional_stage',
            'fname',
            'lname',
            'email',
            'contact',
            'linkedin',
            'gender',
            'dob',
            'exp_year',
            'exp_month',
            'industry_id',
            'functionalrole_id',
            'profile_pic_thumb',
            'preferred_location',
            'current_salary',
            'expected_salary',
            'notice_period',
            'designation',
            'password'
        )->first();
     
        $industries = Industry::select('id', 'category_name')->orderBy('category_name', 'ASC')->get();
        $functional_roles = FunctionalRole::select('functional_roles.id', 'functional_roles.subcategory_name')->orderBy('functional_roles.subcategory_name')->get();
        $location_data = DB::table('master_location')
            ->select('state')
            ->distinct('state')
            ->get();

        $locations = $location_data->map(function ($data) {
            $edu = DB::table('master_location')
                ->select('master_location.id', 'master_location.location')
                ->where('master_location.state', $data->state)->get();

            $educations = ['location' => $edu];

            $collection = collect($data)->merge($educations);
            return $collection;
        });

        $getresume = JsResume::select('resume')->where('js_userid', $uid)->first();
        $graduations = Qualification::where('group', 'Graduate')->get();
        $postgraduations = Qualification::where('group', 'Post Graduate')->get();
        $highschool = JsEducationalDetail::where([
            'js_userid' => $uid,
            'education' => 1
        ])->first();
        $secondayschool = JsEducationalDetail::where([
            'js_userid' => $uid,
            'education' => 2
        ])->first();
        $graduationdetails = JsEducationalDetail::where([
            'js_userid' => $uid,
            'education' => 3
        ])->first();
        $postgraduationDetails = JsEducationalDetail::where([
            'js_userid' => $uid,
            'education' => 4
        ])->first();

        $professionalDetails = JsProfessionalDetail::where('js_userid', $uid)->get();
        $certificationDetails = JsCertification::where('js_userid', $uid)->get();
        $skillsDetails = JsSkill::select(DB::raw('GROUP_CONCAT(skill) as skills'))->where('js_userid', $uid)->groupBy('js_userid')->first();
       
        return view('jobseeker.profile-stage', ['data' => $data, 'industries' => $industries, 'functional_roles' => $functional_roles, 'locations' => $locations, 'getresume' => $getresume, 'graduations' => $graduations, 'postgraduations' => $postgraduations, 'highschool' => $highschool, 'secondayschool' => $secondayschool, 'graduationdetails' => $graduationdetails, 'postgraduationDetails' => $postgraduationDetails, 'professionalDetails' => $professionalDetails, 'certificationDetails' => $certificationDetails, 'skillsDetails' => $skillsDetails]);
    }
    public function resumeGet()
    {
        $uid = Session::get('user')['id'];
        // $uid = 1215;
        $data = JsResume::where('js_userid', $uid)->get();
        return $data;
    }

    public function skipStage($stage)
    {
        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('jobseeker')->user()->id;
        // $uid = 1215;

        $checkStage = Jobseeker::where('id', $uid)->select('savestage')->get();
        // return $checkStage[0]->savestage;
        if ($checkStage[0]->savestage <= $stage) {
            $data = Jobseeker::where('id', $uid)->update(['savestage' => ($stage + 1)]);
        }
        else {
            $data = Jobseeker::where('id', $uid)->update(['stage' => ($stage + 1)]);
        }

        // return $stage;
        return response()->json(['success' => true]);
    }
}
