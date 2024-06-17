<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use Image;
use Mail;
use App\Mail\UpdateEnquiry;

class EnquiryController extends Controller
{

    public function index()
    {
        $data = Enquiry::orderBy('id', 'desc')->get();
        return response()->json(['data' => $data], 200);
    }

    public function edit($id)
    {
        $data = Enquiry::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'enq_status' => 'required',
        ]);

        $enquiry = Enquiry::find($id);
        $enquiry->enq_name = $request->enq_name;
        $enquiry->enq_email = $request->enq_email;
        $enquiry->enq_contact = $request->enq_contact;
        $enquiry->enq_type = $request->enq_type;
        $enquiry->enq_message = $request->enq_message;
        $enquiry->enq_usertype = $request->enq_usertype;
        $enquiry->enq_status = $request->enq_status;

        $enquiry->work_by = Auth::user()->id;
        //send mail//
        $myArray = json_decode(json_encode($enquiry), true);
        $to = $myArray['enq_email'];
        //$subject='Enquiry Status';
        $name = $myArray['enq_name'];
        $mobile = $myArray['enq_contact'];
        $enq_message = $myArray['enq_message'];
        $enq_status = $myArray['enq_status'];
        //$enq_type=$myArray['enq_type'];
        $enq_usertype = $myArray['enq_usertype'];

        if ($to != "") {
            Mail::to($to)->send(new UpdateEnquiry($name, $mobile, $enq_status, $enq_message, $enq_usertype));    //
        }
        //send sms
        $api_key = '35CD26D870005C';
        //$mobile = $myArray['mobile'];
        $from = 'NAUKRY';
        $msg = "Dear " . $name . " ,
        Your Enquiry Status is Updated Successfully.
        Your Enquiry status is -" . $enq_status . "
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

        $enquiry->save();
    }
}
