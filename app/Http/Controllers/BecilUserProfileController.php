<?php

namespace App\Http\Controllers;

use App\Models\BeciljobsUserDetail;
use App\Models\BeciljobsUserAddresses;
use App\Models\BeciljobsUser;
use App\Models\BeciljobsUserQualification;
use App\Models\BeciljobsUserExperience;
use App\Models\BeciljobsUserRef;
use App\Models\BeciljobsUserDocument;
use App\Models\BeciljobsUserEduDocument;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;  

class BecilUserProfileController extends Controller
{

    public function store(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'http://127.0.0.1:8000/api/getUserData');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "reg_id=".$request->reg_id);
        $response = curl_exec($ch);
        curl_close($ch);
        $act = json_decode($response, true);

        BeciljobsUser::insert($act['data']);

        // $this->validate($request,[
        //     'gender'=>'required',
        //     'father_name'=>'required',
        //     'father_contact'=>'required',
        //     'pan_no'=>'required',
        //     'dob'=>'required',
        //     'category_id' => 'required',
        //     'nationality' => 'required',
        //     'religion' => 'required',
        //     'email1' => 'required',
        //     'bloodgroup' => 'required',

        // ]);
       $userdetail = New BeciljobsUserDetail();
       $userdetail->user_id = $act['data']['id'];
       $userdetail->gender = $request->gender;
       $userdetail->father_name = $request->father_name;
       $userdetail->father_contact = $request->father_contact;
       $userdetail->pan_no = $request->pan_no;
       $userdetail->dob = $request->dob;
       $userdetail->passport_no = $request->passport;
       $userdetail->category_id = $request->category_id;
       $userdetail->nationality = $request->nationality;
       $userdetail->religion_id = $request->religion;
       $userdetail->mobile1 = $request->mobile1;
       $userdetail->email1 = $request->email1;
       $userdetail->email2 = $request->email2;
       $userdetail->language_id = $request->language;
       $userdetail->blood_group_id = $request->bloodgroup;
       $userdetail->prefered_location1 = $request->preferred_location_1;
       $userdetail->prefered_location2 = $request->preferred_location_2;
       $userdetail->save();

       $useraddress = New BeciljobsUserAddresses();
       $useraddress->user_id = $act['data']['id'];
       $useraddress->c_first_add = $request->c_first_add;
       $useraddress->c_second_add = $request->c_second_add;
       $useraddress->c_landmark = $request->c_landmark;
       $useraddress->c_state_id = $request->c_state_id;
       $useraddress->c_city_id = $request->c_city_id;
       $useraddress->c_pincode = $request->c_pincode;
       $useraddress->p_first_add = $request->p_first_add;
       $useraddress->p_second_add = $request->p_second_add;
       $useraddress->p_landmark = $request->p_landmark;
       $useraddress->p_state_id = $request->p_state_id;
       $useraddress->p_city_id = $request->p_city_id;
       $useraddress->p_pincode = $request->p_pincode;
       $useraddress->save();

           $uid = $useraddress->user_id;
           if($uid){
           $users = BeciljobsUser::find($uid);
           $users->stage = '2'; 
           $users->save();
        
            }
            return response()->json([
                'message'=>'success'
            ],200);
            
    }

    public function addQualification(Request $request){

        $userqualification = New BeciljobsUserQualification();
        $userqualification->user_id = $request->reg_id;
        $userqualification->eight_school_name = $request->eight_school_name;
        $userqualification->eight_passing_year = $request->eight_passing_year;
        $userqualification->eight_marks = $request->eight_marks;
        $userqualification->ten_board_name = $request->ten_board_name;
        $userqualification->ten_passing_year = $request->ten_passing_year;
        $userqualification->ten_marks     = $request->ten_marks;
        $userqualification->ten_stream = $request->ten_stream;
        $userqualification->twelve_board_name = $request->twelve_board_name;
        $userqualification->twelve_passing_year = $request->twelve_passing_year;
        $userqualification->twelve_marks = $request->twelve_marks;
        $userqualification->twelve_stream = $request->twelve_stream;
        $userqualification->diploma_institute_name = $request->diploma_institute_name;
        $userqualification->diploma_name = $request->diploma_name;
        $userqualification->diploma_passing_year = $request->diploma_passing_year;
        $userqualification->diploma_marks = $request->diploma_marks;
        $userqualification->diploma_stream = $request->diploma_stream;
        $userqualification->ug_degree = $request->ug_degree;
        $userqualification->ug_branch = $request->ug_branch;
        $userqualification->ug_university = $request->ug_university;
        $userqualification->ug_year = $request->ug_year;
        $userqualification->ug_marks = $request->ug_marks;
        $userqualification->ug_edu_type = $request->ug_edu_type;
        $userqualification->pg_degree = $request->pg_degree;
        $userqualification->pg_branch = $request->pg_branch;
        $userqualification->pg_university = $request->pg_university;
        $userqualification->pg_year = $request->pg_year;
        $userqualification->pg_marks = $request->pg_marks;
        $userqualification->pg_edu_type = $request->pg_edu_type;
        $userqualification->additional_institute_name = $request->additional_institute_name;
        $userqualification->additional_qual = $request->additional_qual;
        $userqualification->additional_qual_year = $request->additional_qual_year;
        $userqualification->additional_qual_marks = $request->additional_qual_marks;
        $userqualification->additional_qual_type = $request->additional_qual_type;
        $userqualification->higest_qualification = $request->higest_qualification;
        $userqualification->save();
 
        $uid = $userqualification->user_id;
        if($uid){
        $users = BeciljobsUser::find($uid);
        $users->stage = '3'; 
        $users->save();
         return response()->json([
             'message'=>'success'
         ],200); 
       }

    }

    public function addExperience(Request $request){
        $userexp = New BeciljobsUserExperience();
       $userexp->user_id = $request->reg_id;
       $userexp->latest_emp_cname = $request->latest_emp_cname;
       $userexp->latest_emp_from = $request->latest_emp_from;
       $userexp->latest_emp_to = $request->latest_emp_to;
       $userexp->prev_emp_cname = $request->prev_emp_cname;
       $userexp->prev_emp_from = $request->prev_emp_from;
       $userexp->prev_emp_to = $request->prev_emp_to;
       $userexp->total_exp_year = $request->total_exp_year;
       $userexp->total_exp_month = $request->total_exp_month;
       $userexp->relevant_exp_year = $request->relevant_exp_year;
       $userexp->relevant_exp_month = $request->relevant_exp_month;
       $userexp->current_salary_monthly = $request->current_salary_monthly;
       $userexp->home_salary_as_bank = $request->home_salary_as_bank;
       $userexp->save();

       $userref = New BeciljobsUserRef();
       $userref->user_id = $request->reg_id;
       $userref->ref1 = $request->ref1;
       $userref->ref2 = $request->ref2;
       $userref->ref1_mobile = $request->ref1_mobile;
       $userref->ref2_mobile = $request->ref2_mobile;
       $userref->save();

       $uid = $userexp->user_id;
       if($uid){
       $users = BeciljobsUser::find($uid);
       $users->stage = '4'; 
       $users->save();
        return response()->json([
            'message'=>'success'
        ],200);
      }
    }

    public function addDocument(Request $request){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'http://127.0.0.1:8000/api/getUserDocs');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "reg_id=".$request->reg_id);
        $response = curl_exec($ch);
        curl_close($ch);
        $act = json_decode($response, true);

        BeciljobsUserDocument::insert($act['user_doc']);
        BeciljobsUserEduDocument::insert($act['user_edu_doc']);

        return response()->json([
            'message'=>'success'
        ],200);
    }

    public function getAlluserDetail(Request $request)
    {
        
        $gender = $request->gender;
        $qualification = $request->qualification;
        $statesearch = $request->statesearch;
       
        $candidate = DB::table('beciljobs_users')
            ->leftjoin('beciljobs_users_qualifications', 'beciljobs_users_qualifications.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_addresses', 'beciljobs_user_addresses.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_users_details', 'beciljobs_users_details.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_exps', 'beciljobs_user_exps.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_documents', 'beciljobs_user_documents.user_id', 'beciljobs_users.id')
            ->leftjoin('states as c_states', 'c_states.id', '=', 'beciljobs_user_addresses.c_state_id')
            ->select('beciljobs_users.id','beciljobs_users.fname','beciljobs_users.mname','beciljobs_users.lname','beciljobs_users.mobile','beciljobs_users_details.email1','beciljobs_users_details.gender','beciljobs_user_addresses.c_state_id','c_states.states_name as c_state_name','beciljobs_users_qualifications.higest_qualification','beciljobs_user_exps.home_salary_as_bank','beciljobs_user_documents.resume');
            //  ->where('beciljobs_users.stage','5');
           

              if($gender && $gender !='') {
            $candidate->where('beciljobs_users_details.gender', $gender);
        }

        if($statesearch && $statesearch !='') {
            $candidate->where('beciljobs_user_addresses.c_state_id', $statesearch);
        }

         if($qualification && $qualification !='') {
             $candidate->where('beciljobs_users_qualifications.higest_qualification',$qualification );
         }
        
        $candidate = $candidate->get();
        return response()->json(['status' => 'success', 'data' => $candidate], 200);
    }

    public function exportuserdetails()
    {

        $candidate = DB::table('beciljobs_users')
            ->leftjoin('beciljobs_users_qualifications', 'beciljobs_users_qualifications.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_addresses', 'beciljobs_user_addresses.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_users_details', 'beciljobs_users_details.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_exps', 'beciljobs_user_exps.user_id', 'beciljobs_users.id')
            ->leftjoin('beciljobs_user_documents', 'beciljobs_user_documents.user_id', 'beciljobs_users.id')
            ->leftjoin('states as c_states', 'c_states.id', '=', 'beciljobs_user_addresses.c_state_id')
             ->select('beciljobs_users.id','beciljobs_users.fname','beciljobs_users.mname','beciljobs_users.lname','beciljobs_users.mobile','beciljobs_users_details.email1','beciljobs_users_details.gender','c_states.states_name as c_state_name','beciljobs_users_qualifications.higest_qualification','beciljobs_user_exps.home_salary_as_bank','beciljobs_user_documents.resume')
            //  ->where('stage','5')
             ->get();

        $headers = [
           'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=candidate-export.csv',
            'Expires' => '0',
            'Pragma' => 'public'
            ];

        //$list = collect($candidate)->map(function($x){ return (array) $x; })->toArray();
        $list = collect($candidate)->map(function($x){
            return [
                'Name' => $x->fname. ' ' .$x->mname. '' .$x->lname,
                'Mobile' => $x->mobile,
                'Email' => $x->email1,
                'Gender' => $x->gender,
                'State' => $x->c_state_name,
                'Highest Qualification' => $x->higest_qualification,
                'Take Home Salary' => $x->home_salary_as_bank,
                'Resume' => $x->resume ? url('documents/resume/'.$x->resume) : 'Not Available',
            ];

        })->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
       
    }
    
    public function testing(){
        dd("hello testing");
    }

}
