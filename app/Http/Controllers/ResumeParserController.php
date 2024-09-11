<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Str;
use PHPUnit\Framework\Constraint\IsTrue;
use CURLFILE;
class ResumeParserController extends Controller
{
    /**
     * 
     * function to show resume parsing form.\
     * 
     **/
    public function parseResume()
    {
        return view('employer.resume-analysis');
    }


    public function extractResume(Request $request)
    {
        $filePath = $request->file('file')->store('uploads', 'public');

        try {

            // Parse the file to extract the data.
            $response = $this->parseResumeData($filePath);

            if ($response && isset($response['job_id'])) {

                unlink(storage_path('app/public/' . $filePath));   // Delete the uploaded file from storage.

                $jobid = $response['job_id'];
                $requesturl = $response['status_url'];

                sleep(15); /// Time take to parse data is minimum 2 seconds.

                return response()->json(['success' => true, 'jobid' => $jobid, 'message' => 'Resume Extract Successfully.'], 200);
            } else {
                return response()->json(['error' => true, 'result' => 'Something went wrong, please contact to administrator'], 200);
                // print_r($response);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'result' => $e->getMessage()], 200);
            // echo "Error: " . $e->getMessage();
        }
    }

    private function parseResumeData($filePath)
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
            CURLOPT_POSTFIELDS => array('file' => new CURLFILE(storage_path('app/public/' . $filePath)), 'language' => 'English'),
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

    public function extractResumeData($jobid = '')
    {
        $curl = curl_init();
        if ($jobid) {
            $url = 'https://HR-Resume-or-CV-File-Parser.proxy-production.allthingsdev.co/api/v1/hr/parse_resume/job/status/' . $jobid . '';
        }
     
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
        $skills = [];
     
        if ($response['data']['attributes']['status'] == 'success') {
            $result = $response['data']['attributes']['result'];
            for ($i = 0; $i < count($result['positions']); $i++) {
                $skills[] = implode(",", $result['positions'][$i]['skills']);
            }
            $result['skills'] = implode(",", $skills);
            return view('employer.show-resume-data', ['result' => $result]);
        }
        else {
            
            return back()->with(['error' => true, "message" => $response['data']['attributes']['status']]);

        }
    }


    /**
     * 
     * function to parse resume.\
     * 
     **/
    public function getParsedResume(Request $request)
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
        // echo "<pre>";
        // print_r($content);
        // echo "</pre>";
        // die;
        $name = $this->extractName($content);
        $email = $this->extractEmail($content);
        $mobile = $this->extractMobile($content);
        $address = $this->extractAddress($content);
        $skills = $this->extractSkills($content);

        // Return the extracted information

        return view('employer.show-parsed-resume', [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'skills' => $skills,
            'qualifications' => 'Mca from MDU in 2023',
            'experience' => '5 years experience in Softtech Technologies Pvt Ltd',
        ]);
    }



    private function extractName($text)
    {
        $text = Str::replace('resume', '', $text, '', false); // False for case insensitive.
        $text = Str::replace('curriculum viate', '', $text, '', false); // False for case insensitive.
        $text = Str::replace('CV', '', $text, '', false);
        $name = Str::words($text, 2, '');
        return trim($name);

        // Old Code
        // Logic to extract name
        // if (preg_match('/Name:\s*(.*)/i', $text, $matches)) {
        //     return trim($matches[1]);
        // }

        // return null;
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
        $preSkills = [
            'PHP',
            'Laravel',
            'Zoho developer',
            'CSS',
            'HTML5',
            'CSS3',
            'Javascript',
            'JQuery',
            'Bootstrap',
            'Photoshop',
            'Illustrator',
            'Prototype',
            'Wireframes',
            'Sales Management',
            ' Sales',
            ' Marketing',
            ' Lead Generation',
            ' Business Development',
            ' Cold Calling',
            ' Client Relations',
            ' Client Management',
            'Quick Learner',
            'Microsoft Windows',
            'VMware',
            'Cisco Products',
        ];
        $skills = [];
        for ($i = 0; $i < count($preSkills); $i++) {
            $contains = false;
            $contains = Str::contains($text, $preSkills[$i], True);    // True for case insensitive.
            if ($contains) {
                $skills[] = $preSkills[$i];
            }
        }

        return implode(",", $skills);

        // Old Code.
        // Logic to extract skills
        // if (preg_match('/Skills:\s*(.*)/i', $text, $matches)) {
        //     return array_map('trim', explode(',', $matches[1]));
        // }

        // return null;
    }
}
