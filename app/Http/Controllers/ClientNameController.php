<?php

namespace App\Http\Controllers;

use App\Models\ClientName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientNameController extends Controller
{
    public $userid;
    public $companyid;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid= Auth::guard('employer')->user()->id;
            $this->companyid = Auth::guard('employer')->user()->company_id;
            return $next($request);
        });
      
    }

    public function index()
    {
        // $uid = Session::get('user')['id'];
        $uid = $this->userid;
        $companyId = $this->companyid;

        $data = ClientName::where('created_by', $uid)
            ->where('company_id', $companyId)
            ->OrderBy('created_at', 'DESC')
            ->paginate(10);

        // return response()->json(['data' => $data], 200);
        return view('employer.client_list', ['clients' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' =>'required|email:filter|unique:client_names',
            'contact' =>'required|numeric|min:10',
            'address' =>'required|string|max:255'
        ],

        [
            'name.regex' => 'Client name must contain only letters'
        ]
    );
        // $uid = Session::get('user')['id'];
        // $companyId = Session::get('user')['company_id'];
        $uid = $this->userid;
        $companyId = $this->companyid;

        $subuser = new ClientName();
        $subuser->name = $request->name;
        $subuser->email = $request->email;
        $subuser->contact = $request->contact;
        $subuser->address = $request->address;
        $subuser->created_by = $uid;
        $subuser->company_id = $companyId;
        $data = $subuser->save();

        return redirect()->back()->with(['message' => 'Client created successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'updatename' =>'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'updateemail' => [
                'required',
                'email:filter',
                Rule::unique('client_names', 'email')->ignore($request->id),
            ],
            'updatecontact' =>'required|numeric|min:10',
            'updateaddress' =>'required|max:255'
        ], [
            'updatename.required' => 'Client Name is required',
            'updatename.regex' => 'Client Name must contain only letters',
            'updateemail.required' => 'Email is required',
            'updateemail.email' => 'Invalid email format',
            'updateemail.unique' => 'Email already exists',
            'updatecontact.required' => 'Contact number is required',
            'updatecontact.numeric' => 'Contact must be 10 digit number',
            'updateaddress.required' => 'Address is required',
            'updateaddress.max' => 'Address should not exceed 255 characters'
        ]);
        $uid = $this->userid;
        $companyId = $this->companyid;

        $subuser = ClientName::find($request->id);

        $subuser->name = $request->updatename;
        $subuser->email = $request->updateemail;
        $subuser->contact = $request->updatecontact;
        $subuser->address = $request->updateaddress;
        $subuser->created_by = $uid;
        $subuser->company_id = $companyId;
        $data = $subuser->save();

        return redirect()->back()->with(['message' => 'Client updated successfully']);

    }
    public function getsingleclient($id)
    {
        $subuser = ClientName::find($id);
        return $subuser;
    }
    public function deactive($id)
    {
        ClientName::where(['id' => $id])->update(['active' => '0']);
        return redirect()->back()->with(['message' => 'Client deactivated successfully']);

    }
    public function active($id)
    {
        ClientName::where(['id' => $id])->update(['active' => '1']);
        return redirect()->back()->with(['message' => 'Client activated successfully']);

    }
    //for job posting
    public function clientList()
    {
        $uid = Session::get('user')['id'];
        $companyId = Session::get('user')['company_id'];

        $data = ClientName::where('created_by', $uid)
            ->where('company_id', $companyId)
            ->where('active', '1')
            ->OrderBy('name', 'ASC')
            ->get();

        return response()->json(['data' => $data], 200);
    }
    //for Admin
    public function AdminClientList()
    {

        $data = ClientName::join('all_users', 'all_users.id', 'client_names.created_by')
            ->join('empcompaniesdetails', 'empcompaniesdetails.id', 'client_names.company_id')
            ->select('client_names.*', 'all_users.fname as emp_fname', 'all_users.lname as emp_lname', 'all_users.email as emp_email', 'empcompaniesdetails.company_name')
            ->OrderBy('client_names.created_at', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }
    public function Admindeactive($id)
    {
        ClientName::where(['id' => $id])->update(['active' => '0']);
    }
    public function Adminactive($id)
    {
        ClientName::where(['id' => $id])->update(['active' => '1']);
    }
}
