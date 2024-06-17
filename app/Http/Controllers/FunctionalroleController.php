<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FunctionalRole;
use Auth;
use DB;
use Session;
use Mail;
use App\Mail\AddFunctionalrole;
use App\Mail\UpdateFunctionalrole;

class FunctionalroleController extends Controller
{
    public function index()
    {
        $data = FunctionalRole::with(['jobmanagers' => function ($query) {
            $query->select('jobmanagers.id', 'jobmanagers.job_functional_role_id')->where('jobmanagers.status', 'Active');
        }])->select('functional_roles.id', 'functional_roles.subcategory_name')->orderBy('functional_roles.subcategory_name')->get();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, []);
        $functionalrole = new FunctionalRole();
        $functionalrole->subcategory_name = $request->functionalrole;
        $functionalrole->add_by = Auth::user()->id;
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;
        $functional = $request->functionalrole;
        if ($to != "") {
            Mail::to($to)->send(new AddFunctionalrole($name, $mobile, $job_title, $functional));
        }
        $functionalrole->save();
    }

    public function edit($id)
    {
        $data = FunctionalRole::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        $functionalrole = FunctionalRole::find($id);
        $functionalrole->subcategory_name = $request->subcategory_name;

        $functionalrole->add_by = Auth::user()->id;
        $data = DB::table('functional_roles')
            ->select('id', 'subcategory_name')
            ->where('id', $id)
            ->first();
        $myArray = json_decode(json_encode($data), true);
        $old_functionalrole = $myArray['subcategory_name'];
        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;
        $functional = $request->subcategory_name;

        if ($to != "") {
            Mail::to($to)->send(new UpdateFunctionalrole($name, $mobile, $job_title, $functional, $old_functionalrole));
        }
        $functionalrole->save();
    }

    public function destroy($id)
    {
        $functionalrole = FunctionalRole::find($id);
        $functionalrole->delete();
    }
}
