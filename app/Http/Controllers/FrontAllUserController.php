<?php

namespace App\Http\Controllers;

use App\Models\Packagemanager;
use App\Models\PackageSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\States;
use App\Models\Cities;
use App\Models\Industry;
use App\Models\Empcompaniesdetail;
use App\Models\FunctionalRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;
use Session;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;


class FrontAllUserController extends Controller
{

    public function companies()
    {
        $data['companies'] = Empcompaniesdetail::all();
        $data['last_company_id'] = Empcompaniesdetail::all()->last();
        return response()->json(['data' => $data], 200);
    }

    public function unique_company()
    {
        $data = Empcompaniesdetail::all()->last();
        return response()->json(['data' => $data], 200);
    }

    public function index()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public/index', compact('companies', 'last_company_id'));
    }

    public function contactus()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.contactus', compact('companies', 'last_company_id'));
    }

    public function aboutus()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.aboutus', compact('companies', 'last_company_id'));
    }

    public function advertise()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.advertisewithus', compact('companies', 'last_company_id'));
    }

    public function faqs()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.faqs', compact('companies', 'last_company_id'));
    }

    public function privacypolicy()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.privacypolicy', compact('companies', 'last_company_id'));
    }

    public function termcondition()
    {
        $companies = Empcompaniesdetail::all();
        $last_company_id = Empcompaniesdetail::all()->last();
        return view('public.termcondition', compact('companies', 'last_company_id'));
    }

    public function forgetpassword()
    {
        $companies = Empcompaniesdetail::all();

        $last_company_id = Empcompaniesdetail::all()->last();

        return view('public.forgetpassword', compact('companies', 'last_company_id'));
    }


    public function employerRegister(){
        $companies = Empcompaniesdetail::select('id','company_name')->get();
        return view('register-employer',compact('companies'));
    }
    public function store(Request $request)
    {

       

        $validator = $request->validate(
            [
                'firstname' => 'required|regex:/^[a-zA-Z]+$/u',
                'lastname' => 'required|regex:/^[a-zA-Z]+$/u',
                // "designation" => 'required',
                "email" => 'required|unique:jobseekers,email',
                "mobile" => 'required|min:10|max:12|unique:jobseekers,contact',
                "password" => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
                "gender" => 'required|string',
                // 'usertype.required' => 'User type is required', rakesh 18/06/2024
                // "com_search" => 'required',
                "company_id" => 'required'
                // 'captcha' => 'required|captcha'
            ],
            [
                'firstname.required' => 'First name is required.',
                'lastname.required' => 'Last name is required',
                // 'designation.required' => 'Designation is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email is already registered',
                'mobile.required' => 'Mobile is required',
                'mobile.unique' => 'Mobile is already registered',
                'password.required' => 'Password is required',
                'gender.required' => 'Gender is required',
                // 'usertype.required' => 'User type is required', rakesh 18/06/2024
                'company_id.required' => 'Company name is required',
                // 'captcha.captcha'=>'Invalid captcha code.'
               
            ]
        );
        // dd($request);
        // if ($validator->fails()) {
        //     return Response::json(array(
        //         'success' => false,
        //         'errors' => $validator->getMessageBag()->toArray()
        //     ), 400);
        // }


        
        if (isset($request->other)) {
            $input_company = new Empcompaniesdetail();
            $input_company->company_name = $request->other;
            $input_company->save();
        }

        if (isset($request->other)) {
            $comp_id = $input_company->id;
        } else {
            $comp_id = $request->company_id;
        }

        $alluser = new AllUser();

        $alluser->fname = $request->firstname;
        $alluser->lname = $request->lastname;
        $alluser->email = $request->email;
        $enc_password = $request->password;
        $alluser->password = Hash::make($enc_password);
        $alluser->contact = $request->mobile;
        $alluser->gender = $request->gender;
        $alluser->sign_in_through  = 'normal';

        $alluser->designation = $request->designation;
        $alluser->company_id = $comp_id;
        $alluser->user_type = $request->user_type;

        $email = $request->email;
        $name = $request->firstname;

        if ($alluser->save()) {
            $data = [
                'token' => Crypt::encryptString($request->email),
                'emailId' => $email,
                'name' => $name
            ];

            // Mail::send(
            //     'SendMail.email-verification-link',
            //     ['userData' => $data],
            //     function ($message) use ($email) {
            //         $message->to($email)
            //             ->subject("Email Verification Link");
            //         //$message->from(env('TEST_USEREMAIL'), "Naukriyan.com");
            //         $message->from(env('MAIL_USERNAME'), "Naukriyan.com");
            //     }
            // );

            // FETCH WELCOME PACKAGE
            $package = Packagemanager::where('package_price', 0)->where('package_for', 'All')->first();

            // ASSOCIATE PACKAGE WITH USER
            $today = Carbon::now();
            $userPackage = new PackageSubscription();
            $userPackage->package_id = $package->id;
            $userPackage->user_id = $alluser->id;
            $userPackage->user_type = $request->usertype;
            $userPackage->package_expiry_date = $today->addDays($package->validity);
            $userPackage->save();
        }
        //return redirect('/#/register-success');
        return redirect()->route('employer-register')->with('success', 'Account Created Successfully');
        // return response()->json(['status' => 'success', 'message' => 'Account Created Successfully'], 200);
    }

    public function EmailVerify($token)
    {
        $email = Crypt::decryptString($token);
        $checkEmail = AllUser::where('email', $email)->update(['email_verified' => 'Yes']);

        if ($checkEmail) {
            return redirect('/#/Verified');
        }
    }

    public function update_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::guard('employer')->user()->password)) {
                    $fail('Old Password didn\'t match');
                }
            }],
            'new_password' => ['required', 'required_with:confirm_password', 'same:confirm_password', Password::min(8), Password::min(8)->letters(), Password::min(8)->mixedCase(), Password::min(8)->numbers(), Password::min(8)->symbols()],
            'confirm_password' => 'required|min:8'
        ]);

        $id = Auth::guard('employer')->user()->id;
        // $email = Auth::guard('employer')->user()->email;
        $change = AllUser::find($id);

        $change->password = Hash::make($request->confirm_password);

        //for database
        $saved = $change->save();

        if ($saved) {
            Auth::logoutOtherDevices($request->new_password);
            // return response()->json(['success' => 'Password Changed'], 200);
            return redirect()->route('employer_change_password')->with(['success' => 'Password Changed Successfully']);
        }
        
        return redirect()->route('employer_change_password')->with(['errorsuccess' => 'Something went wrong']);
    }

    public function employer_change_password(){
        return view('employer.change_password');
    }
}
