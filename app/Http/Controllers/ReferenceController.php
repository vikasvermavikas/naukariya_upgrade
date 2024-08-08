<?php

namespace App\Http\Controllers;

use App\Models\SubUser;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ReferenceController extends Controller
{
    public function index()
    {
        // $id =Auth::guard('subuser')->user()->id;
        $company_id =Auth::guard('subuser')->user()->company_id;
        $employer_id =Auth::guard('subuser')->user()->created_by;
        // $employer_id = SubUser::where('id', $id)->select('created_by')->first();
        $data = Reference::select('id', 'name')->where('company_id', $company_id)->where('employer_id', $employer_id)->get();

        return response()->json(['data'=>$data]);

    }

    public function store(Request $request)
    {
        // $id =Session::get('user')['id'];
        // $company_id =Session::get('user')['company_id'];
        // $employer_id = SubUser::where('id', $id)->select('created_by')->first();
        try {
            $id = Auth::guard('subuser')->user()->id;
            $company_id =Auth::guard('subuser')->user()->company_id;
            $employer_id =Auth::guard('subuser')->user()->created_by;
    
            $reference = new Reference();
            $reference->name = $request->reference_name;
            $reference->description = $request->description;
            $reference->added_by = $id;
            $reference->employer_id = $employer_id;
            $reference->company_id = $company_id;
            $reference->save();
    
            return response()->json(['success' => true, 'message' => 'Reference added successfully.']);
        }
        catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }
}
