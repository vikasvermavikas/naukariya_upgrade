<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\States;
use App\Models\Cities;
use App\Models\DesignationList;
use App\Models\Industry;
use App\Models\Empcompaniesdetail;
use App\Models\FunctionalRole;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Image;
use App\Mail\AddJobseeker;
use App\Mail\UpdateJobseeker;
use App\Mail\DeactiveJobseeker;
use App\Mail\ActiveJobseeker;
use App\Exports\JobseekerExport;
use App\Http\Middleware\Employeer;
use App\Models\Jobmanager;
use App\Models\JsResume;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Object_;
use App\Models\JsSkill;
use Session;
use Socialite;


class JobseekerController extends Controller
{

    public function index()
    {
        //to convert id to name
        $data = DB::table('jobseekers') //current table
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id') //tablename,table.id,current table.field_name
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->select('jobseekers.id', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.contact', 'jobseekers.email', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.username', 'jobseekers.can_edit_company', 'jobseekers.active', 'functional_roles.subcategory_name', 'industries.category_name')->orderBy('id', 'desc') //use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company
            ->get();
        return response()->json(['data' => $data], 200);
    }


public function redirect($provider, $userType)
{   
   
    Session::put('user', ['user_type' => $userType]);
    return Socialite::driver($provider)
    // ->with(['state' => 'event_slug='.$userType])
    ->redirect();
}
 
public function callback($provider)
{
    // dd("ok1");
    // exit;
    // $state = $req->input('state');
    // parse_str($state, $result);
    // $user_type = $result['event_slug'];

    $user_type = Session::get('user')['user_type'];
    
    $getInfo = Socialite::driver($provider)->user();

    if($user_type == 'Jobseeker'){

        $jobseeker = Jobseeker::where('email',$getInfo->user['email'])->first();
        // if($provider == 'google'){
        //     $jobseeker = Jobseeker::where('email',$getInfo->user['email'])->first();
        // }else{
        //     $jobseeker = Jobseeker::where('linkdin_id',$getInfo['id'])->first();
        // }
        $user_exist = 0;
        
        if(!$jobseeker){
            $jobseeker = new Jobseeker();
            $jobseeker->fname = $getInfo->user['given_name'];
            $jobseeker->lname = $getInfo->user['family_name'];
            $jobseeker->email = $getInfo->user['email'];
            ($provider == 'google')? $jobseeker->google_id  = $getInfo['id'] : $jobseeker->linkedin_id  = $getInfo['id']; 
            ($provider == 'google')?  $jobseeker->sign_in_through  = 'google' :  $jobseeker->sign_in_through  = 'linkedin';         
            $jobseeker->user_type="Jobseeker";
            $jobseeker->save();

        }else{
            if($jobseeker->password != NULL){
                $user_exist = 1;
            }
            
            if($provider == 'google'){
                $jobseeker->google_id  = $getInfo['id'];
                // $auth =  ['email' => $jobseeker->email, 'google_id'  => $getInfo['id'] ];
            }else{
                $jobseeker->linkdin_id  = $getInfo['id'];
                // $auth =  ['email' => $jobseeker->email, 'linkedin_id'  => $getInfo['id'] ];
            }
            $jobseeker->save();
        }

        Session::flush();

        // if (Auth::guard('jobseeker')->attempt(($provider == 'google')? ['email' => $jobseeker->email, 'google_id'  => $getInfo['id'] ] : ['email' => $jobseeker->email, 'linkedin_id'  => $getInfo['id'] ])) {
        if ($jobseeker->email == $getInfo->user['email'] && ($provider == 'google')? $jobseeker->google_id  = $getInfo['id'] : $jobseeker->linkedin_id  = $getInfo['id']) {   
            
        Auth::login($jobseeker);
         
        $data = DB::table('jobseekers')
        ->where('email', $getInfo->user['email'])
        ->where('user_type', 'Jobseeker')
        ->first();     

        // if ($data->active == 'Yes') {
        Session::flush();
        Session::put('user', ['id' => $jobseeker->id, 'fname' => $jobseeker->fname, 'lname' =>  $jobseeker->lname, 'email' => $jobseeker->email, 'user_type' => 'Jobseeker', 'last_login' => '23', 'profile_pic_thumb' => $getInfo->user['picture']]);
        
        if($user_exist == 1){
            return redirect()->to('/#/browsejob');

        }else{
            return redirect()->to('/#/profile-stage');

        }

        }else{
            Session::flush();

            return redirect()->to('/#/');
        }

      

    } elseif($user_type == 'Employer'){

        // if($provider == 'google'){
        //     $employer = AllUser::where('google_id',$getInfo['id'])->first();
        // }else{
        //     $employer = AllUser::where('linkdin_id',$getInfo['id'])->first();
        // }

        $employer = AllUser::where('email',$getInfo->user['email'])->first();

        if(!$employer){
            $employer = new AllUser();
            $employer->fname = $getInfo->user['given_name'];
            $employer->lname = $getInfo->user['family_name'];
            $employer->email = $getInfo->user['email'];
            $employer->google_id = $getInfo['id'];
            ($provider == 'google')? $employer->google_id  = $getInfo['id'] : $employer->linkedin_id  = $getInfo['id']; 
            ($provider == 'google')?  $employer->sign_in_through  = 'google' :  $employer->sign_in_through  = 'linkedin';
            $employer->user_type="Employer";
            $employer->save();

        }else{

            if($provider == 'google'){
                $employer->google_id  = $getInfo['id'];
                // $auth =  ['email' => $employer->email, 'google_id'  => $getInfo['id'] ];
            }else{
                $employer->linkdin_id  = $getInfo['id'];
                // $auth =  ['email' => $employer->email, 'linkedin_id'  => $getInfo['id'] ];
            }
            $employer->save();
        }

        if ($employer->email == $getInfo->user['email'] && ($provider == 'google')? $employer->google_id  = $getInfo['id'] : $employer->linkedin_id  = $getInfo['id']) {
     
        $data = DB::table('all_users')
        ->where('email', $getInfo->user['email'])
        ->where('user_type', 'Employer')
        ->first();
                
        // if ($data->active == 'Yes') {
        Session::flush();
        Session::put('user', ['id' => $employer->id, 'fname' => $employer->fname, 'lname' =>  $employer->lname, 'email' => $employer->email, 'user_type' => 'Employer',  'profile_pic_thumb' => $getInfo->user['picture']]);
            // }
            return redirect()->to('/#/empdashboard/');
        }else{
            return redirect()->to('/#/');
        }

        
    }
}


 

public function store(Request $request)
    {
        $jobseeker = new Jobseeker();

        $jobseeker->fname = $request->fname;
        $jobseeker->lname = $request->lname;
        $jobseeker->email = $request->email;
        $jobseeker->contact = $request->contact;
        $jobseeker->gender = $request->gender;
        $jobseeker->dob = $request->dob;
        $jobseeker->user_type = "Jobseeker";
        $jobseeker->status = "1";
        $jobseeker->active = "Yes";
        $jobseeker->email_verified = "Yes";
        $jobseeker->add_by = Auth::user()->id;
        $isSave = $jobseeker->save();

        if ($isSave) {
            $password = $this->generateRandomPassword(10);

            Mail::send('SendMail.JobseekerCredential', [
                'name' => $request->fname,
                'email' => $request->email,
                'password' => $password
            ], function ($message) use ($request) {
                $message->from(env('TEST_USEREMAIL'));
                $message->to($request->email)->subject('Credential');
            });

            $updateJobseeker = DB::table('jobseekers')->where('email', $request->email)->update(['is_credential_send' => 1, 'password' => Hash::make($password)]);

            if ($updateJobseeker) {
                return response()->json(['status' => 'success', 'Jobseeker created successfully'], 201);
            }
        }
    }

