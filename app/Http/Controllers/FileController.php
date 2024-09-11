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
         $file = MailMessage::select('attachment_path')->where('messageid', $resumeid)->first();

         $filename = $file->attachment_path;
    
          try {

            // Parse the file to extract the data.
            $response = $this->parseResume($filename);
           
            if ($response && isset($response['job_id'])) {
               
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

                    return $result;

                    // return view('employer.show-resume-data', ['result' => $result]);
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
