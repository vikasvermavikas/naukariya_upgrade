<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Auth;
use Mail;
use App\Mail\UserCreate;


class AdminuserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = Admin::orderBy('created_at', 'DESC')->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'designation' => 'required',
            'email' => 'required|max:255',
            'password' => 'required',
            'phone' => 'required|min:10|max:10'

        ]);
//        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
//        $pass = substr(str_shuffle($alphabet), 0, 8);
//        $password = $pass;
        $password = Hash::make($request->password);
        $to = $request->email;
        $adminuser = new Admin();
        $adminuser->name = $request->name;
        $adminuser->job_title = $request->designation;
        $adminuser->email = $request->email;
        $adminuser->mobile = $request->phone;
        $adminuser->password = $password;
        $adminuser->save();

        if ($to != "") {
            Mail::to($to)->send(new UserCreate($request->name, $request->designation, $request->password));    //
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function edit($id)
    {
        $data = Admin::find($id);
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'job_title' => 'required',
            'email' => 'required|max:255',
            'mobile' => 'required|min:10|max:10'
        ]);

        $adminuser = Admin::find($id);
        $adminuser->name = $request->name;
        $adminuser->job_title = $request->job_title;
        $adminuser->email = $request->email;
        $adminuser->mobile = $request->mobile;
        $adminuser->save();
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        $adminuser = Admin::find($id);
        $adminuser->delete();
    }
}