    public function edit($id)
    {
        $data = Jobseeker::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        $jobseeker = Jobseeker::find($id);
        if ($request->profile_pic_thumb != $jobseeker->profile_pic_thumb) {
            $strpos = strpos($request->profile_pic_thumb, ';');
            $sub = substr($request->profile_pic_thumb, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->profile_pic_thumb)->resize(200, 200);
            $upload_path = public_path() . "/jobseeker_profile_image/";
            $image = $upload_path . $jobseeker->profile_pic_thumb;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $name = $jobseeker->profile_pic_thumb;
        }

        $jobseeker->fname = $request->fname;
        $jobseeker->lname = $request->lname;
        $jobseeker->email = $request->email;
        $jobseeker->password = $request->password;
        $jobseeker->username = $request->username;
        $jobseeker->contact = $request->contact;
        $jobseeker->gender = $request->gender;

        $jobseeker->designation = $request->designation;
        $jobseeker->industry_id = $request->industry_id;
        $jobseeker->functionalrole_id = $request->functionalrole_id;
        $jobseeker->dob = $request->dob;
        $jobseeker->profile_pic_thumb = $name;
        $jobseeker->user_type = "Jobseeker";
        $jobseeker->add_by = Auth::user()->id;

        $jobseeker->save();
    }

    public function deactive($id)
    {
        $jobseeker = Jobseeker::find($id);
        $jobseeker->active = "No";
        $data = DB::table('jobseekers')
            ->select('id', 'email', 'fname', 'contact', 'user_type')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['email'];
        $name = $myArray['fname'];
        $mobile = $myArray['contact'];
        $user_type = $myArray['user_type'];

        //$mobile=$myArray['company_name'];
        //$company_name=$myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new DeactiveJobseeker($name));    //
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your " . $user_type . " Account Now De-activated.
        For Any help just revert your message to admin@naukriyan.com.
        Best of luck.
        Team
        Naukriyan.com";
        $sms_text = urlencode($msg);


        //Submit to server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.sbcinfotech.com/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=7246&routeid=100922&type=text&contacts=" . $mobile . "&senderid=" . $from . "&msg=" . $sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        //sms close
        $jobseeker->save();
    }

