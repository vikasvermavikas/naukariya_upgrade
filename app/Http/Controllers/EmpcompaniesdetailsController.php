<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empcompaniesdetail;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Image;
use Mail;
use App\Mail\AddCompany;
use App\Mail\UpdateCompany;
use App\Mail\ActiveCompany;
use App\Mail\DeactiveCompany;
use App\Exports\CompanyExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JsProfessionalDetail;

class EmpcompaniesdetailsController extends Controller
{
    public function allCompaniesList(){
        $companies = Empcompaniesdetail::whereNotNull('company_name')->pluck('company_name')->toArray();
        $user_companies =JsProfessionalDetail::whereNotNull('organisation')->pluck('organisation')->toArray();

        $com_unq =array_unique($companies);
        $user_unq =array_unique($user_companies);
        $demo = array_merge($com_unq, $user_unq);
        $demo = array_unique($demo);

        // return $demo;
        // $companies = Empcompaniesdetail::pluck('company_name')->toArray();
        // $user_companies =JsProfessionalDetail::pluck('organisation')->toArray();

        // $com_unq =array_unique($companies);
        // $user_unq =array_unique($user_companies);
        // $demo = array_merge($com_unq, $user_unq);


        // return $demo;
        return response()->json(['data' => $demo], 200);
        
    }
    public function index()
    {
        $data = DB::table('empcompaniesdetails') //current table
        ->leftjoin('industries', 'industries.id', '=', 'empcompaniesdetails.company_industry')//tablename,table.id,current table.field_name
        ->select('empcompaniesdetails.id', 'empcompaniesdetails.company_name', 'empcompaniesdetails.com_contact', 'empcompaniesdetails.com_email', 'empcompaniesdetails.cin_no', 'empcompaniesdetails.no_of_employee', 'empcompaniesdetails.marked_top', 'empcompaniesdetails.marked_featured', 'industries.category_name', 'empcompaniesdetails.active')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company
        ->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $strpos = strpos($request->company_logo, ';');
        $sub = substr($request->company_logo, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . "." . $ex;//request to insert in table field
        $img = Image::make($request->company_logo)->resize(370, 250);
        //$upload_path = public_path()."/company_logo/";
        $upload_path = public_path() . "/company_logo/";
        $img->save($upload_path . $name);// move to folder

        $strpos1 = strpos($request->cover_image, ';');
        $sub1 = substr($request->cover_image, 0, $strpos1);
        $ex1 = explode('/', $sub1)[1];
        $name1 = time() . "." . $ex1;//request to insert in table field
        $img1 = Image::make($request->cover_image)->resize(370, 250);
        $upload_path1 = public_path() . "/company_cover/";
        $img1->save($upload_path1 . $name1);// move to folder

        /* $strpos2 = strpos($request->company_video,';');
         $sub2 = substr($request->company_video,0,$strpos2);
         $ex2 = explode('/',$sub2)[1];
         $name2 = time().".".$ex2;//request to insert in table field
         $img2 = Image::make($request->company_video)->resize(370, 250);
         $upload_path2 = public_path()."/company_video/";
         $img2->save($upload_path2.$name2);// move to folder*/

        $companies = new Empcompaniesdetail();
        $companies->company_name = $request->company_name;
        $companies->company_industry = $request->company_industry;
        $companies->company_state = $request->company_state;
        $companies->company_city = $request->p_city_id;
        $companies->address = $request->address;
        $companies->establish_date = $request->establish_date;
        $companies->com_email = $request->company_email;
        $companies->com_contact = $request->company_contact;
        $companies->about = $request->about;
        $companies->no_of_employee = $request->no_of_employee;
        $companies->website = $request->website;
        $companies->company_capital = $request->company_capital;
        $companies->cin_no = $request->cin_no;
        $companies->tagline = $request->tagline;
        $companies->owner_name = $request->owner_name;
        $companies->company_logo = $name;
        $companies->cover_image = $name1;
        //$companies->company_video = $name2;
        $companies->add_by = Auth::user()->id;
        /*Send Mail*/
        $myArray = json_decode(json_encode($companies), true);
        $to = $myArray['com_email'];
        $name = $myArray['company_name'];
        $mobile = $myArray['com_contact'];

        if ($to != "") {
            Mail::to($to)->send(new AddCompany($name, $mobile));
        }
        //send sms
        $api_key = '35CD26D870005C';
//$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Hello " . $name . " ,
Your Company Details Added Successfully.
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
        $companies->save();
    }

    public function edit($id)
    {
        $data = Empcompaniesdetail::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $companies = Empcompaniesdetail::find($id);
        if ($request->company_logo != $companies->company_logo) {
            $strpos = strpos($request->company_logo, ';');
            $sub = substr($request->company_logo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->company_logo)->resize(200, 200);
            $upload_path = public_path() . "/company_logo/";
            $image = $upload_path . $companies->company_logo;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }

        } else {
            $name = $companies->company_logo;
        }

        //company cover
        if ($request->cover_image != $companies->cover_image) {
            $strpos1 = strpos($request->cover_image, ';');
            $sub1 = substr($request->cover_image, 0, $strpos1);
            $ex1 = explode('/', $sub1)[1];
            $name1 = time() . "." . $ex1;
            $img1 = Image::make($request->cover_image)->resize(200, 200);
            $upload_path1 = public_path() . "/company_cover/";
            $image1 = $upload_path1 . $companies->cover_image;
            $img1->save($upload_path1 . $name1);

            if (file_exists($image1)) {
                @unlink($image1);
            }
        } else {
            $name1 = $companies->cover_image;
        }

        $companies->company_name = $request->company_name;
        $companies->company_industry = $request->company_industry;
        $companies->company_state = $request->company_state;
        $companies->company_city = $request->company_city;
        $companies->address = $request->address;
        $companies->establish_date = $request->establish_date;
        $companies->com_email = $request->com_email;
        $companies->com_contact = $request->com_contact;
        $companies->about = $request->about;
        $companies->no_of_employee = $request->no_of_employee;
        $companies->website = $request->website;
        $companies->company_capital = $request->company_capital;
        $companies->cin_no = $request->cin_no;
        $companies->tagline = $request->tagline;
        $companies->owner_name = $request->owner_name;
        $companies->company_logo = $name;
        $companies->cover_image = $name1;
        $companies->add_by = Auth::user()->id;
        /*Send Mail*/
        $myArray = json_decode(json_encode($companies), true);
        $to = $myArray['com_email'];
        $name = $myArray['company_name'];
        $mobile = $myArray['com_contact'];

        if ($to != "") {
            Mail::to($to)->send(new UpdateCompany($name, $mobile));
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRIYAN';
        $msg = "Hello " . $name . " ,
        Your Company Details Updated Successfully.
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
        $companies->save();
    }

    public function destroy($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->delete();
    }

    public function deactive($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->active = "No";
        $data = DB::table('empcompaniesdetails')
            ->select('id', 'company_name', 'com_email', 'com_contact')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['com_email'];
        $company_name = $myArray['company_name'];
        $mobile = $myArray['com_contact'];

        if ($to != "") {
            Mail::to($to)->send(new DeactiveCompany($company_name, $mobile));
        }

        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRIYAN';
        $msg = "Hello " . $company_name . " ,
        Your Company De-activated Successfully.
        Please contact Admin for the reason of de-activating account.
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
        $companies->save();
    }

    public function active($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->active = "Yes";
        $data = DB::table('empcompaniesdetails')
            ->select('id', 'company_name', 'com_email', 'com_contact')
            ->where('id', $id)
            ->first();

        $myArray = json_decode(json_encode($data), true);
        $to = $myArray['com_email'];
        $company_name = $myArray['company_name'];

        $mobile = $myArray['com_contact'];

        if ($to != "") {

            Mail::to($to)->send(new ActiveCompany($company_name, $mobile));    //
        }
        //send sms
        /* $api_key = '35CD26D870005C';
       //$mobile = $myArray['mobile'];
       $from = 'NAUKRY';
       $msg="Hello ". $company_name." ,
       Your Company Now Activated Successfully.
       Best of luck.
       Team
       Naukriyan.com";
       $sms_text = urlencode($msg);



       //Submit to server
       $ch = curl_init();
       curl_setopt($ch,CURLOPT_URL, "http://sms.sbcinfotech.com/app/smsapi/index.php");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=7246&routeid=100922&type=text&contacts=".$mobile."&senderid=".$from."&msg=".$sms_text);
       $response = curl_exec($ch);
       curl_close($ch);
       echo $response; */
//sms close
        $companies->save();
    }

    public function getcity($id)
    {
        $data = Cities::select('id', 'cities_name', 'status')->where('state_id', $id)->get();
        return response()->json(['data' => $data], 200);
    }

    public function geteditcompanycity($id)
    {
        $data = DB::table('empcompaniesdetails')
            ->leftjoin('cities', 'cities.state_id', '=', 'empcompaniesdetails.company_state')
            ->select('cities.id', 'cities.cities_name', 'cities.status')
            ->where('empcompaniesdetails.id', $id)
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function markedtopenable($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->marked_top = "Yes";

        $companies->save();
    }

    public function markedtopdisable($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->marked_top = "No";

        $companies->save();
    }

    public function markedfeaturedenable($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->marked_featured = "Yes";

        $companies->save();
    }

    public function markedfeatureddisable($id)
    {
        $companies = Empcompaniesdetail::find($id);
        $companies->marked_featured = "No";

        $companies->save();
    }

    public function exportcompanydetails()
    {
        return Excel::download(new CompanyExport, 'companyexcel.xlsx');
    }

    public function exportcompanydetailschecked($id)
    {

        $ids = explode(',', $id);

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=user-export.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $list = DB::table('empcompaniesdetails')
            ->leftJoin('industries', 'industries.id', '=', 'empcompaniesdetails.company_industry')
            ->select('empcompaniesdetails.company_name', 'empcompaniesdetails.com_contact', 'empcompaniesdetails.com_email', 'industries.category_name', 'empcompaniesdetails.cin_no', 'empcompaniesdetails.no_of_employee', 'empcompaniesdetails.created_at')
            ->whereIn('empcompaniesdetails.id', $ids)
            ->orderBy('empcompaniesdetails.id', 'desc')
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

    public function getEmployeeRange()
    {
        $employeeRange = Empcompaniesdetail::select('id', 'no_of_employee')->get();
        return response()->json($employeeRange);
    }

    public function getCompaniesList()
    {
        $companies = Empcompaniesdetail::select('id', 'company_name')->get();
        return response()->json($companies);
    }

    public function filter(Request $request)
    {

        $data = DB::table('empcompaniesdetails') //current table
        ->leftjoin('industries', 'industries.id', '=', 'empcompaniesdetails.company_industry')//tablename,table.id,current table.field_name
        ->select('empcompaniesdetails.id', 'empcompaniesdetails.company_name', 'industries.category_name', 'empcompaniesdetails.com_contact', 'empcompaniesdetails.com_email', 'empcompaniesdetails.cin_no', 'empcompaniesdetails.no_of_employee', 'empcompaniesdetails.marked_top', 'empcompaniesdetails.marked_featured', 'industries.category_name', 'empcompaniesdetails.active')->orderBy('id', 'desc'); //use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company

        if (isset($request->industry_id) && $request->industry_id != '') {
            $data->Where('empcompaniesdetails.company_industry', $request->industry_id);
        }

        if (isset($request->employee_range) && $request->employee_range != '') {
            $data->Where('empcompaniesdetails.no_of_employee', '=', $request->employee_range);
        }

        if (isset($request->cin_no) && $request->cin_no != '') {
            $data->Where('empcompaniesdetails.cin_no', $request->cin_no);
        }

        if (isset($request->status) && $request->status != '') {
            $data->Where('empcompaniesdetails.active', $request->status);
        }

        $data = $data->paginate(10);

        return response()->json(['data' => $data], 200);
    }

    public function getTopEmployers()
    {
        $topEmployers = Empcompaniesdetail::Active('Yes')->Top('Yes')->take(10)->get();
        if (count($topEmployers) > 0) {
            return response()->json(['status' => 'Success', 'data' => $topEmployers], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => 'No data found'], 200);
        }
    }

    public function topEmployers()
    {
        $topEmployers = Empcompaniesdetail::orderBy('company_name', 'DESC')->get();
        if (count($topEmployers) > 0) {
            return response()->json(['status' => 'Success', 'data' => $topEmployers], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => 'No data found'], 200);
        }
    }

    public function updateEmployerStatus($status, $id)
    {
        $employer = Empcompaniesdetail::where('id', $id)->update(['active' => $status]);

        if ($employer) {
            return response()->json(['status' => 'Success', 'data' => 'Company Status Changed'], 200);
        }
    }

    public function markTopEmployer($status, $id)
    {
        $employer = Empcompaniesdetail::where('id', $id)->update(['marked_top' => $status]);

        if ($employer) {
            return response()->json(['status' => 'Success', 'data' => 'Company Mark as Top'], 200);
        }
    }

    public function changePosition($position, $id)
    {
        $employer = Empcompaniesdetail::where('id', $id)->update(['position' => $position]);

        if (!$employer) {
            return response()->json(['status' => 'error', 'data' => 'Company Position Not Changed'], 201);
        }

        return response()->json(['status' => 'Success', 'data' => 'Company Position Changed'], 200);
    }

    public function getCompaniesLists()
    {
        return Empcompaniesdetail::select('id', 'company_name')->where(['active' => 'Yes', 'status' => '1'])->orderBy('company_name', 'ASC')->get();
    }

}
