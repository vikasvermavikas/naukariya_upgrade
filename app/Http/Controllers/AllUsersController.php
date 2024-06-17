<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\States;
use App\Models\Cities;
use App\Models\Industry;
use App\Models\Empcompaniesdetail;
use App\Models\FunctionalRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Image;
use Mail;
use App\Mail\AddEmployer;
use App\Mail\UpdateEmployer;
use App\Mail\ActiveEmployer;
use App\Mail\DeactiveEmployer;
use App\Mail\CanEditCompany;
use App\Mail\CannotEditCompany;
use App\Mail\AddConsultant;
use App\Mail\UpdateConsultant;
use App\Exports\EmployerExport;
use App\Exports\ConsultantExport;
use Maatwebsite\Excel\Facades\Excel;

class AllUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        //to convert id to name
        $usertype = "Employer";
        $data = DB::table('all_users') //current table
        ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')//tablename,table.id,current table.field_name
        ->leftjoin('functional_roles', 'functional_roles.id', '=', 'all_users.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'all_users.fname', 'all_users.lname', 'all_users.company_id', 'all_users.contact', 'all_users.email', 'all_users.industry_id', 'all_users.functionalrole_id', 'all_users.username', 'all_users.can_edit_company', 'all_users.active', 'all_users.profile_pic_thumb', 'all_users.use_recruitment_service', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company


            ->where('all_users.user_type', $usertype)
            ->get();
        return response()->json(['data' => $data], 200);
        /*$data=AllUser::all();
        return response()->json(['data'=>$data],200);*/
    }

    public function index_consultant()
    {
        //to convert id to name
        $usertype = "Consultant";
        $data = DB::table('all_users') //current table
        ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')//tablename,table.id,current table.field_name
        ->leftjoin('functional_roles', 'functional_roles.id', '=', 'all_users.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'all_users.fname', 'all_users.lname', 'all_users.company_id', 'all_users.contact', 'all_users.email', 'all_users.industry_id', 'all_users.functionalrole_id', 'all_users.username', 'all_users.can_edit_company', 'all_users.active', 'all_users.use_recruitment_service', 'all_users.user_type', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company
            ->where('all_users.user_type', $usertype)
            ->get();
        return response()->json(['data' => $data], 200);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $employer = new AllUser();
        $strpos = strpos($request->profile_image, ';');
        $sub = substr($request->profile_image, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . "." . $ex;//request to insert in table field
        $img = Image::make($request->profile_image)->resize(370, 250);
        $upload_path = public_path() . "/emp_profile_image/";
        $img->save($upload_path . $name);// move to folder


        $employer->fname = $request->fname;
        $employer->lname = $request->lname;
        $employer->email = $request->email;
        $employer->password = $request->password;
        $employer->username = $request->username;
        $employer->contact = $request->contact;
        $employer->gender = $request->gender;
        $employer->company_id = $request->company_name;
        $employer->designation = $request->designation;
        $employer->industry_id = $request->industry_name;
        $employer->functionalrole_id = $request->functionalrole_name;
        $employer->dob = $request->dob;
        $employer->profile_pic_thumb = $name;
        $employer->user_type = "Employer";
        $employer->add_by = Auth::user()->id;

        //to convert id to name
        $usertype = "Employer";
        $data = DB::table('all_users') //current table
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')
            ->where('all_users.user_type', $usertype)
            ->first();

        //send mail//
        $myArray = json_decode(json_encode($data), true);
        $to = $request->email;
        //$subject='Enquiry Status';
        $name = $request->fname;
        $mobile = $request->contact;
        $emailid = $request->email;
        $password = $request->password;
        $company_name = $myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new AddEmployer($name, $mobile, $company_name, $password, $emailid));    //
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Employer account added Successfully.
        Your Company Name is -" . $company_name . "
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
        $employer->save();
    }

    public function store_consultant(Request $request)
    {
        $this->validate($request, [

            // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        $consultant = new AllUser();
        $strpos = strpos($request->profile_image, ';');
        $sub = substr($request->profile_image, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . "." . $ex;//request to insert in table field
        $img = Image::make($request->profile_image)->resize(370, 250);
        $upload_path = public_path() . "/consultant_profile_image/";
        $img->save($upload_path . $name);// move to folder


        $consultant->fname = $request->fname;
        $consultant->lname = $request->lname;
        $consultant->email = $request->email;
        $consultant->password = $request->password;
        $consultant->username = $request->username;
        $consultant->contact = $request->contact;
        $consultant->gender = $request->gender;
        $consultant->company_id = $request->company_name;
        $consultant->designation = $request->designation;
        $consultant->industry_id = $request->industry_name;
        $consultant->functionalrole_id = $request->functionalrole_name;
        $consultant->dob = $request->dob;
        $consultant->profile_pic_thumb = $name;
        $consultant->user_type = "Consultant";
        $consultant->add_by = Auth::user()->id;
        $usertype = "Consultant";
        $data = DB::table('all_users') //current table
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')
            ->where('all_users.user_type', $usertype)
            ->first();

        //send mail//
        $myArray = json_decode(json_encode($data), true);
        $to = $request->email;
        //$subject='Enquiry Status';
        $name = $request->fname;
        $mobile = $request->contact;
        $emailid = $request->email;
        $password = $request->password;
        $company_name = $myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new AddConsultant($name, $mobile, $company_name, $password, $emailid));    //
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRIYAN';
        $msg = "Dear " . $name . " ,
        Your consultant account added successfully.
        Your company name is -" . $company_name . "
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
        $consultant->save();

    }

    public function edit($id)
    {
        $data = AllUser::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function edit_consultant($id)
    {
        $data = AllUser::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'industry_name' => 'required',
            'functionalrole_name' => 'required',
        ]);

        $employer = AllUser::find($id);
        if ($request->profile_pic_thumb != $employer->profile_pic_thumb) {
            $strpos = strpos($request->profile_pic_thumb, ';');
            $sub = substr($request->profile_pic_thumb, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->profile_pic_thumb)->resize(200, 200);
            $upload_path = public_path() . "/emp_profile_image/";
            $image = $upload_path . $employer->profile_pic_thumb;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }

        } else {
            $name = $employer->profile_pic_thumb;
        }

        $employer->fname = $request->fname;
        $employer->lname = $request->lname;
        $employer->email = $request->email;
        $employer->password = $request->password;
        $employer->username = $request->username;
        $employer->contact = $request->contact;
        $employer->gender = $request->gender;
        $employer->company_id = $request->company_name;
        $employer->designation = $request->designation;
        $employer->industry_id = $request->industry_name;
        $employer->functionalrole_id = $request->functionalrole_name;
        $employer->dob = $request->dob;
        $employer->profile_pic_thumb = $name;
        $employer->add_by = Auth::user()->id;
        $usertype = "Employer";
        $data = DB::table('all_users') //current table
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')
            ->where('all_users.user_type', $usertype)
            ->first();

        //send mail//
        $myArray = json_decode(json_encode($data), true);
        $to = $request->email;
        $password = $request->password;
        //$subject='Enquiry Status';
        $name = $request->fname;
        $mobile = $request->contact;
        $company_name = $myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new UpdateEmployer($name, $mobile, $company_name, $to, $password));    //
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Employer account updated Successfully.
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
        $employer->save();
    }

    public function update_consultant(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'industry_name' => 'required',
            'functionalrole_name' => 'required',
        ]);

        $consultant = AllUser::find($id);
        if ($request->profile_pic_thumb != $consultant->profile_pic_thumb) {
            $strpos = strpos($request->profile_pic_thumb, ';');
            $sub = substr($request->profile_pic_thumb, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->profile_pic_thumb)->resize(200, 200);
            $upload_path = public_path() . "/consultant_profile_image/";
            $image = $upload_path . $consultant->profile_pic_thumb;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $name = $consultant->profile_pic_thumb;
        }

        $consultant->fname = $request->fname;
        $consultant->lname = $request->lname;
        $consultant->email = $request->email;
        $consultant->password = $request->password;
        $consultant->username = $request->username;
        $consultant->contact = $request->contact;
        $consultant->gender = $request->gender;
        $consultant->company_id = $request->company_name;
        $consultant->designation = $request->designation;
        $consultant->industry_id = $request->industry_name;
        $consultant->functionalrole_id = $request->functionalrole_name;
        $consultant->dob = $request->dob;
        $consultant->profile_pic_thumb = $name;
        $consultant->add_by = Auth::user()->id;
        $usertype = "Consultant";
        $data = DB::table('all_users') //current table
        ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')
            ->where('all_users.user_type', $usertype)
            ->first();

        //send mail//
        $myArray = json_decode(json_encode($data), true);
        $to = $request->email;
        //$subject='Enquiry Status';
        $name = $request->fname;
        $mobile = $request->contact;
        $emailid = $request->email;
        $password = $request->password;
        $company_name = $myArray['company_name'];

        if ($to != "") {
            Mail::to($to)->send(new UpdateConsultant($name, $mobile, $company_name, $password, $emailid));    //
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Consultant account updated Successfully.
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
        $consultant->save();
    }

    public function companyeditenable($id)
    {
        $alluser = AllUser::find($id);
        $alluser->can_edit_company = "Yes";

        $data = DB::table('all_users')
            ->select('id', 'email', 'fname', 'contact')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['email'];
        $name = $myArray['fname'];
        $mobile = $myArray['contact'];

        if ($to != "") {
            Mail::to($to)->send(new CanEditCompany($name));    //
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Company Details Edit feature is Enabled.
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
        $alluser->save();
    }

    public function companyeditdisable($id)
    {
        $alluser = AllUser::find($id);
        $alluser->can_edit_company = "No";
        $usertype = "Employer";
        $data = DB::table('all_users')
            ->select('id', 'email', 'fname', 'contact')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['email'];
        $name = $myArray['fname'];
        $mobile = $myArray['contact'];

        if ($to != "") {
            Mail::to($to)->send(new CannotEditCompany($name));
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Company Details Edit feature is Disabled.
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
        $alluser->save();
    }

    public function deactive($id)
    {
        $alluser = AllUser::find($id);
        $alluser->active = "No";
        $data = DB::table('all_users')
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
            Mail::to($to)->send(new DeactiveEmployer($name));    //same for active consultant
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRIYAN';
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
        $alluser->save();
    }

    public function active($id)
    {
        $alluser = AllUser::find($id);
        $alluser->active = "Yes";
        $data = DB::table('all_users')
            ->select('id', 'email', 'fname', 'contact', 'user_type')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['email'];
        $name = $myArray['fname'];
        $mobile = $myArray['contact'];
        $user_type = $myArray['user_type'];

        if ($to != "") {
            Mail::to($to)->send(new ActiveEmployer($name));    //same for active consultant
        }
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRIYAN';
        $msg = "Dear " . $name . " ,
        Your " . $user_type . " account now activated successfully.
        For any help just revert your message to admin@naukriyan.com.
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
        $alluser->save();
    }

    public function exportemployerdetails()
    {
        return Excel::download(new EmployerExport, 'employer.xlsx');
    }

    public function exportconsultantdetails()
    {
        return Excel::download(new ConsultantExport, 'consultant.xlsx');
    }

    // SELECTED USER IMPORTS

    public function exportSelectedConsultantDetail($id)
    {
        $ids = explode(',', $id);

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=employer-export.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $user_type = 'Consultant';
        $active = 'Yes';
        $list = DB::table('all_users')
            ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.fname', 'all_users.lname', 'all_users.email', 'all_users.gender', 'all_users.contact', 'industries.category_name', 'empcompaniesdetails.company_name', 'all_users.dob', 'all_users.created_at')
            ->where('all_users.user_type', $user_type)
            ->whereIn('all_users.id', $ids)
            ->orderBy('all_users.id', 'desc')
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

    public function exportSelectedEmployerDetail($id)
    {

        $ids = explode(',', $id);

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=employer-export.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $user_type = 'Employer';
        $list = DB::table('all_users')
            ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.fname', 'all_users.lname', 'all_users.email', 'all_users.gender', 'all_users.contact', 'industries.category_name', 'empcompaniesdetails.company_name', 'all_users.dob', 'all_users.created_at')
            ->where('all_users.user_type', $user_type)
            ->whereIn('all_users.id', $ids)
            ->orderBy('all_users.id', 'desc')
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

    public function filter(Request $request)
    {
        $usertype = "Employer";
        $data = DB::table('all_users')
        ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'all_users.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'all_users.fname', 'all_users.lname', 'all_users.company_id', 'all_users.contact', 'all_users.email', 'all_users.industry_id', 'all_users.functionalrole_id', 'all_users.username', 'all_users.can_edit_company', 'all_users.active', 'all_users.profile_pic_thumb', 'all_users.use_recruitment_service', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company
            ->where('all_users.user_type', $usertype);

        if (isset($request->industry_id) && $request->industry_id != '') {
            $data->Where('all_users.industry_id', $request->industry_id);
        }

        if (isset($request->company_id) && $request->company_id != '') {
            $data->Where('all_users.company_id', $request->company_id);
        }

        if (isset($request->email) && $request->email != '') {
            $data->Where('all_users.email', $request->email);
        }

        if (isset($request->status) && $request->status != '') {
            $data->Where('all_users.active', $request->status);
        }
        if (isset($request->from_date) && $request->from_date != '') {
            $data->Where('all_users.created_at', '>=', $request->from_date);
        }
        if (isset($request->to_date) && $request->to_date != '') {
            $data->Where('all_users.created_at', '<=', $request->to_date);
        }

        $data = $data->paginate(10);

        return response()->json(['data' => $data], 200);
    }

    public function filterConsultant(Request $request)
    {
        $usertype = "Consultant";
        $data = DB::table('all_users')
            ->leftjoin('industries', 'industries.id', '=', 'all_users.industry_id')
            ->leftjoin('functional_roles', 'functional_roles.id', '=', 'all_users.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('all_users.id', 'all_users.fname', 'all_users.lname', 'all_users.company_id', 'all_users.contact', 'all_users.email', 'all_users.industry_id', 'all_users.functionalrole_id', 'all_users.username', 'all_users.can_edit_company', 'all_users.active', 'all_users.profile_pic_thumb', 'all_users.use_recruitment_service', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company
            ->where('all_users.user_type', $usertype);

        if (isset($request->industry_id) && $request->industry_id != '') {
            $data->Where('all_users.industry_id', $request->industry_id);
        }

        if (isset($request->company_id) && $request->company_id != '') {
            $data->Where('all_users.company_id', $request->company_id);
        }

        if (isset($request->email) && $request->email != '') {
            $data->Where('all_users.email', $request->email);
        }

        if (isset($request->status) && $request->status != '') {
            $data->Where('all_users.active', $request->status);
        }

        $data = $data->paginate(10);

        return response()->json(['data' => $data], 200);
    }
}
