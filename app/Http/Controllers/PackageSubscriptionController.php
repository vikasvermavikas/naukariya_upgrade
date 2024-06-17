<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageSubscriptionController extends Controller
{

    public function index($id)
    {
        $test = DB::table('packagemanagers')
            ->select('packagemanagers.validity')
            ->where('id', $id)
            ->first();
        return $test->validity;
    }

    public function buy($id)
    {
        $validity = DB::table('packagemanagers')
            ->select('packagemanagers.validity')
            ->where('id', $id)
            ->first();

        $userid = Session::get('user')['id'];
        $user_type = Session::get('user')['user_type'];

        $buy = new PackageSubscription();

        $buy->user_id = $userid;
        $buy->user_type = $user_type;
        $buy->package_expiry_date = Carbon::now()->addDays($validity->validity);
        $buy->package_id = $id;

        $buy->save();

    }

    public function buyJobseeker($id)
    {
        $userid = Session::get('user')['id'];
        $user_type = Session::get('user')['user_type'];

        $buy = new PackageSubscription();

        $buy->user_id = $userid;
        $buy->user_type = $user_type;
        $buy->package_id = $id;

        $buy->save();

    }

    public function checkUserBuyPackage()
    {
        $userId = Session::get('user')['id'];
        $buypackage = PackageSubscription::select('package_id')->where('user_id', $userId)->get();

        return response()->json($buypackage, 200);
    }
}
