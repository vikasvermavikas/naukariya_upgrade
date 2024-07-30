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

if (!function_exists('get_profile_completion')) {
    /**
     * Return profile completion.
     *
     * @return string
     */

    function get_profile_completion()
    {
        $maximumPoints  = 100;
        $point = 0;
        $id = auth()->guard('jobseeker')->user()->id;
        $data = DB::table('jobseekers')
            ->leftjoin('js_educational_details', 'js_educational_details.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_professional_details', 'js_professional_details.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_certifications', 'js_certifications.js_userid', '=', 'jobseekers.id')
            ->leftjoin('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id')
            ->select('jobseekers.*', 'js_educational_details.*', 'js_professional_details.*', 'js_resumes.*', 'js_certifications.*', 'js_skills.*')
            ->where('jobseekers.id', $id)
            ->first(); {
            //assign personal and resume 40 points start
            if ($data->fname != '')
                $point += 2;
            if ($data->lname != '')
                $point += 2;
            if ($data->email != '')
                $point += 2;
            if ($data->contact != '')
                $point += 2;
            if ($data->gender != '')
                $point += 2;
            if ($data->dob != '')
                $point += 2;
            if ($data->preferred_location != '')
                $point += 2;
            if ($data->candidate_type != '')
                $point += 2;
            if ($data->address != '')
                $point += 2;
            if ($data->profile_pic_thumb != '')
                $point += 2;
            if ($data->resume != '')
                $point += 20;
            if ($data->resume_video_link != '')
                $point += 10;
            //assign personal and resume 40 points end

            //assign education 10 points start
            if ($data->education != '')
                $point += 2;
            if ($data->degree_name != '')
                $point += 2;
            if ($data->percentage_grade != '')
                $point += 2;
            if ($data->passing_year != '')
                $point += 2;
            if ($data->institute_name != '')
                $point += 1;
            if ($data->institute_location != '')
                $point += 1;
            //assign education 10 points end

            //assign skills 10 points start
            if ($data->skill != '')
                $point += 5;
            if ($data->expert_level != '')
                $point += 5;
            //assign skills 10 points end

            //assign certificates 5 points start
            if ($data->course != '')
                $point += 1;
            if ($data->certificate_institute_name != '')
                $point += 1;
            if ($data->cert_from_date != '')
                $point += 1;
            // if($data->cert_to_date!= '')
            // $point+=1;
            if ($data->grade != '')
                $point += 1;
            if ($data->certification_type != '')
                $point += 1;
            //assign certificates 5 points end

            //assign professional 20 points start
            if ($data->designations != '')
                $point += 4;
            if ($data->organisation != '')
                $point += 4;
            if ($data->job_type != '')
                $point += 4;
            if ($data->from_date != '')
                $point += 1;
            if ($data->to_date != '')
                $point += 1;
            if ($data->industry_name != '')
                $point += 2;
            if ($data->functional_role != '')
                $point += 2;
            if ($data->responsibility != '')
                $point += 2;
            //assign certificates 20 points end

            //assign personal for experience only 5 points start
            if ($data->notice_period != '')
                $point += 1;
            if ($data->current_salary != '')
                $point += 1;
            if ($data->exp_year != '')
                $point += 0.5;
            if ($data->exp_month != '')
                $point += 0.5;
            if ($data->designation != '')
                $point += 1;
            if ($data->job_type != '')
                $point += 1;

            //assign personal for experience only 5 points end

        }
        $percentage = round(($point / $maximumPoints) * 100);

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
