<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Session;
use App\Models\AllUser;
use App\Models\Empcompaniesdetail;
use App\Models\Jobmanager;

class RatingController extends Controller
{
    public function assignRatings(Request $request)
    {

        $jobseeker_id = $request->js_id;
        $rating_no = $request->rt_no;
        $company_id = $request->cm_id;
        $userRatings = Rating::firstOrNew(['company_id' => $company_id, 'jobseeker_id' => $jobseeker_id]);
        $userRatings->company_id = $company_id;
        $userRatings->ratings = $rating_no;
        $userRatings->jobseeker_id = $jobseeker_id;
        $userRatings->save();


        if (!$userRatings) {
            return response()->json(['error' => false, 'message' => 'Not Done.'], 201);
        }

        return response()->json(['status' => true, 'message' => 'Ratings Done.'], 200);
    }
    public function getRatings(Request $request)
    {
        $jobseeker_id = Session::get('user')['id'];

        $job_id = $request->job_id;

        $getCompanyId = Jobmanager::where('id', $job_id)->first();

        $ratings = Rating::select('id', 'jobseeker_id', 'company_id', 'ratings')
            ->where('company_id', $getCompanyId->company_id)
            ->get();

        if ($ratings->count() == 0) {
            $ratings['average_rating'] = 0;
        } else {
            $ratings['average_rating'] = round($ratings->sum('ratings') / $ratings->count(), 1);
        }

        $userRating = $ratings->where('jobseeker_id', $jobseeker_id)->first();

        if ($userRating) {
            $ratings['user_rating'] = $userRating;
        } else {
            $ratings['user_rating'] = 0;
        }

        return response()->json(['data' => $ratings], 200);
    }
}
