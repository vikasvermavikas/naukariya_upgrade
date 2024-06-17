<?php

namespace App\Http\Controllers;

use App\Models\ClientName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ClientNameController extends Controller
{
    public function index() {
        $uid = Session::get('user')['id'];
        $companyId = Session::get('user')['company_id'];

        $data= ClientName::where('created_by', $uid)
        ->where('company_id', $companyId)
           ->OrderBy('created_at', 'DESC')
           ->get();

       return response()->json(['data' => $data], 200);
   }

   public function store(Request $request) {
      
      $uid = Session::get('user')['id'];
      $companyId = Session::get('user')['company_id'];


      $subuser = New ClientName();
      $subuser->name = $request->client_name;
      $subuser->email = $request->email;
      $subuser->contact = $request->contact;
      $subuser->address = $request->address;
      $subuser->created_by = $uid;
      $subuser->company_id = $companyId;
      $data = $subuser->save();       

   }

   public function update(Request $request, $id) {

    $uid = Session::get('user')['id'];
    $companyId = Session::get('user')['company_id'];

      $subuser = ClientName::find($id);

      $subuser->name = $request->client_name;
      $subuser->email = $request->email;
      $subuser->contact = $request->contact;
      $subuser->address = $request->address;
      $subuser->created_by = $uid;
      $subuser->company_id = $companyId;
      $data = $subuser->save();

   }
   public function getsingleclient($id)
   {
        $subuser = ClientName::find($id);
        return $subuser;
   }
   public function deactive($id)
    {
        ClientName::where(['id'=>$id])->update(['active'=>'0']);
    }
    public function active($id)
    {
        ClientName::where(['id'=>$id])->update(['active'=>'1']);

    }
    //for job posting
    public function clientList() {
        $uid = Session::get('user')['id'];
        $companyId = Session::get('user')['company_id'];

        $data= ClientName::where('created_by', $uid)
        ->where('company_id', $companyId)
        ->where('active', '1')
        ->OrderBy('name', 'ASC')
        ->get();

       return response()->json(['data' => $data], 200);
   }
   //for Admin
    public function AdminClientList() {

            $data= ClientName::join('all_users','all_users.id','client_names.created_by')
            ->join('empcompaniesdetails','empcompaniesdetails.id','client_names.company_id')
            ->select('client_names.*','all_users.fname as emp_fname','all_users.lname as emp_lname','all_users.email as emp_email','empcompaniesdetails.company_name')
            ->OrderBy('client_names.created_at', 'DESC')
            ->get();

            return response()->json(['data' => $data], 200);
    }
    public function Admindeactive($id)
    {
        ClientName::where(['id'=>$id])->update(['active'=>'0']);
    }
    public function Adminactive($id)
    {
        ClientName::where(['id'=>$id])->update(['active'=>'1']);

    }
}
