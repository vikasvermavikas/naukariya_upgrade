<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use App\Models\Tracker;
use App\Models\MailDownload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use CURLFILE;
use Throwable;

class ImapController extends Controller
{
    /**
     * Get emails.
     */
    public function index()
    {
        ini_set('max_execution_time', 180);
        // Get default account configuration.
        $client = Client::account('default');
        $client->connect();  // Connect to account

        // Check whether account is connected or not
        $status = $client->isConnected();
        if ($status) {
            $folder = $client->getFolderByName('INBOX');
            $query = $folder->messages();
            $query->markAsRead();
            $query->setFetchOrder("desc");
            // $query->setFetchOrder("desc");
            // $count = $query->all()->count();
            // $messages = $query->all()->get(); // get all messages
            // $messages = $query->all()->limit($limit = 5, $page = 1)->get();
            $messages = $query->since(\Carbon\Carbon::now()->subDays(2))->unseen()->get();
            return view('mails', compact('messages'));
        } else {
            echo 'Not able to connect to gmail.';
        }
    }

    /**
     * Get Mail Data.
     */
    public function fetch()
    {
        ini_set('max_execution_time', 180);
        $path = public_path('mail_attachments'); // storage path
        $files = File::allFiles($path);  // get files from storage

        // Get only pdf files from storage. 
        $pdfFiles = array_filter($files, function ($file) {
            return strtolower($file->getExtension()) === 'pdf';
        });

        $candidates = [];
        DB::beginTransaction();
        try {
            foreach ($pdfFiles as $pdf) {
                $path = $pdf->getPathname();
                $filname = $pdf->getFilename();
    
                // Work on only files which have parsing status pending or null.
                $fetch_file = MailDownload::where(['file_name' => $filname, 'download_status' => 'downloaded'])
                    ->where(function ($query) {
                        $query->where('parsing_status', 'pending')
                            ->orWhere('parsing_status', null);
                    })->first();
    
                if ($fetch_file) {
                    // Parse the file to extract the data.
                    $response = self::parseResume($path);
                    if ($response && isset($response['job_id'])) {
    
                        $jobid = $response['job_id'];
                        $requesturl = $response['status_url'];
    
                        sleep(20); // Time take to parse data is minimum 2 seconds.
    
                        $data = self::extractResumeData($jobid);
                        $data['filename'] = $filname;
                        $candidates[] = $data;
                        $tracker_id = '';
    
                        // Store tracker record if successfully parsed.
                        if (isset($data['data']) && $data['data']['attributes']['status'] == 'success' && $data['data']['attributes']['result']['candidate_name']) {
                            if (!Tracker::where('email', $data['data']['attributes']['result']['candidate_email'])->exists()) {
                            $tracker_id = Tracker::create([
                                'name' => $data['data']['attributes']['result']['candidate_name'],
                                'email' => $data['data']['attributes']['result']['candidate_email'],
                                'contact' => $data['data']['attributes']['result']['candidate_phone'],
                                'resume' => $fetch_file->file_name,
                                'reference' => 'INTERNAL',
                                'added_by' => '30',
                                'import_type' => 'auto',
                                'import_id' => $fetch_file->id
                            ])->id;
                            }
                            else {
                               Log::info('Tracker details not saved for '.$data['data']['attributes']['result']['candidate_email']); 
                            }
                        }
    
                        // Store fetch data.
                        $fetch_file->job_id = $jobid;
                        $fetch_file->parsing_status = isset($data['data']) ? $data['data']['attributes']['status'] : 'error';
                        $fetch_file->parsing_date = date('Y-m-d');
                        $fetch_file->tracker_id = $tracker_id ? $tracker_id : null;
                        $fetch_file->save();
                    }
                }
            }
            DB::commit();
            return view('candidates', compact('candidates'));
        }
        catch(Throwable $th){
            DB::rollBack();
            Log::error($th->getMessage());
        }
    }

    public static function parseResume($filePath)
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
            CURLOPT_POSTFIELDS => array('file' => new CURLFILE($filePath), 'language' => 'English'),
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

    public static function extractResumeData($statusurl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://HR-Resume-or-CV-File-Parser.proxy-production.allthingsdev.co/api/v1/hr/parse_resume/job/status/' . $statusurl . '',
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
}
