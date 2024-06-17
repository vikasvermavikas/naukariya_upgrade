<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsAndNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class NewsAndNotificationController extends Controller
{

    public function index()
    {
        
        $data = DB::table('news_and_notifications')
            ->select('news_and_notifications.*')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'news_subject' => 'required',
            'one_liner_news' => 'required',
            'description' => 'required',
            'news_for' => 'required',
            'attachment' => 'required',
        ]);

        $strpos = strpos($request->attachment, ';');
        $sub = substr($request->attachment, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . "." . $ex;
        $img = Image::make($request->attachment)->resize(370, 250);
        $upload_path = public_path() . "/attachment/";
        $img->save($upload_path . $name);
        $news = new NewsAndNotification();

        $news->news_subject = $request->news_subject;
        $news->one_liner_news = $request->one_liner_news;
        $news->description = $request->description;
        $news->news_for = $request->news_for;
        $news->attachment = $name;

        $news->add_by = Auth::user()->id;
        $news->save();
    }

    public function edit($id)
    {
        $data = NewsAndNotification::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'news_subject' => 'required',
            'one_liner_news' => 'required',
            'description' => 'required',
            'news_for' => 'required',
            'attachment' => 'required',
        ]);
        $news = NewsAndNotification::find($id);

        if ($request->attachment != $news->attachment) {
            $strpos = strpos($request->attachment, ';');
            $sub = substr($request->attachment, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->attachment)->resize(200, 200);
            $upload_path = public_path() . "/attachment/";
            $image = $upload_path . $news->attachment;
            $img->save($upload_path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $name = $news->attachment;
        }

        $news->news_subject = $request->news_subject;
        $news->one_liner_news = $request->one_liner_news;
        $news->description = $request->description;
        $news->news_for = $request->news_for;
        $news->attachment = $name;
        $news->add_by = Auth::user()->id;
        $news->save();
    }

    public function deactive($id)
    {
        $news = NewsAndNotification::find($id);
        $news->status = "0";
        $news->save();
    }

    public function active($id)
    {
        $news = NewsAndNotification::find($id);
        $news->status = "1";
        $news->save();
    }

    public function destroy($id)
    {
        $news = NewsAndNotification::find($id);
        $news->delete();
    }
}
