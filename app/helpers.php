<?php

use Illuminate\Support\Facades\DB;

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
