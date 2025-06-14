<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImapController;
use App\Models\Tracker;
use App\Models\MailDownload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResumeParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resume-parsing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch file from storage and parse the resume ';

    /**
     * Execute the console command.
     */
    public function handle()
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
                $filename = $pdf->getFilename();

                // Work on only files which have parsing status pending or null.
                $fetch_file = MailDownload::where(['file_name' => $filename, 'download_status' => 'downloaded'])
                    ->where(function ($query) {
                        $query->where('parsing_status', 'pending')
                            ->orWhere('parsing_status', null);
                    })->first();
                    
                // print_r($fetch_file);
                // echo $filename;
                // echo "<br>";
                if ($fetch_file) {
                    // Parse the file to extract the data.
                    $response = ImapController::parseResume($path);
                    if ($response && isset($response['job_id'])) {

                        $jobid = $response['job_id'];
                        $requesturl = $response['status_url'];

                        sleep(20); // Time take to parse data is minimum 2 seconds.

                        $data = ImapController::extractResumeData($jobid);
                        $data['filename'] = $filename;
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
                                File::copy(public_path('mail_attachments/'.$fetch_file->file_name.''), public_path('tracker/resume/'.$fetch_file->file_name.''));
                                 Log::info('Tracker details saved for ' . $data['data']['attributes']['result']['candidate_email']);
                            } else {
                                Log::info('Tracker details not saved for ' . $data['data']['attributes']['result']['candidate_email']);
                            }
                        }

                        // Store fetch data.
                        $fetch_file->job_id = $jobid;
                        $fetch_file->parsing_status = isset($data['data']) ? $data['data']['attributes']['status'] : 'error';
                        $fetch_file->parsing_date = date('Y-m-d');
                        $fetch_file->tracker_id = $tracker_id ? $tracker_id : null;
                        $fetch_file->save();
                    }
                    elseif($response && isset($response['message'])){
                        Log::error($response['message']);
                    }
                }
            }
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
        }
    }
}
