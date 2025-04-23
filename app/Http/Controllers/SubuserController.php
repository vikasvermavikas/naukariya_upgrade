<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Session;
use App\Models\SubUser;
use Illuminate\Http\Request;
use App\Models\Guftgu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;

class SubuserController extends Controller
{
    public $userid;
    public $companyid;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('employer')->check()) {
                $this->userid = Auth::guard('employer')->user()->id;
                $this->companyid = Auth::guard('employer')->user()->company_id;
            }
            return $next($request);
        });
    }
    public function index()
    {
        $uid = $this->userid;

        $data = SubUser::where('created_by', $uid)
            ->OrderBy('created_at', 'DESC')
            ->paginate(10);

        // return response()->json(['data' => $data], 200);
        return view('employer.subuser', ['subusers' => $data]);
    }

    public function GetGuftguList()
    {


        $data = Guftgu::get();

        return response()->json(['data' => $data], 200);
    }

    public function export(Request $request)
    {
        $empId = $this->userid;
        $today = date('d-m-Y');

        // echo $keyskill;die;

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=Guftgu' . $today . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];


        $list = Guftgu::get();

        $no = 0;

        $list = collect($list)->map(function ($x, $no) {
            $exp = $x->experience;
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $exp)) {
                $exp = str_replace('-', ' to ', $exp);
            }
            return [
                'S.No' => $no + 1,
                'Name' => $x->name,
                'Email' => $x->email,
                'Contact' => $x->contact,
                'Company' => $x->company ? $x->company : 'Not Available',
                'Designation' => $x->designation ? $x->designation : 'Not Available',
                'Qualification' => $x->qualification ? $x->qualification : 'Not Available',
                'Experience(in Yr)' => $x->experience ? $x->experience : 'Not Available',
                'Expertise' => $x->expertise ? $x->expertise : 'Not Available',
                'Location' => $x->location ? $x->location : 'Not Available',
                'Linkedin' => $x->linkedin ? $x->linkedin : 'Not Available',
                'Instagram' => $x->instagram ? $x->instagram : 'Not Available',
                'Facebook' => $x->facebook ? $x->facebook : 'Not Available',
                'Language' => $x->language ? $x->language : 'Not Available',
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

    public function store(Request $request)
    {

        $request->validate([
            'fname' => 'required|alpha:ascii',
            // 'lname' => 'required|alpha:ascii',
            'email' => 'required|email:filter|unique:sub_users,email',
            'contact' => 'required|numeric|min:10',
            'designation' => [
                'required',
                'regex:/(^[A-Za-z ]+$)+/'
            ],
            'gender' => 'required|alpha:ascii',
        ],
        [
            'fname.required' => 'First name is required.',
            'fname.alpha' => 'First name should contain only alphabets.',
            'lname.required' => 'Last name is required.',
            'lname.alpha' => 'Last name should contain only alphabets.',
            'designation.alpha' => 'Designation should contain only alphabets.',
            'designation.regex' => 'Invalid Designation',

        ]
    );

        $uid = $this->userid;
        $companyId = $this->companyid;

        $password = Str::random(10);

        $subuser = new SubUser();
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
        if ($data) {
            $email = $request->email;
            $userData = [
                'fname' => $request->fname,
                'email' => $email,
                'password' => $password,
            ];

            Mail::send('SendMail.welcome-subuser', $userData, function ($message) use ($email) {

                $message->to($email)
                    ->subject("Welcome Mail");
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            });
        }

        return redirect()->route('get_subusers')->with(['message' => 'Sub User created successfully.']);
    }

    public function getsinglesubuser($id)
    {
        $subuser = SubUser::find($id);
        return $subuser;
    }

    public function update(Request $request)
    {
        $request->validate([
            'updatefname' => 'required|alpha:ascii',
            // 'updatelname' => 'required|alpha:ascii',
            'updateemail' => [
                'required',
                'email:filter',
                Rule::unique('sub_users', 'email')->ignore($request->id),
            ],
            'updatecontact' => 'required|numeric|min:10',
            'updatedesignation' => [
                'required',
                'regex:/(^[A-Za-z ]+$)+/'
            ],
            'updategender' => 'required',
            'password' => ['nullable', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => ['required_with:password'] 
        ],
        [
            'updatefname.required' => 'First name is required.',
            'updatefname.alpha' => 'First name should contain only alphabets.',
            'updatelname.required' => 'Last name is required.',
            'updatelname.alpha' => 'Last name should contain only alphabets.',
            'updatedesignation.regex' => 'Invalid Designation',
        ]
    );
        
            $subuser = SubUser::find($request->id);

        $subuser->fname = $request->updatefname;
        $subuser->lname = $request->updatelname;
        $subuser->email = $request->updateemail;
        $subuser->contact = $request->updatecontact;
        $subuser->designation = $request->updatedesignation;
        $subuser->gender = $request->updategender;
        if ($request->password) {
        $subuser->password = Hash::make($request->password);
        $subuser->password_view = $request->password; //decrpt password
        }
        $subuser->save();
        return redirect()->route('get_subusers')->with(['message' => 'Sub User updated successfully.']);
    }

    public function deactive($id)
    {
        SubUser::where(['id' => $id])->update(['active' => '0']);
        return redirect()->route('get_subusers')->with(['message' => 'Sub User deactivated successfully.']);
    }
    public function active($id)
    {
        SubUser::where(['id' => $id])->update(['active' => '1']);
        return redirect()->route('get_subusers')->with(['message' => 'Sub User activated successfully.']);
    }
    public function loginSubuser(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'email' => 'required|email',
            'password' => ['required'],
            'g-recaptcha-response' => ['required'],
        ]);
        $recaptcha_response = $request->input('g-recaptcha-response');

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $body = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha_response,
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];

        $response = Http::asForm()->post($url, $body);

        $result = json_decode($response);
        if ($response->successful() && $result->success == true) {
            $username = $request->email;
            $data = DB::table('sub_users')
                ->where('email', $username)
                ->first();

            if (isset($data) && password_verify($request->password, $data->password)) {

                // if ($data->active == '0') {
                //     return response()->json(['status' => 'account_deactive', 'message' => 'Your Account has been deactivated. Please contact your administrator'], 201);
                // }

                if ($data->active == '1') {

                    // Login the user.
                    if (Auth::guard('subuser')->attempt(['email' => $request->email, 'password' => $request->password])) {
                        Session::put('user', ['id' => $data->id, 'first_name' => $data->fname, 'last_name' => $data->lname, 'email' => $data->email, 'contact' => $data->contact, 'designation' => $data->designation, 'gender' => $data->gender, 'company_id' => $data->company_id]);

                        return redirect()->route('subuser-dashboard');

                        // return response()->json(['status' => 'success', 'message' => 'Login success'], 200);
                    }
                } else {
                    return redirect()->route('subuser-signin')->with(['error' => true, 'message' => 'Your account is not active. Please contact your administrator.']);
                    // return response()->json(['status' => 'error', 'message' => 'Your account is not active. Please contact your administrator.'], 201);
                }
            } else {
                return redirect()->route('subuser-signin')->with(['error' => true, 'message' => 'You have entered wrong credentials.']);
                // return response()->json(['status' => 'error', 'message' => 'You have entered wrong credentials.'], 201);
            }
        } else if ($result->{'error-codes'}) {

            return redirect()->route('subuser-signin')->with(['error' => true, 'message' => $result->{'error-codes'}[0]]);
        } else {
            return redirect()->route('subuser-signin')->with(['error' => true, 'message' => 'Captcha not validated']);
        }
    }
    public function getSubuserData()
    {
        // $uid = $this->userid;
        $userdata = Auth::guard('subuser')->user();

        // $data = SubUser::join('all_users', 'all_users.id', 'sub_users.created_by')
        //     ->join('empcompaniesdetails', 'empcompaniesdetails.id', 'all_users.company_id')
        //     ->select('sub_users.*', 'empcompaniesdetails.company_name')->where('sub_users.id', $uid)->first();


        // return response()->json(['data' => $data], 200);
        return view('sub_user.myprofile', ['user' => $userdata]);
    }
    public function updatePassword(Request $request)
    {
        $id = Auth::guard('subuser')->user()->id;

        $this->validate($request, [

            // 'new_password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => 'min:8'
        ]);

        $change = SubUser::find($id);

        $change->password = Hash::make($request->password);
        $change->password_view = $request->password; //decrpt password

        $saved = $change->save();

        if ($saved) {
            // return response()->json(['success' => 'Password Changed'], 200);
            return redirect()->route('subuser-profile')->with(['success' => true, 'message' => 'Password was successfully changed']);
            
        }
        
        return redirect()->route('subuser-profile')->with(['error' => true, 'message' => 'Something went wrong, please contact to administrator.']);
        // return response()->json(['error' => 'Something went wrong'], 200);
    }
    public function updateSubUserProfileImage(Request $request)
    {

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024', // max 1MB
        ]);

        $authId = Auth::guard('subuser')->user()->id;
        $consultant = SubUser::where('id', $authId)->first();

        //$path = public_path(). '/subuser_profile_image';
        if (isset($request->image)) {
            // $path = "subuser_profile_image/";
            $path = public_path() . '/subuser_profile_image/';

            if ($consultant->profile_image) {
                File::delete($path . $consultant->profile_image);
            }

            $filename = time() . '.' . $request->image->extension(); //file name

            $consultantProfile = SubUser::where('id', $authId)->update(['profile_image' => $filename]);

            $upload = $request->image->move($path, $filename);

            if ($upload) {
                return response()->json(['status' => true, 'message' => 'Profile Image Uploaded Successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to Upload Profile Image'], 200);
            }
        }
    }
    public function checkEmail($email)
    {

        $data = SubUser::select('email')->where('email', $email)->first();
        //$res=sizeof($data)

        return response()->json([
            'data' => $data
        ], 200);
    }
    public function updateHimself(Request $request)
    {
        $authId = Auth::guard('subuser')->user()->id;

        $this->validate($request, [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'contact' => 'required|numeric|min:10',
            'designation' => 'required|string',
            'gender' => 'required|string'
        ]);

        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'contact' => $request->contact,
            'designation' => $request->designation,
            'gender' => $request->gender
        ];

        $consultant = SubUser::where('id', $authId)->update($data);

        if (!$consultant) {
            return redirect()->route('subuser-profile')->with(['error' => true, 'message' => 'Something went wrong, please try again']);
            // return response()->json(['status' => false, 'message' => 'Something went wrong'], 200);
        }

        return redirect()->route('subuser-profile')->with(['success' => true, 'message' => 'Profile Updated Successfully']);
        // return response()->json(['status' => true, 'message' => 'Profile Update'], 200);
    }

    public function login()
    {
        return view('sub_user.login');
    }
}
