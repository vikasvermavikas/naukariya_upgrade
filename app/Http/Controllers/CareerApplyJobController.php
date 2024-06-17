<?php

namespace App\Http\Controllers;

use App\Models\CareerApplyJob;
use Illuminate\Http\Request;

class CareerApplyJobController extends Controller
{
    public function applyJob(Request $request)
    {

        $fileName = '';

        if ($request->get('resume')) {
            $image = $request->get('resume');
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $validExtension = ['pdf', 'doc'];

            if (in_array($extension, $validExtension)) {
                $base64 = explode(',', $image)[1];
                $fileName = rand(10000000, 999999999) . "." . $extension;
                $filePath = public_path() . '/career/resume/' . $fileName;
                file_put_contents($filePath, $base64);
            } else {
                return response()->json(['error' => 'please upload only (pdf, doc) file'], 201);
            }
        }

        $data = [
            'full_name' => $request->get('full_name'),
            'email_id' => $request->get('email'),
            'phone_num' => $request->get('phone_num'),
            'location' => $request->get('location'),
            'experience' => $request->get('experience'),
            'current_ctc' => $request->get('current_ctc'),
            'expected_ctc' => $request->get('exp_ctc'),
            'resume' => $fileName,
            'career_id' => $request->get('jobId'),
        ];

        $applyJob = CareerApplyJob::create($data);

        if ($applyJob) {
            return response()->json(['data' => 'Job apply successfully'], 200);
        }
        return response()->json(['data' => 'Something went wrong'], 201);
    }

    public function appliedJobs()
    {
        $appliedJobs = CareerApplyJob::with(['careers' => function ($q) {
            $q->select('id', 'post_name');
        }])->orderBy('created_at', 'DESC')->get();

        return response()->json(['data' => $appliedJobs], 200);
    }

    public function downloadResume($id)
    {
        $file = CareerApplyJob::find($id);
        $fileName = $file->resume;
        $path = public_path('/career/resume/' . $fileName);

        // Checking file exist on directory
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found in directory'], 404);
        }

        $headers = ['Content-Type: application/pdf'];

        return response()->download($path, $fileName, $headers);
    }
}
