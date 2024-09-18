<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\File;
use Illuminate\Support\Str;
use CV;
use CURLFILE;
use Illuminate\Support\Facades\Storage;
use App\Models\MailMessage;
use App\Models\MailResumeData;


class FileController extends Controller
{
    public function index()
    {
        return view('file');
    }
    public function store(Request $request)
    {

        $file = $request->file;

        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        // use of pdf parser to read content from pdf 
        $fileName = $file->getClientOriginalName();

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($file->path());


        $content = $pdf->getText();

        $name = $this->extractName($content);
        $email = $this->extractEmail($content);
        $mobile = $this->extractMobile($content);
        $address = $this->extractAddress($content);
        $skills = $this->extractSkills($content);

        // Return the extracted information
        return response()->json([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'skills' => $skills,
        ]);
    }

    public function extractData(Request $request)
    {

        // Validation pending.

        $filePath = $request->file('file')->store('uploads', 'public');

        try {

            // Parse the file to extract the data.
            $response = $this->parseResume($filePath);

            if ($response && isset($response['job_id'])) {
               
                unlink(storage_path('app/public/' . $filePath));   // Delete the uploaded file from storage.

                $jobid = $response['job_id'];
                $requesturl = $response['status_url'];

                sleep(15); // Time take to parse data is minimum 2 seconds.

                $data = $this->extractResumeData($requesturl);
                $skills = [];
                if ($data['data']['attributes']['status'] == 'success') {
                    $result = $data['data']['attributes']['result'];
                    for($i = 0; $i < count($result['positions']); $i++) {
                        $skills[] = implode(",", $result['positions'][$i]['skills']);
                    }
                    $result['skills'] = implode(",", $skills);

                    return view('show-resume-data', ['result' => $result]);
                }
                else {
                    return $data;
                }
            } else {
                print_r($response);
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function showResumeData($resumeid)
       {
         $file = MailMessage::select('attachment_path', 'attachmentid')->where('messageid', $resumeid)->first();

         $filename = $file->attachment_path;
    
          try {

            // If resume data is already initiated.
            $existrecord = MailResumeData::where([
                    'mailid' => $resumeid,
                    'filename' => $filename
                ])->first();

                if ($existrecord) {
                    
                    $response = [
                        'job_id' => $existrecord->jobid,
                        'status_url' => $existrecord->status_url,
                    ];
                }
                else {

            // Parse the file to extract the data.
            $response = $this->parseResume($filename);
            if (isset($response['job_id'])) {
                
                  // Save job id.
                MailResumeData::firstOrCreate([
                    'mailid' => $resumeid
                ],
                [
                    'mailid' => $resumeid,
                    'jobid' => $response['job_id'],
                    'status_url' => $response['status_url'],
                    'status' => 'initiate',
                    'filename' => $filename,
                    'attachmentid' => $file->attachmentid,
                ]

            );

                sleep(15); // Time take to parse data is minimum 2 seconds.
            }

            else {
                return ['error' => true, 'message' => $response['message']];
            }
              

                }

           
            if ($response && isset($response['job_id'])) {
               
                $jobid = $response['job_id'];
                $requesturl = $response['status_url'];

                // If resume data is already extracted and saved then fetch from database rather than through API.
                $resumedata = MailResumeData::select('candidate_name', 'candidate_email', 'candidate_phone', 'skills')->where(
                    [
                        'jobid' => $jobid,
                        'status' => 'success'
                    ])->first();

                if($resumedata){
                    $data = [
                        'data' => [
                            'attributes' => [
                                'status' => 'success',
                                'result' => $resumedata->toArray()
                            ]
                        ]
                    ];
                }
                else {
                $data = $this->extractResumeData($requesturl);
                }


                $skills = [];
                if ($data['data']['attributes']['status'] == 'success') {
                    $result = $data['data']['attributes']['result'];
                    
                    // If skills is not came from database.
                    if (!isset($result['skills']) && isset($result['positions'])) 
                    {

                    for($i = 0; $i < count($result['positions']); $i++) {
                        $skills[] = implode(",", $result['positions'][$i]['skills']);
                    }

                    $result['skills'] = implode(",", $skills);

                    // Remove data which are not neccessary.
                    unset($result['candidate_language']);
                    unset($result['candidate_honors_and_awards']);
                    unset($result['candidate_courses_and_certifications']);

                    // Update resume data in database.
                    $result['status'] = 'success';
                    $status = MailResumeData::where('jobid', $jobid)
                     ->update($result);
                    }

               
                    return $result;

                    // return view('employer.show-resume-data', ['result' => $result]);
                }
                else {
                    return $data;
                }
            } else {
                return redirect()->back()->with(['error' => true, 'message' => 'AI not working, contact to administrator']);
                // print_r($response);
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        

    }

    private function parseResume($filePath)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://HR-Resume-or-CV-File-Parser.proxy-production.allthingsdev.co/api/v1/hr/parse_resume',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('file' => new CURLFILE(public_path('tracker/resume/' . $filePath)), 'language' => 'English'),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'x-apihub-key: tpOve9FX9LSp-1-7r--iopwB45tejRI-FMH5pCpzM9AObvurGI',
                'x-apihub-host: HR-Resume-or-CV-File-Parser.allthingsdev.co',
                'x-apihub-endpoint: 82901f2c-a73d-4e06-87c2-db6d7b87b4b3'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }

    private function extractResumeData($statusurl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://HR-Resume-or-CV-File-Parser.proxy-production.allthingsdev.co' . $statusurl . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'x-apihub-key: tpOve9FX9LSp-1-7r--iopwB45tejRI-FMH5pCpzM9AObvurGI',
                'x-apihub-host: HR-Resume-or-CV-File-Parser.allthingsdev.co',
                'x-apihub-endpoint: c447dbb4-d0a2-4f1e-bfe4-eb4047dce945'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    }

    private function extractName($text)
    {
        // Logic to extract name
        if (preg_match('/Name:\s*(.*)/i', $text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    private function extractEmail($text)
    {
        // Logic to extract email
        if (preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i', $text, $matches)) {
            return $matches[0];
        }

        return null;
    }

    private function extractMobile($text)
    {
        // Logic to extract mobile number
        if (preg_match('/\b\d{10,15}\b/', $text, $matches)) {
            return $matches[0];
        }

        return null;
    }

    private function extractAddress($text)
    {
        // Logic to extract address
        if (preg_match('/Address:\s*(.*)/i', $text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    private function extractSkills($text)
    {
        // Logic to extract skills
        if (preg_match('/Skills:\s*(.*)/i', $text, $matches)) {
            return array_map('trim', explode(',', $matches[1]));
        }

        return [];
    }
}
