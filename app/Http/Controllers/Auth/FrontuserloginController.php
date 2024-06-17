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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'user_type' => 'required',
            // 'captcha' => 'required|captcha'
        ]);

        $user_type = $request->user_type;

        if ($user_type == "Jobseeker") {
            $data = DB::table('jobseekers')
                ->where('email', $request->email)
                ->where('user_type', $user_type)
                ->first();

            if (isset($data) && Auth::guard('jobseeker')->attempt(['email' => $request->email, 'password' => $request->password])) {
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
                    return redirect()->route('job_details');
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
                    return redirect()->route('login')->with('error', $errors);

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
                return redirect()->route('login')->with('error', $errors);
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
                    if ($data->active == 'Yes') {

                        Session::flush();
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

                        return response()->json(['data' => $data, 'status' => 'success'], 200);
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
                        return response()->json(['error' => $errors, 'status' => 'failed'], 400);
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

                    return response()->json(['error' => $errors, 'status' => 'failed'], 400);
                }
            } else {
                $errors = 'Username or password is invalid';
                //log mail table
                DB::table('loginlogs')->insert([
                    'username' => $request->email,
                    'ip_address' => $_SERVER['REMOTE_ADDR'], //change 60 to any length you want
                    'user_type' => $user_type,
                    'attempt_status' => 'failed',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()

                ]);

                return response()->json(['error' => $errors, 'status' => 'failed'], 400);
            }
        }
    }
}
