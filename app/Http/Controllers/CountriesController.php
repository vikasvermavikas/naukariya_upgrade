<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Countries;
use Auth;
use DB;

class CountriesController extends Controller
{

    public function index()
    {
        $data = Countries::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'country_name' => 'required',
            'currency' => 'required',
        ]);
        $countries = new Countries();
        $countries->country_name = $request->country_name;
        $countries->currency = $request->currency;
        //$countries->add_by = Auth::user()->id;
        $countries->save();
    }

    public function edit($id)
    {
        $data = Countries::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'country_name' => 'required',
            'currency' => 'required',
        ]);
        $countries = Countries::find($id);
        $countries->country_name = $request->country_name;
        $countries->currency = $request->currency;
        $countries->save();
    }
}
