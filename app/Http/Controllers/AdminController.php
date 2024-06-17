<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Auth;
use DB;
use Mail;
use App\Mail\ChangePassword;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.admindash');
    }

    public function getpassword()
    {
        $change = new Admin();
        echo $pass = Auth::user()->password;
        echo $email = Auth::user()->email;
        echo $name = Auth::user()->name;
        echo $job_title = Auth::user()->job_title;
        return response()->json(['data' => $change], 200);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);

        $id = Auth::user()->id;
        $change = Admin::find($id);
        $change->password = Hash::make($request->confirm_password);//for database
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $mobile = Auth::user()->mobile;
        $new_pass = $request->confirm_password;//for mail
        $job_title = Auth::user()->job_title;

        if ($to != "") {
            Mail::to($to)->send(new ChangePassword($name, $job_title, $new_pass));
            return redirect('/')->with(Auth::logout());
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " (" . $job_title . ") ,
        Your Password changed Successfully.
        New Password is - " . $new_pass . " .
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
        $change->save();
    }
}
