<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobseeker;
use App\Models\AllUser;
use Illuminate\Support\Str;
use DB;
use Mail;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password;
use Hash;
class ForgotPasswordController extends Controller
{

        public function SendResetLink(Request $request)
    {   
        $this->validate($request, [
            'role' => ['required', 'string'],
            'email' => ['required', 'email:filter']
        ]);
        
        $role = $request->role;
        $email = $request->email;

        if ($role === 'Jobseeker') {
            $checkEmail = Jobseeker::where('email', $email)->where('user_type', $role)->first();
            if (!$checkEmail) {
                return redirect()->route('forgot-password')->with(['error' => true, 'messages' => 'Email Not Exist']);
            }
        }

        if ($role === 'Employer') {
            $checkEmail = AllUser::where('email', $email)->where('user_type', $role)->first();
            if (!$checkEmail) {
                return redirect()->route('forgot-password')->with(['error' => true, 'messages' => 'Email Not Exist']);
            }
        }

        //create a new token to be sent to the user.
        $token = Str::random(60);

        DB::table('reset_passwords_user')->insert([
            'email' => $email,
            'user_type' => $role,
            'token' => $token, //change 60 to any length you want
            'created_at' => Carbon::now()
        ]);

        $data = [
            'token' => $token,
            'emailId' => $email,
        ];
      
        Mail::send('SendMail.reset-passworduser', ['userData' => $data], function ($message) use ($email) {
            $message->to($email)
                ->subject("Password Reset Link");
            $message->from(env('MAIL_USERNAME',"shivam2211lp@gmail.com"), 'Naukriyan.com');
            // $message->from(env('TEST_USEREMAIL'), "Naukriyan.com");
        });

        return redirect()->back()->with(['success' => true, 'messages' => 'Reset password link send successfully to your mail id.'], 200);
    }

    public function forgetPasswordForm($token)
    {
        return view('reset-password-user')->with(['token' => $token]);
    }


    public function forgetPasswordStore(Request $request)
    {

        $this->validate($request, [
            'password' => ['required', 'confirmed', 
            Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
            'password_confirmation' => ['required']
        ]);

        $password = $request->password;
        $token = $request->urlToken;
        $password = Hash::make($password);

        // CHECK TOKEN IS EXIST
        $checkToken = DB::table('reset_passwords_user')->where('token', $token)->where('status', 0)->first();

        if (!$checkToken) {
            return back()->with(['error' => true, 'messages' => 'Token mismatch or password already reset.']);
        }

        // TOKEN EXPIRY CHECK
        $tokenExpiry = DB::table('reset_passwords_user')->where('token', $token)->where('status', 0)->where('created_at', '>', Carbon::now()->subHours(1))->first();

        if (!$tokenExpiry) {
            return back()->with(['error' => true, 'messages' => 'Token Expire']);
        }

        $updateResetPassword = '';

        if ($tokenExpiry->user_type == 'Jobseeker') {
            $updateResetPassword = Jobseeker::where('email', $checkToken->email)->update(['password' => $password]);
        } else if ($tokenExpiry->user_type == 'Employer') {
            $updateResetPassword = AllUser::where('email', $checkToken->email)->where('user_type', $tokenExpiry->user_type)->update(['password' => $password]);
        } 

        if (!$updateResetPassword) {
            return redirect()->back()->with(['error' => true, 'messages' => 'Something went wrong.']);
        }

        DB::table('reset_passwords_user')->where('token', $token)->update(['status' => 1]);

        return redirect()->back()->with(['success' => true, 'messages' => 'Your password has been changed Successfully.'], 200);
    }
}
