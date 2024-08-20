<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteInfo;
use DB;
use Session;
use App\Models\Rating;

class WebsiteInfoController extends Controller
{
    public function getWebInfoData()
    {

        $getInfo = WebsiteInfo::select('terms_and_condition')->first();
        return view('public.terms_conditions', ['conditions' => $getInfo]);
    }

    public function privacy_policy(){
        
        $getInfo = WebsiteInfo::select('privacy_policy')->first();
        return view('public.policies', ['policies' => $getInfo]);
    }

    public function advertise_with_us(){
        
        $getInfo = WebsiteInfo::select('advertise_with_us')->first();
        return view('public.advertise_with_us', ['advertise_with_us' => $getInfo]);
    }
    public function countRow()
    {
        $count = DB::table('website_infos')
            ->count();
        return response()->json($count);
    }
    public function update(Request $request)
    {
        $web_id = $request->params['web_id'];
        $dropDownValue = $request->params['dropDownValue'];
        $ed_data = $request->params['editor_data'];

        if ($dropDownValue == 'about_us') {
            $webInfo = WebsiteInfo::find($web_id);
            $webInfo->about_us = $ed_data;
            $webInfo->save();
            return response()->json(['status' => true, 'message' => ' Update Successfully.'], 200);
        }
        if ($dropDownValue == 'term_and_condition') {
            $webInfo = WebsiteInfo::find($web_id);
            $webInfo->terms_and_condition = $ed_data;
            $webInfo->save();
            return response()->json(['status' => true, 'message' => ' Update Successfully.'], 200);
        }
        if ($dropDownValue == 'privacy_policy') {
            $webInfo = WebsiteInfo::find($web_id);
            $webInfo->privacy_policy = $ed_data;
            $webInfo->save();
            return response()->json(['status' => true, 'message' => ' Update Successfully.'], 200);
        }
        if ($dropDownValue == 'advertise_with_us') {
            $webInfo = WebsiteInfo::find($web_id);
            $webInfo->advertise_with_us = $ed_data;
            $webInfo->save();
            return response()->json(['status' => true, 'message' => ' Update Successfully.'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Not Update.'], 201);
    }
    public function getData(Request $request)
    {
        $contentKey = $request->contentKey;
        $web_id = $request->web_id;

        $general = WebsiteInfo::query();

        if ($contentKey === 'about_us') {
            $general->select('about_us')->where('id', $web_id);
        }

        if ($contentKey === 'term_and_condition') {
            $general->select('terms_and_condition')->where('id', $web_id);
        }

        if ($contentKey === 'privacy_policy') {
            $general->select('privacy_policy')->where('id', $web_id);
        }

        if ($contentKey === 'advertise_with_us') {
            $general->select('advertise_with_us')->where('id', $web_id);
        }

        $general = $general->first();

        return response()->json(['data' => $general], 200);
    }
    public function getAverageRating()
    {
        $userId = Session::get('user')['id'];


        $ratings = Rating::select('id','jobseeker_id','company_id','ratings')
            ->where('company_id', $userId)
            ->get();

        if($ratings->count() == 0) {
            $ratings['average_rating'] = 0;
        } else {
            $ratings['average_rating'] = round($ratings->sum('ratings')/$ratings->count(), 1);
        }

        $userRating = $ratings->where('company_id',$userId)->first();

        if($userRating) {
            $ratings['user_rating'] = $userRating;
        } else {
            $ratings['user_rating'] = 0;
        }

        return response()->json(['data'=>$ratings], 200);
    }
    public function getPortalSocialLinks() {
        $data = DB::table('social_links')->get();
        return response()->json(['data'=>$data], 200);
    }
}
