<?php

namespace App\Http\Controllers;

use App\Models\TrackerSelection;
use App\Models\TrackerInterview;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class TrackerSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Get Interview Details.
     */
    public function interview_details(Request $request)
    {
       $info = TrackerInterview::select('interview_date', 'interview_details')->where([
            'tracker_id' => $request->tracker_id,
            'job_id' => $request->job_id
        ])->first();

        if ($info) {
            return response()->json(['success' => true, 'details' => $info], 200);
        }
        return response()->json(['success' => false, 'message' => 'Interview Not Scheduled']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'job_id' => 'required|integer',
            'tracker_id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $employer_id = Auth::guard('employer')->user()->id;
        $data = $request->all();
        $data['employer_id'] = $employer_id;

        $result = TrackerSelection::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);
                
        $response = [];

        if($result){
            $response['success'] = true;
            $response['text'] = 'Tracker status changed successfully.';
            $response['title'] = 'Status updated';
            return response()->json($response, 200);
        }
        else {
            $response['success'] = false;
            $response['message'] = 'Server Error.';
            return response()->json($response, 200);
        }
    }

    /**
     * Schedule Interview.
     */
    public function schedule_interview(Request $request)
    {
        $this->validate($request, [
            'job_id' => 'required|integer',
            'tracker_id' => 'required|integer',
            'interview_date' => 'required'
        ]);

        $employer_id = Auth::guard('employer')->user()->id;
        $data = $request->all();
        $data['status'] = 'interview-scheduled';
        TrackerSelection::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);

        $result = TrackerInterview::updateOrCreate(
                ['job_id' => $data['job_id'], 'tracker_id' => $data['tracker_id']], $data);

        return redirect()->back()->with(['success' => 'true', 'message' => 'Interview Scheduled Successfully.']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackerSelection $trackerSelection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackerSelection $trackerSelection)
    {
        //
    }
}
