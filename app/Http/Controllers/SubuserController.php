<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use Session;
use App\Models\SubUser;
use Illuminate\Http\Request;
use App\Models\Guftgu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class SubuserController extends Controller
{
    public function index() {
         $uid = Session::get('user')['id'];

       //  echo "huhu";die;

         $data= SubUser::where('created_by', $uid)
            ->OrderBy('created_at', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function GetGuftguList() {
      

        $data= Guftgu::get();

       return response()->json(['data' => $data], 200);
   }

   public function export(Request $request)
   {
       $empId= Session::get('user')['id'];
       $today = date('d-m-Y');

      // echo $keyskill;die;

       $headers = [
           'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
           'Content-type'        => 'text/csv',
           'Content-Disposition' => 'attachment; filename=Guftgu'.$today.'.csv',
           'Expires'             => '0',
           'Pragma'              => 'public'
       ];
       

       $list = Guftgu::get();
  
           $no =0;
           
       $list = collect($list)->map(function ($x ,$no)  { 
           $exp = $x->experience;
           if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $exp))
               {
                   $exp =str_replace('-', ' to ', $exp);
               }
           return [
               'S.No' => $no +1,
               'Name' => $x->name,
               'Email' => $x->email,
               'Contact' => $x->contact,
               'Company' => $x->company ? $x->company :'Not Available',
               'Designation' => $x->designation ? $x->designation :'Not Available',
               'Qualification' => $x->qualification ? $x->qualification:'Not Available',
               'Experience(in Yr)' => $x->experience ? $x->experience:'Not Available',
               'Expertise' => $x->expertise ? $x->expertise :'Not Available',
               'Location' => $x->location ? $x->location :'Not Available',
               'Linkedin' => $x->linkedin ? $x->linkedin :'Not Available',
               'Instagram' => $x->instagram ? $x->instagram :'Not Available',
               'Facebook' => $x->facebook ? $x->facebook :'Not Available',
               'Language' => $x->language ? $x->language :'Not Available',
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

    public function store(Request $request) {
       
       $uid = Session::get('user')['id'];
       $companyId = Session::get('user')['company_id'];

       $password = str_random(10);

       $subuser = New SubUser();
       $subuser->fname = $request->fname;
       $subuser->lname = $request->lname;
       $subuser->email = $request->email;
       $subuser->contact = $request->contact;
       $subuser->password_view = $password;
       $subuser->password = Hash::make($password);
       $subuser->designation = $request->designation;
       $subuser->gender = $request->gender;
       $subuser->company_id = $companyId;
       $subuser->created_by = $uid;
       $data = $subuser->save();
       if($data)
       {
        $email = $request->email;
         $userData =[
              'fname'=>$request->fname,
              'email'=>$email,
              'password'=>$password,
         ];
         
         Mail::send('SendMail.welcome-subuser', $userData, function ($message) use ($email) {
             
          $message->to($email)
              ->subject("Welcome Mail");
          $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
      });
       }


    }

    public function getsinglesubuser($id) {
        $subuser = SubUser::find($id);
        return $subuser;
    }

    public function update(Request $request, $id) {
       $subuser = SubUser::find($id);

       $subuser->fname = $request->fname;
       $subuser->lname = $request->lname;
       $subuser->email = $request->email;
       $subuser->contact = $request->contact;
       $subuser->designation = $request->designation;
       $subuser->gender = $request->gender;
       $subuser->save();
    }

    public function deactive($id)
    {
      SubUser::where(['id'=>$id])->update(['active'=>'0']);
    }
    public function active($id)
    {
      SubUser::where(['id'=>$id])->update(['active'=>'1']);

    }
    public function loginSubuser(Request $request)
    {
      //dd($request->all());
        $username = $request->email;
        $data = DB::table('sub_users')
            ->where('email', $username)
            ->first();

        if (isset($data) && password_verify($request->password, $data->password)) {

            // if ($data->active == '0') {
            //     return response()->json(['status' => 'account_deactive', 'message' => 'Your Account has been deactivated. Please contact your administrator'], 201);
            // }
  
            if ($data->active == '1') {
                Session::put('user', ['id' => $data->id, 'first_name' => $data->fname, 'last_name' => $data->lname, 'email' => $data->email, 'contact' => $data->contact, 'designation' => $data->designation, 'gender' => $data->gender, 'company_id' => $data->company_id]);
                return response()->json(['status' => 'success', 'message' => 'Login success'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Your account is not active. Please contact your administrator.'], 201);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'You have entered wrong credentials.'], 201);
        }
    }
    public function getSubuserData()
    {
        $uid = Session::get('user')['id'];
        
        $data = SubUser::join('all_users','all_users.id','sub_users.created_by')
        ->join('empcompaniesdetails','empcompaniesdetails.id','all_users.company_id')
        ->select('sub_users.*','empcompaniesdetails.company_name')->where('sub_users.id', $uid)->first();
        

        return response()->json(['data' => $data], 200);
    }
    public function updatePassword(Request $request)
    {
        $id = Session::get('user')['id'];

        $this->validate($request, [
           
            'new_password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8'
        ]);

        $change = SubUser::find($id);

        $change->password = Hash::make($request->confirm_password);
        $change->password_view = $request->confirm_password;//decrpt password

        $saved = $change->save();

        if ($saved) {
            return response()->json(['success' => 'Password Changed'], 200);
        }

        return response()->json(['error' => 'Something went wrong'], 200);
    }
    public function updateSubUserProfileImage(Request $request)
    {
        $authId = Session::get('user')['id'];
        $consultant = SubUser::where('id', $authId)->first();

        //$path = public_path(). '/subuser_profile_image';
        if(isset($request->image))
        {
            // $path = "subuser_profile_image/";
             $path = public_path(). '/subuser_profile_image/';

            if ($consultant->profile_image) {
                File::delete($path . $consultant->profile_image);

            }

            $filename = time().'.'.$request->image->extension(); //file name

            $consultantProfile = SubUser::where('id', $authId)->update(['profile_image' => $filename]);

            $upload= $request->image->move($path,$filename);

        
        }
        

    }
    public function checkEmail($email)
    {

        $data = SubUser::select('email')->where('email',$email)->first();
        //$res=sizeof($data)

        return response()->json([
            'data'=>$data
        ],200);
        
    }
    public function updateHimself(Request $request)
    {
        $authId = Session::get('user')['id'];

        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'contact' => $request->contact,
            'designation' => $request->designation,
            'gender' => $request->gender           
        ];

        $consultant = SubUser::where('id', $authId)->update($data);

        if (!$consultant) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Profile Update'], 200);
    }
    
}
