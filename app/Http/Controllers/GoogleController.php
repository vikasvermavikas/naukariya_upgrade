<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MailMessage;
use App\Models\AllUser;
use App\Models\SubUser;
use Illuminate\Support\Str;
use App\Models\Tracker;
use App\Http\Controllers\FileController;
use DB;

class GoogleController extends Controller
{
    protected $googleService;

    public function __construct(GoogleService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function index()
    {
        return view('employer.google.getmails');
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->googleService->getAuthUrl();
        return redirect()->away($authUrl);
    }

   /**
     * Generate Gmail token and save.
     *
     */

    public function handleGoogleCallback(Request $request)
    {
        $token = $this->googleService->authenticate($request->get('code'));

        // Save the token to the user's profile or session
        $subuserid = Auth::guard('subuser')->user()->id;
        $user = SubUser::find($subuserid);
        $user->google_token = json_encode($token);
        $user->save();
        // print_r(json_encode($token));
        // die;
    }

    /**
     * Fetch listing of mails.
     *
     */

    public function listMessages()
    {

        $subuser_id = Auth::guard('subuser')->user()->id;
        $user = SubUser::find($subuser_id);

        if ($user->google_token) {
        $token = json_decode($user->google_token, true);
        $this->googleService->setAccessToken($token);
        $messages = $this->googleService->listMessages();   // to get messages ids.
        $inboxmails = [];
        foreach ($messages as $message) {
            $messageid = $message->getId();
            $isExport = false;
            $exportedBy = '-';
            $exportedId = MailMessage::join('mail_resume_datas', 'mail_resume_datas.mailid', '=', 'mail_messages.messageid')->select('exported_by')->where('messageid', $messageid)->first();
            if (!empty($exportedId) && $exportedId->exported_by) {

            // Get name who exported mail.
            $creator = SubUser::select(DB::raw('CONCAT(fname," ",lname) AS subuserName'))->where('id', $exportedId->exported_by)->first();
            $exportedBy = $creator->subuserName;
            $isExport = true;
                }

            $inboxmails[] = [
                'message' => $this->getMessageBrief($messageid),
                'exported' => $isExport,
                'exported_by' => Str::of($exportedBy)->apa()
            ];
        }
        return view('employer.emails.index', ['messages' => $inboxmails]);
        }
        return view('employer.emails.index', ['error' => true, 'message' => 'Token not exists.']);

   
    }

    /**
     * Fetch mail attachments and add tracker.
     *
     */

    public function messageDetails($messageid)
    {
        $subuser_id = Auth::guard('subuser')->user()->id;
        $user = SubUser::find($subuser_id);
        $token = json_decode($user->google_token, true);
        $this->googleService->setAccessToken($token);
        $messages = $this->googleService->getMessage($messageid);
        $body = $this->getMessageBody($messages->payload);
        $attachments = $this->getAttachments($messages->payload, $messages->id);
        $messagebrief = $this->getMessageBrief($messageid);
        
        // Save message to database if not already saved.
        $mailcontent =  [
            'messageid' => $messageid,
            'sender' => $messagebrief['received']['value'],
            'subject' => $messagebrief['subject']['value'],
            'receivingdate' => $messagebrief['date']['value'],
            'body' => $body,
            'exported_by' => $subuser_id

        ];

        // If mail contain attachments.
        if (count($attachments) > 0) {
            for ($i = 0; $i < count($attachments); $i++) {
                $mailcontent['attachmentid'] = $attachments[$i]['attachmentid'];
                $mailcontent['attachment_path'] = $attachments[$i]['uniquefilename'];
            }
        }
  
        // Save mail content and attachment.
        $savemessage = MailMessage::firstOrCreate(
            ['messageid' => $messageid],
            $mailcontent
        );

        // Fetch resume records.
        $fileobject = new FileController();
        $resumedetails = $fileobject->showResumeData($messageid);
        if (isset($resumedetails['error']))
        {
            return redirect()->back()->with($resumedetails);
        }
        
        // Save Tracker Record. 
        $trackercontent = [
        'name' => $resumedetails['candidate_name'],
        'email' => $resumedetails['candidate_email'],
        'contact' => $resumedetails['candidate_phone'],
        'key_skills' => $resumedetails['skills'],
        'resume' => isset($mailcontent['attachment_path']) ? $mailcontent['attachment_path'] : '',
        'company_id' => Auth::guard('subuser')->user()->company_id,
        'employer_id' => Auth::guard('subuser')->user()->created_by,
        'added_by' => Auth::guard('subuser')->user()->id
          ];
        Tracker::firstOrCreate(
            ['email' => $resumedetails['candidate_email']],
            $trackercontent
        );
       
        return view('employer.emails.mailDetails', compact('attachments', 'body', 'messageid'));
    }

    /**
     * Fetch message brief intro.
     *
     */
    private function getMessageBrief($messageid)
    {

        $messages = $this->googleService->getMessage($messageid);
        $brief = [];
        $brief['messageid'] = $messageid;
        foreach ($messages->payload->headers as $header) {
            if ($header->name == 'From') {
                $brief['received'] = [
                    'name' => $header->name,
                    'value' => $header->value,
                ];
            }
            if ($header->name == 'To') {
                $brief['to'] = [
                    'name' => $header->name,
                    'value' => $header->value,
                ];
            }
            if ($header->name == 'Subject') {
                $brief['subject'] = [
                    'name' => $header->name,
                    'value' => $header->value,
                ];
            }
            if ($header->name == 'Date') {
                $brief['date'] = [
                    'name' => $header->name,
                    'value' => $header->value,
                ];
            }
        }

        return $brief;
    }

    /**
     * Fetch message body.
     *
     */
    private function getMessageBody($payload)
    {
        $body = '';

        // Check if the message has parts (multipart)
        if (!empty($payload->parts)) {
            foreach ($payload->parts as $part) {
                if ($part->mimeType === 'multipart/alternative') {

                    foreach ($part->parts as $item) {
                        if ($item->mimeType === 'text/plain' || $item->mimeType === 'text/html') {
                            $body .= base64_decode(str_replace(['-', '_'], ['+', '/'], $item->body->data));
                            break;
                        }
                    }
                }
                // Check for text/plain or text/html parts
                else if ($part->mimeType === 'text/plain' || $part->mimeType === 'text/html') {
                    $body .= base64_decode(str_replace(['-', '_'], ['+', '/'], $part->body->data));
                }
            }
        } else {
            // If no parts, directly decode the body
            $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload->body->data));
        }