    public function active($id)
    {
        $jobseeker = Jobseeker::find($id);
        $jobseeker->active = "Yes";
        $data = DB::table('jobseekers')
            ->select('id', 'email', 'fname', 'contact', 'user_type')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['email'];
        $name = $myArray['fname'];
        $mobile = $myArray['contact'];
        $user_type = $myArray['user_type'];

        //$mobile=$myArray['company_name'];
        //$company_name=$myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new ActiveJobseeker($name));    //
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your " . $user_type . " Account Now activated.
        For Any help just revert your message to admin@naukriyan.com.
        Best of luck.
        Team
        Naukriyan.com";
        $sms_text = urlencode($msg);


        //Submit to server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.sbcinfotech.com/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=7246&routeid=100922&type=text&contacts=" . $mobile . "&senderid=" . $from . "&msg=" . $sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
        //sms close
        $jobseeker->save();
    }

    public function storef(Request $request)
    {
        $jobseeker = new Jobseeker();
        $jobseeker->fname = $request->fname;
        $jobseeker->lname = $request->lname;
        $jobseeker->email = $request->email;
        $jobseeker->password = $request->password;
        $jobseeker->contact = $request->contact;
        $jobseeker->designation = $request->designation;
        $jobseeker->user_type = "Jobseeker";
        $jobseeker->save();
        return redirect('/')->with('status', 'Successfully Registered!');
    }

    public function exportjobseekerdetails()
    {
        return Excel::download(new JobseekerExport, 'jobseeker.xlsx');
    }

