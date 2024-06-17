<?php

namespace App\Http\Controllers;

use App\Models\ConsultantNotification;
use Illuminate\Support\Facades\Session;

class ConsultantNotificationController extends Controller
{
    public function index()
    {
        $consultant_id = Session::get('user')['id'];

        $notification = ConsultantNotification::where('consultant_id', $consultant_id)
            ->latest()
            ->take(3)
            ->get();

        $countNotification = ConsultantNotification::where('consultant_id', $consultant_id)
            ->where('read_notification', '0')
            ->count();

        return response()->json(['data' => $notification, 'count' => $countNotification], 200);

    }
}
