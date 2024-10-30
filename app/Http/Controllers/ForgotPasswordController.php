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
use throwable;

class ForgotPasswordController extends Controller
{

        public function SendResetLink(Request $request)
    {   
        try {
            $this->validate($request, [
            'role' => ['required', 'string'],
            'email' => ['required', 'email:filter']
        ]);
        
        $role = $request->role;
        $email = $request->email;
        if ($role === 'Jobseeker') {
                $redirectlink = route('login');

            $checkEmail = Jobseeker::where('email', $email)->where('user_type', $role)->first();
            if (!$checkEmail) {
                return response()->json(['error' => true, 'messages' => 'Email Not Exist']);
                // return redirect()->route('forgot-password')->with(['error' => true, 'messages' => 'Email Not Exist']);
            }
        }

        if ($role === 'Employer') {
        $redirectlink = route('loadLoginPage');

            $checkEmail = AllUser::where('email', $email)->where('user_type', $role)->first();
            if (!$checkEmail) {
                return response()->json(['error' => true, 'messages' => 'Email Not Exist']);
                // return redirect()->route('forgot-password')->with(['error' => true, 'messages' => 'Email Not Exist']);
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

        return response()->json(['success' => true, 'messages' => 'Reset password link send successfully to your mail id.', 'redirect' => $redirectlink]);
        }

        catch(throwable $e){
             return response()->json(['error' => true, 'messages' => 'Server Error, contact to administrator.']);
        }
        

        // return redirect()->back()->with(['success' => true, 'messages' => 'Reset password link send successfully to your mail id.'], 200);
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
            return response()->json(['error' => true, 'message' => 'Token mismatch or password already reset.']);
        }

        // TOKEN EXPIRY CHECK
        $tokenExpiry = DB::table('reset_passwords_user')->where('token', $token)->where('status', 0)->where('created_at', '>', Carbon::now()->subHours(1))->first();

        if (!$tokenExpiry) {
            return response()->json(['error' => true, 'message' => 'Token Expire']);
        }

        $updateResetPassword = '';
        $redirectlink = '';
        if ($tokenExpiry->user_type == 'Jobseeker') {
            $redirectlink = route('login');
            $username = Jobseeker::select(DB::raw('CONCAT(fname, " ", lname) as username'))->where('email', $checkToken->email)->first()->username;
            $updateResetPassword = Jobseeker::where('email', $checkToken->email)->update(['password' => $password]);
        } else if ($tokenExpiry->user_type == 'Employer') {
            $redirectlink = route('loadLoginPage');
               $username = AllUser::select(DB::raw('CONCAT(fname, " ", lname) as username'))->where('email', $checkToken->email)->first()->username;
            $updateResetPassword = AllUser::where('email', $checkToken->email)->where('user_type', $tokenExpiry->user_type)->update(['password' => $password]);
        } 

        if (!$updateResetPassword) {
            return response()->json(['error' => true, 'message' => 'Something went wrong.']);
        }

        // DB::table('reset_passwords_user')->where('token', $token)->update(['status' => 1]);

        // Send email to user of change password successfully.

        Mail::send('SendMail.password-changed', ['username' => $username, 'redirectlink' => $redirectlink], function ($message) use ($checkToken) {
            $message->to($checkToken->email)
                ->subject("Password Changed Successfully");
            $message->from(env('MAIL_USERNAME',"shivam2211lp@gmail.com"), 'Naukriyan.com');
            // $message->from(env('TEST_USEREMAIL'), "Naukriyan.com");
        });
        return response()->json(['success' => true, 'message' => 'Your password has been changed Successfully.', 'redirect' => $redirectlink], 200);
    }

    public function get_form(Request $request)

    {
           $formtoken = $request->{'_token'};
 
           $currenttoken = csrf_token();

           if($formtoken == $currenttoken){
              $this->validate($request, [
            '_token' => 'required'
        ]);
        return view('forgotPassword');
           }
           return redirect('/');

      
    }
}