    public function exportCheckedJobSeekerDetails($id)
    {
        $ids = explode(',', $id);

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=employer-export.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $active = 'Yes';
        $list = DB::table('jobseekers')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id')
            ->select('jobseekers.fname', 'jobseekers.lname', 'jobseekers.email', 'jobseekers.gender', 'jobseekers.contact', 'industries.category_name', 'jobseekers.designation', 'jobseekers.dob', 'jobseekers.aadhar_no', 'jobseekers.created_at')
            ->where('jobseekers.active', $active)
            ->whereIn('jobseekers.id', $ids)
            ->orderBy('jobseekers.id', 'desc')
            ->get();

        $list = collect($list)->map(function ($x) {
            return (array)$x;
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

    public function filterJobseeker(Request $request)
    {
        $data = DB::table('jobseekers')
            ->leftjoin('industries', 'industries.id', '=', 'jobseekers.industry_id') //tablename,table.id,current table.field_name
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'jobseekers.functionalrole_id')
            ->select('jobseekers.id', 'jobseekers.fname', 'jobseekers.is_credential_send', 'jobseekers.lname', 'jobseekers.contact', 'jobseekers.email', 'jobseekers.industry_id', 'jobseekers.functionalrole_id', 'jobseekers.username', 'jobseekers.can_edit_company', 'jobseekers.active', 'functional_roles.subcategory_name', 'industries.category_name')->orderBy('id', 'desc'); //use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company

        if (isset($request->industry_id) && $request->industry_id != '') {
            $data->Where('jobseekers.industry_id', $request->industry_id);
        }

        if (isset($request->email) && $request->email != '') {
            $data->Where('jobseekers.email', $request->email);
        }

        if (isset($request->is_credential_send) && $request->is_credential_send != '') {
            $data->Where('jobseekers.is_credential_send', $request->is_credential_send);
        }

        if (isset($request->status) && $request->status != '') {
            $data->Where('jobseekers.active', $request->status);
        }
        if (isset($request->from_date) && $request->from_date != '') {
            $data->Where('jobseekers.created_at', '>=', $request->from_date);
        }

        if (isset($request->to_date) && $request->to_date != '') {
            $data->Where('jobseekers.created_at', '<=', $request->to_date);
        }


        $data = $data->paginate(10);

        return response()->json(['data' => $data], 200);
    }

    public function generateRandomPassword($length = 10): string
    {
        return str_random($length);
    }

    public function mergeAddressPinCode($address, $pincode)
    {
        if (is_null($address) && is_null($pincode)) {
            return null;
        }

        if (!is_null($address) && is_null($pincode)) {
            return $address;
        }

        if (is_null($address) && !is_null($pincode)) {
            return $pincode;
        }

        if (!is_null($address) && !is_null($pincode)) {
            return $address . ', ' . $pincode;
        }
    }

    public function uploadJobseeker(Request $request)
    {
        ini_set('max_execution_time', 300);

        $imageName = time() . '.' . $request->csvFile->getClientOriginalExtension();

        $request->csvFile->move(public_path('/jobseeker/csv_file/'), $imageName);

        $counter = 0;
        $totalRecords = 0;

        if (($handle = fopen(public_path('/jobseeker/csv_file/') . $imageName, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

                //saving to db logic goes here
                if (!$counter == 0) {
                    $totalRecords = $counter;

                    $requestData = [
                        'fname' => $data[0],
                        'email' => $data[1] ? $data[1] : null,
                        'contact' => $data[2] ? $data[2] : null,
                        'gender' => $data[3] ? $data[3] : null,
                        'address' => $this->mergeAddressPinCode($data[4], $data[5]),
                        'status' => '1',
                        'active' => 'Yes',
                        'email_verified' => 'Yes',
                        'user_type' => 'Jobseeker',
                        'is_credential_send' => 0,
                        'created_at' => Carbon::now(),
                    ];

                    DB::table('jobseekers')->insert($requestData);
                }

                $counter++;
            }

            fclose($handle);

            unlink(public_path('/jobseeker/csv_file/') . $imageName);
        }

        return response()->json(['status' => 'success', 'message' => 'You have successfully import jobseeker.', 'total record' => $totalRecords], 201);
    }

    public function importedJobseeker()
    {
        return Jobseeker::where('is_credential_send', 0)->paginate(10);
    }

    public function sendCredential(Request $request)
    {
        $updateQry = false;

        $jobseeker_id = $request->params['jobseeker_id'];
        $getjobseekerDetails = DB::table('jobseekers')
            ->select('id', 'fname', 'email')->where('is_credential_send', 0)->whereIn('id', $jobseeker_id)->get();

        foreach ($getjobseekerDetails as $row) {
            $password = $this->generateRandomPassword(10);
            Mail::send('SendMail.JobseekerCredential', [
                'name' => $row->fname,
                'email' => $row->email,
                'password' => $password
            ], function ($message) use ($row) {
                //$message->from(env('MAIL_USERNAME'));
                $message->from(env('TEST_USEREMAIL'));
                $message->to($row->email)->subject('Credential');
            });

            $updateQry = DB::table('jobseekers')->where('id', $row->id)->update(['is_credential_send' => 1, 'password' => Hash::make($password)]);
        }

        if (!$updateQry) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 301);
        }

        return response()->json(['status' => 'success', 'message' => 'Credential send to jobseekers.'], 200);
    }

    // GET KEYWORDS FOR SKILLS, DESIGNATION, COMPANIES, INDUSTRIES, FUCNTIONAL ROLE, JOB TITLE AND JOB ROLE
    public function getKeywords()
    {
        // $industries = Industry::pluck('category_name')->toArray();
        // $functionalRoles = FunctionalRole::pluck('subcategory_name')->toArray();
        $skills = JsSkill::distinct()->pluck('skill')->toArray();
        $designations = DesignationList::distinct()->pluck('designation')->toArray();
        // $companies = Empcompaniesdetail::pluck('company_name')->toArray();
        $jobManagers = Jobmanager::select('job_role', 'job_skills', 'title')->get();

        $roleSkillsJobTitle = $jobManagers->map(function ($query) {
        });

        $demo = array_merge($designations, $skills);

        return $demo;
    }
    public function getLocations()
    {
         $cities = Cities::where('state_id','<',  42)->groupBy('cities_name')->pluck('cities_name')->toArray();
        //  $master_location = DB::table('master_location')->pluck('location')->toArray();
        //$skills = JsSkill::pluck('skill')->toArray();
        // $companies = Empcompaniesdetail::pluck('company_name')->toArray();
        // $jobManagers = Jobmanager::select('job_role', 'job_skills', 'title')->get();

        // $roleSkillsJobTitle = $jobManagers->map(function ($query) {
        // });

        $demo = array_merge($cities);

        return $demo;
    }

    public function getJobseekerInfo($id)
    {
        $jobseeker = DB::table('employer_notifications')
            ->join('jobseekers', 'jobseekers.id', 'employer_notifications.jobseeker_id')
            ->join('jobmanagers', 'jobmanagers.id', 'employer_notifications.job_id')
            ->join('js_resumes', 'js_resumes.js_userid', 'jobseekers.id')
            ->select('jobseekers.id', 'jobseekers.profile_pic_thumb', 'jobseekers.fname', 'jobseekers.lname', 'jobseekers.contact', 'jobseekers.email', 'jobseekers.exp_year', 'jobseekers.exp_month', 'jobseekers.expected_salary', 'jobseekers.current_salary', 'jobseekers.preferred_location', 'js_resumes.resume', 'jobmanagers.title')
            ->where('jobseekers.id', $id)
            ->first();

        return response()->json($jobseeker);
    }
    public function testUpload(Request $request)
    {
        //dd($request->all());
        $userId = Session::get('user')['id'];
        $filename = time().'.'.$request->resume->extension();
        $path=public_path().'/resume/';
        $upload = $request->resume->move($path,$filename);

        $addressData = [
            'js_userid' => $userId,
            'resume' => $filename,
        ];

        JsResume::updateOrCreate(['js_userid' => $userId],$addressData);
    }
    public function testUploadImage(Request $request)
    {
       //dd($request->all());
        $userId = Session::get('user')['id'];
       // dd($userId);
        $filename = time().'.'.$request->image->extension();
        $path=public_path().'/jobseeker_profile_image/';
        $upload = $request->image->move($path,$filename);
        //dd($upload);
        $jobseekeer= Jobseeker::findorFail($userId);
        $jobseekeer->profile_pic_thumb = $filename;
        $jobseekeer->save();
    //     $profileData = [
    //         'id'=>$userId,
            
    //         'profile_pic_thumb' => $filename,
    //     ];
    //    // dd($profileData);
    //    try {
    //     $up =  DB::table
    //     $queryStatus = "Successful";
    // } catch(Exception $e) {
    //     $queryStatus = "Not success";
    // }
    // dd($queryStatus);
        
      // dd($up);
        //Jobseeker::updateOrCreate(['id'=>$userId], $profileData);
        
       
    }
}
