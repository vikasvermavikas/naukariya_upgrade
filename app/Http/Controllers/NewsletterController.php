<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use Mail;
use App\Mail\BroadcastNewsLetter;

class NewsletterController extends Controller
{
    public function index()
    {
        $news_letter = Newsletter::orderBy('created_at', 'DESC')
            ->get();
        return response()->json(['data' => $news_letter], 200);
    }

    public function BroadcastMessage(Request $request)
    {
        $this->validate($request, [
            'mail_sender' => 'required',
            'editorData' => 'required',
        ]);

        $mails = Newsletter::pluck('email')->toArray();
        foreach ($mails as $mail) {
            $msg = $request->editorData;
            Mail::to($mail)->send((new BroadcastNewsLetter($mail, $msg))->delay(30));
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'email' => 'required|email',
                ],
                [
                    'email.required' => 'Email Cannot be empty!',
                    // 'email.unique' => 'Email is already registered',
                ]
            );

            $userType = $request->user_type;

            if (is_null($userType)) {
                $userType = null;
            }
            $user = Newsletter::where('email', $request->email)->first();
            if ($user) {
                return response()->json(['success' => false, 'message' => 'User already registered.'], 200);
            }
            $news_letter = new Newsletter();
            $news_letter->email = $request->email;
            $news_letter->user_type = $userType;
            $news_letter->save();
            return response()->json(['success' => true, 'message' => 'Email Registered Successfully.'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th], 200);
        }
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:200'
        ]);

        $user = Newsletter::where('email', $request->email)->first();
        if ($user) {
            $record = Newsletter::find($user->id);
            $record->status = 0;
            $record->save();
            $record->delete();
            return redirect()->back()->with(['success' => true, 'message' => ''.$request->email.' unfollow successfully.'], 200);
        }
        return redirect()->back()->with(['error' => true, 'message' => ''.$request->email.' email not registered.'], 200);
    }

    public function unsubscribe(){
        return view('public.unsubscribe');
    }
}
