<?php

namespace App\Http\Controllers;

use App\Models\ConsultantCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ConsultantCandidateController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->status;

        $candidates = ConsultantCandidate::with(['jobmanager' => function ($query) {
            $query->select('id', 'job_role', 'company_id');
        }, 'jobmanager.companies' => function ($query) {
            $query->select('id', 'company_name');
        }])->orderBy('created_at', 'DESC');

        switch ($status) {

            case 'new candidate':
                return $candidates->orderBy('created_at', 'DESC')->get();
                break;

            case 'joined':
                return $candidates->where('status', $status)->get();
                break;

            case 'rejected':
                return $candidates->where('status', 'cv rejected')
                    ->orWhere('status', 'screening rejected')
                    ->orWhere('status', 'interview rejected')
                    ->orWhere('status', 'offer rejected') 
                    ->get();
                break;

            case 'shortlisted':
                return $candidates->where('status', 'shortlisted')
                    ->get();
                break;

            case 'interview':
                return $candidates->where('status', 'interview')
                    ->orWhere('status', 'interview schedule')
                    ->get();
                break;

            case 'offer':
                return $candidates->where('status', 'offer')->get();
                break;

            case '':
                return $candidates->get();
                break;
        }
    }

    // Only PDF Upload Allowed
    public function store(Request $request) {
        
        $resume = $request->data['resume_url'];

        $explode = explode(',', $resume);
        $ex = explode('/', $resume)[1];
        $extension = explode(';', $ex)[0];
        $valid_extention = ['pdf'];
        if (in_array($extension, $valid_extention)) {
            $data = base64_decode($explode[1]);
            $filename = $request->data['mobile'] .rand(10000000, 999999999) . "." . $extension;
            $url = public_path() . '/consultant_candidate_resume/' . $filename;
            file_put_contents($url, $data);
        } else {
            return response()->json(['error' => 'Please upload pdf file.']);
        }

        $data = [
            'name'          => $request->data['name'],
            'email'         => $request->data['email'],
            'mobile'        => $request->data['mobile'],
            'gender'        => $request->data['gender'],
            'consultant_id' => Session::get('user')['id'],
            'jobmanager_id' => $request->data['jobmanager_id'],
            'resume_url'    => $filename,
        ];

        $canRegister = ConsultantCandidate::create($data);

        if(!$canRegister) {
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 201);
        }

        return response()->json(['success' => true, 'message' => 'Candidate Register Successfully.'], 200);
    }

    public function update(Request $request) {

        $candidateId = $request->can_id;
        $status = $request->status;

        $candidate = ConsultantCandidate::find($candidateId);

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

    public function resumeDownload(Request $request){
        $resume_name = $request->name;
        $file = public_path() . "/consultant_candidate_resume/$resume_name";

        $headers = array(
            'Content-Type: application/pdf',
        );
        $filename = 'Resume.pdf';

        return Response::download($file, $filename, $headers);
    }

    public function reports(Request $request){
        $status = $request->status;

        $candidates = ConsultantCandidate::with(['jobmanager' => function ($query) {
            $query->select('id', 'job_role', 'company_id');
        }, 'jobmanager.companies' => function ($query) {
            $query->select('id', 'company_name');
        }])->orderBy('created_at', 'DESC');

        switch ($status) {

            case 'cv uploaded':
                return $candidates->where('status', 'cv uploaded')->get();
                break;

            case 'screening pending':
                return $candidates->where('status', 'screening pending')->get();
                break;

            case 'screening rejected':
                return $candidates->where('status', 'cv rejected')
                    ->orWhere('status', 'screening rejected')
                    ->orWhere('status', 'interview rejected')
                    ->orWhere('status', 'offer rejected')
                    ->get();
                break;

            case 'shortlisted':
                return $candidates->where('status', 'shortlisted')
                    ->get();
                break;

            case 'interview':
                return $candidates->where('status', 'interview')
                    ->orWhere('status', 'interview schedule')
                    ->get();
                break;

            case 'joined':
                return $candidates->where('status', 'joined')->get();
                break;

            case '':
                return $candidates->get();
                break;
        }
    }

}