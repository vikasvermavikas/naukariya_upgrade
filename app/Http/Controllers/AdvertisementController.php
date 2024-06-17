<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Image;
use App\Mail\AddAds;
use App\Mail\UpdateAds;
use App\Mail\ActiveAds;
use App\Mail\DeactiveAds;

class AdvertisementController extends Controller
{

    public function index()
    {
        $data = Advertisement::orderBy('created_at', 'DESC')->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'ads_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $strpos = strpos($request->image, ';');
        $sub = substr($request->image, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . "." . $ex;
        $img = Image::make($request->image)->resize(370, 250);
        $upload_path = public_path() . "/adsimage/";
        $img->save($upload_path . $name);

        $advertisement = new Advertisement();
        $advertisement->ads_title = $request->ads_title;
        $advertisement->ads_link = $request->ads_link;
        $advertisement->ads_for = $request->ads_for;
        $advertisement->ads_category = $request->ads_category;
        $advertisement->ads_startdate = $request->startdate;
        $advertisement->ads_enddate = $request->enddate;
        $advertisement->ads_image = $name;
        $advertisement->add_by = Auth::user()->id;

        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;

        if ($to != "") {
            Mail::to($to)->send(new AddAds($name, $mobile, $job_title));
        }

        $advertisement->save();
    }

    public function edit($id)
    {
        $data = Advertisement::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            // 'ads_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $advertisement = Advertisement::find($id);

        if ($request->image != $advertisement->ads_image) {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->image)->resize(200, 200);
            $upload_path = public_path() . "/adsimage/";
            $image = $upload_path . $advertisement->image;
            $img->save($upload_path . $name);
            if (file_exists($image)) {
                @unlink($image);
            }

        } else {
            $name = $advertisement->ads_image;
        }
        $advertisement->ads_title = $request->ads_title;
        $advertisement->ads_link = $request->ads_link;
        $advertisement->ads_for = $request->ads_for;
        $advertisement->ads_category = $request->ads_category;
        $advertisement->ads_startdate = $request->ads_startdate;
        $advertisement->ads_enddate = $request->ads_enddate;
        $advertisement->ads_image = $name;
        $advertisement->add_by = Auth::user()->id;
        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;

        if ($to != "") {
            Mail::to($to)->send(new UpdateAds($name, $mobile, $job_title));
        }

        $advertisement->save();
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->delete();
    }

    public function deactive($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->ads_status = "Not Active";
        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;

        if ($to != "") {
            Mail::to($to)->send(new DeactiveAds($name, $mobile, $job_title));
        }
        $advertisement->save();
    }

    public function active($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->ads_status = "Active";
        //send mail
        $to = Auth::user()->email;
        $name = Auth::user()->name;
        $job_title = Auth::user()->job_title;
        $mobile = Auth::user()->mobile;

        if ($to != "") {
            Mail::to($to)->send(new ActiveAds($name, $mobile, $job_title));
        }

        $advertisement->save();
    }

}
