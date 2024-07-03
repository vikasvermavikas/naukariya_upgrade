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
        $this->validate(
            $request,
            [
                'email' => 'required|unique:newsletters,email',
            ],
            [
                'email.required' => 'Email Cannot be empty!',
                'email.unique' => 'Email is already registered',
            ]
        );

        $userType = $request->user_type;

        if (is_null($userType)) {
            $userType = null;
        }

        $news_letter = new Newsletter();
        $news_letter->email = $request->email;
        $news_letter->user_type = $userType;
        $news_letter->save();

        return redirect()->route('home')->with('message', 'Email registered successfully');
    }
}
