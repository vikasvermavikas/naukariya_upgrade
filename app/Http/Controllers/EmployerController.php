<?php

namespace App\Http\Controllers;

use App\Models\ConsultantCandidate;
use App\Models\ConsultantJob;
use App\Models\Jobmanager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployerController extends Controller
{
    public function getConsultantJobs() {
        $emp_id = Session::get('user')['id'];
        return Jobmanager::with('consultantCandidates','consultantJob')->select('id', 'company_id', 'job_role', 'job_ctc', 'job_exp', 'status', 'title', 'last_apply_date')
            ->where('job_for', 'Consultant')
            ->where('userid', $emp_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getConsultantJobsApplication($job_id, $tabValue)
    {
        $consultantCandidate = ConsultantCandidate::query();

        switch ($tabValue) {
            case 'new candidate':
                return $consultantCandidate->where('jobmanager_id', $job_id)->orderBy('created_at', 'DESC')->get();
                break;

            case 'rejected':
                return $consultantCandidate->where('jobmanager_id', $job_id)
                    ->where('status', 'cv rejected')
                    ->orWhere('status', 'screening rejected')
                    ->orWhere('status', 'interview rejected')
                    ->orWhere('status', 'offer rejected')
                    ->get();
                break;

            case 'shortlisted':
                return $consultantCandidate->where('jobmanager_id', $job_id)
                    ->where('status', 'shortlisted')
                    ->get();
                break;

            case 'interview':
                return $consultantCandidate->where('jobmanager_id', $job_id)
                    ->where('status', 'interview')
                    ->orWhere('status', 'interview schedule')
                    ->get();
                break;

            case 'offer':
                return $consultantCandidate->where('jobmanager_id', $job_id)
                    ->where('status', 'offer')
                    ->get();
                break;

            case 'joining':
                return $consultantCandidate->where('jobmanager_id', $job_id)
                    ->where('status', 'joined')
                    ->get();
                break;

            case '':
                return $consultantCandidate->where('jobmanager_id', $job_id)->get();
                break;
        }

        return $consultantCandidate->where('jobmanager_id', $job_id)->get();
    }

    public function update(Request $request)
    {
        $candidateId = $request->can_id;
        $status = $request->status;
        $jobId = $request->job_manager_id;

        $candidate = ConsultantCandidate::where(['jobmanager_id' => $jobId, 'id' => $candidateId])->first();

        if($candidate) {
            $candidate->status = $status;
            $update = $candidate->update();

            if($update) {
                return response()->json(['status' => true, 'message' => 'Candidate status changed.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Candidate status not changed.'], 201);
            }
        }
    }
}
