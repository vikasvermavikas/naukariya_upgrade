<?php

namespace App\Http\Controllers;

use App\Models\SubUser;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReferenceController extends Controller
{
    public function index()
    {
        $id =Session::get('user')['id'];
        $company_id =Session::get('user')['company_id'];
        $employer_id = SubUser::where('id', $id)->select('created_by')->first();
        $data = Reference::where('company_id', $company_id)->where('employer_id', $employer_id->created_by)->get();

        return response()->json(['data'=>$data]);

    }

    public function store(Request $request)
    {
        $id =Session::get('user')['id'];
        $company_id =Session::get('user')['company_id'];
        $employer_id = SubUser::where('id', $id)->select('created_by')->first();
        $reference = new Reference();
        $reference->name = $request->reference_name;
        $reference->description = $request->description;
        $reference->added_by = $id;
        $reference->employer_id = $employer_id->created_by;
        $reference->company_id = $company_id;
        $reference->save();
    }
}