        return $body;
    }

     /**
     * Fetch message attchments if any.
     *
     */
    private function getAttachments($payload, $messageId)
    {
        $attachments = [];

        if (!empty($payload->parts)) {
            foreach ($payload->parts as $part) {
                // Recursively check if part has more sub-parts (multipart/mixed)
                if (!empty($part->parts)) {
                    $attachments = array_merge($attachments, $this->getAttachments($part, $messageId));
                }

                // Check if this part is an attachment
                if (!empty($part->filename) && !empty($part->body->attachmentId)) {

                    // Fetch the attachment using the Gmail API
                    $attachment = $this->googleService->getAttachment($messageId, $part->body->attachmentId);
                    $attachmentData = base64_decode(str_replace(['-', '_'], ['+', '/'], $attachment->data));

                    // Save the attachment to the server
                    $uniquefilename = time() . "_" . $part->filename;
                    // $filePath = storage_path('app/public/attachments/' . $uniquefilename);
                    $filePath = public_path() . '/tracker/resume/'. $uniquefilename;
                    file_put_contents($filePath, $attachmentData);
                    // $downloadUrl = asset('storage/attachments/' . $uniquefilename);
                    $downloadUrl = asset('tracker/resume/' . $uniquefilename);

                    // Collect the attachment info along with download link
                    $attachments[] = [
                        'attachmentid' => $part->body->attachmentId,
                        'uniquefilename' => $uniquefilename,
                        'filename' => $part->filename,
                        'filePath' => $filePath,
                        'downloadUrl' => $downloadUrl,
                        'mimeType' => $part->mimeType,
                        'size' => $part->body->size,
                    ];
                }
            }
        }

        return $attachments;
    }
}
