<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ConsultantProfileController extends Controller
{
    public function index()
    {
        $cons_uid = Session::get('user')['id'];
        $data = Consultant::where('id', $cons_uid)->first();

        return response()->json(['data' => $data], 200);
    }

    public function UpdateRemarks(Request $request)
    {
        $get_cons_id = $request->consultant_id;
        $get_remarks = $request->add_remarks;

        $consultant = Consultant::where('id', $get_cons_id)->update([
            'remarks' => $get_remarks
        ]);

        if (!$consultant) {
            return response()->json(['status' => false, 'message' => 'Remarks Not Updated.'], 201);
        }

        return response()->json(['status' => true, 'message' => 'Remarks Updated.'], 200);
    }

    public function update(Request $request)
    {
        $id = Session::get('user')['id'];

        $this->validate($request, [
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);

        $change = Consultant::find($id);

        $change->password = Hash::make($request->confirm_password);

        $saved = $change->save();

        if ($saved) {
            return response()->json(['success' => 'Password Changed'], 200);
        }

        return response()->json(['error' => 'Something went wrong'], 200);
    }

    public function updateConsultantPersonalInfo(Request $request)
    {
        $authId = Session::get('user')['id'];

        $data = [
            'designation' => $request->designation,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'id_number' => $request->id_number,
            'id_type' => $request->id_type,
            'profile_img' => $request->profile_img,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'facebook_url' => $request->facebook_url,
        ];

        $consultant = Consultant::where('id', $authId)->update($data);

        if (!$consultant) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Profile Update'], 200);

    }

    public function updateConsultantCompanyInfo(Request $request)
    {
        $authId = Session::get('user')['id'];

        $consultantInfo = Consultant::where('id', $authId)->first();

        // COMPANY LOGO
        if ($request->logo && $request->logo !='') {
            $fileBase64Url = $request->logo;

            $pos = strpos($fileBase64Url, ';');
            $filetype = explode('/', substr($fileBase64Url, 0, $pos))[1]; //get file type

            $allowedFileType = ['jpg', 'png', 'jpeg'];

            if (!in_array($filetype, $allowedFileType)) {
                return response()->json(['status' => 'error', 'message' => 'Please upload only image file.'], 201);
            }

            $contents = file_get_contents($fileBase64Url); //get the content from the URL

            $unique_logo_name = time() . 'consultant_logo' . $authId . '.' . $filetype; //file name

            Storage::put('/public/consultant_logo_banner/' . $unique_logo_name, $contents);
        }

        // COMPANY BANNER
        if ($request->banner && $request->banner !='') {
            $fileBase64Url = $request->banner;

            $pos = strpos($fileBase64Url, ';');
            $filetype = explode('/', substr($fileBase64Url, 0, $pos))[1]; //get file type

            $allowedFileType = ['jpg', 'png', 'jpeg'];

            if (!in_array($filetype, $allowedFileType)) {
                return response()->json(['status' => 'error', 'message' => 'Please upload only image file.'], 201);
            }

            $contents = file_get_contents($fileBase64Url); //get the content from the URL

            $unique_banner_name = time() . 'consultant_banner' . $authId . '.' . $filetype; //file name

            Storage::put('/public/consultant_logo_banner/' . $unique_banner_name, $contents);
        }

        $data = [
            'company_logo' => $unique_logo_name ? $unique_logo_name : $consultantInfo->company_logo,
            'company_banner' => $unique_banner_name ? $unique_banner_name : $consultantInfo->company_banner,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'industry_id' => $request->com_industry,
            'company_tagline' => $request->tagline,
            'company_owner_name' => $request->owner_name,
            'company_email' => $request->com_email,
            'company_contact' => $request->com_contact,
            'company_website' => $request->website,
            'company_establishment' => $request->established_year,
            'com_facebook' => $request->com_facebook,
            'com_twitter' => $request->com_twitter,
            'cio_no' => $request->cin_no,
            'company_size' => $request->employee_no,
            'revenue' => $request->revenue,
            'corporate_address' => $request->address,
            'com_linkedin' => $request->com_linkedin,
        ];

        $consultant = Consultant::where('id', $authId)->update($data);

        if (!$consultant) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Profile Update'], 200);

    }

    public function updateConsultantProfileImage(Request $request)
    {
        $authId = Session::get('user')['id'];
        $consultant = Consultant::where('id', $authId)->first();

        if ($consultant->profile_img) {
            Storage::delete('/public/consultant_profile_image/' . $consultant->profile_img);
            $consultant->profile_img = null;
            $consultant->save();
        }

        $fileBase64Url = $request->image;

        $pos = strpos($fileBase64Url, ';');
        $filetype = explode('/', substr($fileBase64Url, 0, $pos))[1]; //get file type

        $allowedFileType = ['jpg', 'png', 'jpeg'];

        if (!in_array($filetype, $allowedFileType)) {
            return response()->json(['status' => 'error', 'message' => 'Please upload only image file.'], 201);
        }

        $contents = file_get_contents($fileBase64Url); //get the content from the URL

        $unique_name = time() . 'consultant' . $authId . '.' . $filetype; //file name

        $consultantProfile = Consultant::where('id', $authId)->update(['profile_img' => $unique_name]);

        $path = public_path(). '/consultant_profile_image';

        Storage::put('/public/consultant_profile_image/' . $unique_name, $contents);

        if (!$consultantProfile) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Try again'], 201);
        }

        return response()->json(['status' => 'success', 'message' => 'Profile image updated'], 200);
    }

}
