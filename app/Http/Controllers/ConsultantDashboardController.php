<?php

namespace App\Http\Controllers;

use App\Models\ConsultantCandidate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ConsultantDashboardController extends Controller
{
    public function countDataConsultant()
    {
        $uid = Session::get('user')['id'];

        $today = Carbon::today();

        $data['joined'] = ConsultantCandidate::where('status', 'joined')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['offer_rejected'] = ConsultantCandidate::where('status', 'offer rejected')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['backout_after_join'] = ConsultantCandidate::where('status', 'backout after join')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['screening_rejected'] = ConsultantCandidate::where('status', 'screening rejected')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['screening_pending'] = ConsultantCandidate::where('status', 'screening pending')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['cv_rejected'] = ConsultantCandidate::where('status', 'cv_rejected')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['interview_rejected'] = ConsultantCandidate::where('status', 'interview rejected')
            ->where('consultant_id', $uid)->whereDate('created_at', $today)
            ->count();

        $data['pending'] = ConsultantCandidate::where('status', 'pending')
            ->where('consultant_id', $uid)
            ->whereDate('updated_at', $today)
            ->count();

        $data['interview'] = ConsultantCandidate::where('status', 'interview')
            ->where('consultant_id', $uid)->whereDate('updated_at', $today)
            ->count();

        $data['shortlisted'] = ConsultantCandidate::where('status', 'shortlisted')
            ->where('consultant_id', $uid)->whereDate('updated_at', $today)
            ->count();

        $data['offer'] = ConsultantCandidate::where('status', 'offer')
            ->where('consultant_id', $uid)->whereDate('updated_at', $today)
            ->count();

        $data['interview_scheduled'] = ConsultantCandidate::where('status', 'interview schedule')
            ->where('consultant_id', $uid)->whereDate('updated_at', $today)
            ->count();

        $data['screening_ratio_in_percentage'] = $data['interview'] ?? 1 / $data['pending'] ?? 1 * 100;
        $data['shortlisting_ratio_in_percentage'] = $data['shortlisted'] ?? 1 / $data['pending'] ?? 1 * 100;

        return response()->json(['data' => $data], 200);
    }
    //graph
    

    
}
