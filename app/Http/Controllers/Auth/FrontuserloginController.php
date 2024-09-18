<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Response;
use Socialite;
use Illuminate\Support\Facades\Crypt;
use App\Rules\ReCaptchaV3;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;


class FrontuserloginController extends Controller
{
    //    public function __construct()
    //    {
    //        $this->middleware('guest:jobseeker');
    //    }

    public function refreshCaptcha()
    {
        // dd(captcha_img());
        // session([ captcha_img() => captcha_img()]);
        return response()->json(['captcha' => captcha_img()]);
    }


    public function check_contact($id)
    {
        $data = Jobseeker::select('contact')->where('contact', $id)->count();
        return response()->json(['data' => $data], 200);
    }

    public function check_email($id)
    {
        $data = Jobseeker::select('email')->where('email', $id)->count();
        return response()->json(['data' => $data], 200);
    }

    public function check_empcontact($id)
    {
        $data = AllUser::select('contact')->where('contact', $id)->count();
        return response()->json(['data' => $data], 200);
    }

    public function check_empemail($id)
    {
        $data = AllUser::select('email')->where('email', $id)->count();
        return response()->json(['data' => $data], 200);
    }

    public function loadLoginPage()
    {
        return view('loginemployer');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'user_type' => 'required',
            // 'captcha' => 'required|captcha'
        ]);

        $recaptcha_response = $request->input('g-recaptcha-response');
    
        $user_type = $request->user_type;
        $loginroute = '';
        if ($user_type == 'Jobseeker') {
            $loginroute = 'login';
        }
        if ($user_type == 'Employer') {
            $loginroute = 'loadLoginPage';

        }
        if (is_null($recaptcha_response)) {

            return redirect()->route($loginroute)->with(['error' => true, 'message' => 'Please Complete the Recaptcha to proceed']);
        }

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $body = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha_response,
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];
    
        $response = Http::asForm()->post($url, $body);
      
        $result = json_decode($response);

        if ($response->successful() && $result->success == true) {

            if ($user_type == "Jobseeker") {
                $data = DB::table('jobseekers')
                    ->where('email', $request->email)
                    ->where('user_type', $user_type)
                    ->first();
    
                if (isset($data) && Auth::guard('jobseeker')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                    if ($data->active == 'Yes') {
    
                        Session::put('user', ['id' => $data->id, 'fname' => $data->fname, 'lname' => $data->lname, 'email' => $data->email, 'user_type' => $data->user_type, 'last_login' => $data->last_login, 'profile_pic_thumb' => $data->profile_pic_thumb]);
                        //fetch last login and stored in table
                        $user = Jobseeker::find($data->id);
                        $user->last_login = Carbon::now();
                        $get_ip = $_SERVER['REMOTE_ADDR'];
    
                        $user->ip_address = $get_ip;
                        $user->save();
    
                        DB::table('loginlogs')->insert([
                            'user_id' => $data->id,
                            'username' => $request->email,
                            'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                            'user_type' => $user_type,
                            'attempt_status' => 'success',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
    
                        // return response()->json(['data' => $data, 'status' => 'success'], 200);
                        if ($request->jobid){
                            return redirect()->route('job_details', ['id' => $request->jobid]);
                        }
                        else {

                            return redirect()->route('AllDataForJobSeeker');
                        }
                    } else {
                        $errors = 'Your account is not activated by admin. Please contact.';
                        //log mail table
                        DB::table('loginlogs')->insert([
                            'user_id' => $data->id,
                            'username' => $request->email,
                            'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                            'user_type' => $user_type,
                            'attempt_status' => 'failed',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        return redirect()->route('login')->with(['error' => true, 'message' => $errors]);
                    }
                } else {
                    $errors = 'Username or password is invalid';
    
                    DB::table('loginlogs')->insert([
                        'username' => $request->email,
                        'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                        'user_type' => $user_type,
                        'attempt_status' => 'failed',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    return redirect()->back()->with(['error' => true, 'message' => $errors]);
                }
            }
    
            if ($user_type == "Employer") {
                $username = $request->email;
                $data = DB::table('all_users')
                    ->where('email', $username)
                    ->where('user_type', $user_type)
                    ->first();
                if (isset($data) && password_verify($request->password, $data->password)) {
                    if ($data->email_verified == 'Yes') {
                        if ($data->active == 'Yes' && Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                            // Session::flush();
                            Session::put('user', ['id' => $data->id, 'fname' => $data->fname, 'lname' => $data->lname, 'email' => $data->email, 'company_id' => $data->company_id, 'user_type' => $data->user_type, 'last_login' => $data->last_login, 'profile_pic_thumb' => $data->profile_pic_thumb]);
                            //fetch last login and stored in table
                            $user = AllUser::find($data->id);
                            $user->last_login = Carbon::now();
                            $user->save();
    
                            DB::table('loginlogs')->insert([
                                'user_id' => $data->id,
                                'username' => $request->email,
                                'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                                'user_type' => $user_type,
                                'attempt_status' => 'success',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                            return redirect()->route('dashboardemployer');
                        } else {
                            $errors = 'Your account is not activated by admin. Please contact.';
                            //log mail table
                            DB::table('loginlogs')->insert([
                                'user_id' => $data->id,
                                'username' => $request->email,
                                'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                                'user_type' => $user_type,
                                'attempt_status' => 'failed',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                            return redirect()->route('loadLoginPage')->with('error', $errors);
                        }
                    } else {
                        $errors = 'Email not verified';
                        //log mail table
                        DB::table('loginlogs')->insert([
                            'user_id' => $data->id,
                            'username' => $request->email,
                            'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                            'user_type' => $user_type,
                            'attempt_status' => 'failed',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
    
                        return redirect()->route('loadLoginPage')->with('error', $errors);
                    }
                } else {
                    $errors = 'Email or password is invalid';
                    //log mail table
                    DB::table('loginlogs')->insert([
                        'username' => $request->email,
                        'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                        'user_type' => $user_type,
                        'attempt_status' => 'failed',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
    
                    ]);
                    return redirect()->route('loadLoginPage')->with('error', $errors);
                }
            }
        }
        else if ($result->{'error-codes'}){

            return redirect()->route('login')->with(['error' => $result->{'error-codes'}[0]]);
        }
        else {
            return redirect()->route('login')->with(['error' => 'Captcha not validated']);
        }
    

      
    }
}
