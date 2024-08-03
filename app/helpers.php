<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function get_experience()
{
    $experiences = [];
    $result = DB::table('tracker_past_experience as tpe')
        ->select(
            'tpe.tracker_candidate_id',
            DB::raw('GROUP_CONCAT(company_name) as company_name'),
            DB::raw('GROUP_CONCAT(designation) as designation'),
            DB::raw('GROUP_CONCAT(CONCAT(tpe.from, " to ", tpe.to)) as from_date')
        )
        ->groupBy('tpe.tracker_candidate_id')
        ->get()->keyBy('tracker_candidate_id')->toArray();
    // if (!$result->isEmpty()) {
    //     foreach ($result as $dataItem) {
    //         $experiences[$dataItem->tracker_candidate_id] = $dataItem;
    //     }
    // }
    return $result;
}

if (!function_exists('get_profile_completion')) {
    /**
     * Return profile completion.
     *
     * @return string
     */

    function get_profile_completion()
    {
        $getlastSavedstage = Auth::guard('jobseeker')->user()->savestage;  // get last saved stage.
        $percentage = ($getlastSavedstage - 1) * 20;   // every stage has a percentage of 20.
        return $percentage;
    }
}

if (!function_exists('get_social_links')) {
    /**
     * Get social links.
     * 
     * @return object
     */

     function get_social_links(){
        $data = DB::table('social_links')->first();
        return $data;

     }
    
}
