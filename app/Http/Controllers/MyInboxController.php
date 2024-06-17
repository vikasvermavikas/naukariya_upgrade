<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\MyInbox;
use Session;
use DB;
use App\Models\AllUser;
use App\Models\Jobseeker;
use App\Models\Empcompaniesdetail;

class MyInboxController extends Controller
{
    /* employer*/

    public function send_message_to_employer(Request $request)
    {

        $fileName = '';

        if ($request->get('attachment')) {
            $image = $request->get('attachment');
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $validExtension = ['pdf', 'doc'];

            if (in_array($extension, $validExtension)) {
                $base64 = explode(',', $image)[1];
                $fileName = rand(10000000, 999999999) . "." . $extension;
                $directory = public_path() . '/email_attachment/';

                if (!file_exists($directory)) {
                    mkdir(public_path() . '/email_attachment');
                }

                $filePath = $directory . $fileName;
                file_put_contents($filePath, $base64);
            } else {
                return response()->json(['error' => 'please upload pdf file'], 201);
            }
        }
        $sender_email = Session::get('user')['email'];
        $sender_usertype = Session::get('user')['user_type'];
        $data = [
            'sender_email' => $sender_email,
            'sender_usertype' => $sender_usertype,
            'receiver_email' => $request->get('email_id'),
            'receiver_usertype' => "Employer",
            'subject' => $request->get('subject'),
            'attachment' => $fileName,
            'message' => $request->get('editorData'),
        ];

        $applyJob = MyInbox::create($data);

        if ($applyJob) {
            return response()->json(['data' => 'Message Send successfully'], 200);
        }
        return response()->json(['data' => 'Something went wrong'], 201);
    }

    /* Jobseeker*/
    public function send_message_to_jobseeker(Request $request)
    {

        $fileName = '';

        if ($request->get('attachment')) {
            $image = $request->get('attachment');
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $validExtension = ['pdf', 'doc'];

            if (in_array($extension, $validExtension)) {
                $base64 = explode(',', $image)[1];
                $fileName = rand(10000000, 999999999) . "." . $extension;
                $filePath = public_path() . '/email_attachment/' . $fileName;
                file_put_contents($filePath, $base64);
            } else {
                return response()->json(['error' => 'please upload pdf file'], 201);
            }
        }
        $sender_email = Session::get('user')['email'];
        $sender_usertype = Session::get('user')['user_type'];
        $data = [
            'sender_email' => $sender_email,
            'sender_usertype' => $sender_usertype,
            'receiver_email' => $request->get('email_id'),
            'receiver_usertype' => "Jobseeker",
            'subject' => $request->get('subject'),
            'attachment' => $fileName,
            'message' => $request->get('editorData'),
        ];

        $applyJob = MyInbox::create($data);

        if ($applyJob) {
            return response()->json(['data' => 'Message Send successfully'], 200);
        }
        return response()->json(['data' => 'Something went wrong'], 201);
    }

    public function get_message_for_jobseeker(Request $request)
    {
        $uid = Session::get('user')['email'];
        $userType = Session::get('user')['user_type'];
        $data = DB::table('my_inboxes')
            ->leftjoin('all_users', 'all_users.email', '=', 'my_inboxes.sender_email')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('my_inboxes.*', 'all_users.fname', 'all_users.lname', 'all_users.profile_pic_thumb', 'empcompaniesdetails.company_name')
            ->where('receiver_email', $uid)
            ->where('receiver_usertype', $userType)
            ->orderBy('my_inboxes.created_at', 'DESC')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function getSingleInboxMessage($id)
    {
        return DB::table('my_inboxes')
            ->leftjoin('all_users', 'all_users.email', '=', 'my_inboxes.sender_email')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('my_inboxes.*', 'all_users.fname', 'all_users.lname', 'all_users.profile_pic_thumb', 'empcompaniesdetails.company_name')
            ->where('my_inboxes.id', $id)
            ->get();
    }

    public function downloadAttachment(Request $request, $id)
    {
        $file = MyInbox::find($id);
        $fileName = $file->attachment;
        $path = public_path() . '/email_attachment/' . $fileName;

        // Checking file exist on directory
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found in directory'], 404);
        }

        $headers = ['Content-Type: application/pdf'];

        return response()->download($path, $fileName, $headers);
    }

    public function markAsRead($id)
    {
        return MyInbox::where('id', $id)->update(['read_status' => '1']);
    }

    public function getUnreadMessage()
    {
        $loggedUserType = Session::get('user')['user_type'];
        $loggedUserEmail = Session::get('user')['email'];

        return MyInbox::where('receiver_email', $loggedUserEmail)->where('receiver_usertype', $loggedUserType)->where('read_status', '0')->count();
    }

    public function getSendMailLists()
    {
        $userType = Session::get('user')['user_type'];
        $uid = Session::get('user')['email'];
        $data = DB::table('my_inboxes')
            ->leftjoin('all_users', 'all_users.email', '=', 'my_inboxes.sender_email')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'all_users.company_id')
            ->select('my_inboxes.*', 'all_users.fname', 'all_users.lname', 'all_users.profile_pic_thumb', 'empcompaniesdetails.company_name')
            ->where('sender_email', $uid)
            ->where('sender_usertype', $userType)
            ->orderBy('my_inboxes.created_at', 'DESC')
            ->get();
        return response()->json(['data' => $data], 200);
    }
}