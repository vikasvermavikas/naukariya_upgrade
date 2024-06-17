<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\ServicesUserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Services::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {

        $job = new ServicesUserRegistration();
        $uid = Session::get('user')['id'];
        $job->name = $request->name;
        $job->email =  $request->email;
        $job->service_id = $request->services_id;
        $job->industry =  $request->job_industry_id;
        $job->functional_area = $request->job_functional_role_id;
        $job->category = $request->job_category_id;
        $job->state = $request->job_state_id;
        $job->city = $request->job_city_id;
        $job->address = $request->job_address;
        $job->added_by = $uid;
        $job->save();
    }
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
