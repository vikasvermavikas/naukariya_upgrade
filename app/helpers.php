<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobseeker;
use App\Models\JsSkill;
use App\Models\Jobmanager;
use App\Models\Tracker;
use App\Models\JsResume;
use App\Models\JobResume;
use App\Models\MailDownload;


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

if (!function_exists('get_education_details')) {
    /**
     * Get education_details.
     * 
     * @return array
     */

     function get_education_details($id){
        $data = DB::table('tracker_education')->where('tracker_candidate_id', $id)->first();
        return $data;
     }
    
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

if (!function_exists('is_guest')) {
    /**
     * Check user is guest or not.
     * 
     * @return bool, true if user is guest, false otherwise.
     */

     function is_guest(){
        
        if (!auth::guard('employer')->check() && !auth::guard('jobseeker')->check() && !auth::guard('subuser')->check()) {
            return true;
        }

        return false;

     }
    
}

if (!function_exists('jobseeker_match_skill')) {
    /**
     * Get jobseeker match skill to job skill.
     * 
     * @return integer, matching percentage of jobseeker skill.
     */

     function jobseeker_match_skill($jobid, $jobseekerid){
        $jobskiils = Jobmanager::select('job_skills')->where('id', $jobid)->first();
        $allskills = explode(',', $jobskiils->job_skills);
        $allskills = array_unique(array_map('trim', $allskills));
        $totalskills = count($allskills);

        if ($totalskills) {
        $jobseekerSkills = JsSkill::select(DB::raw('GROUP_CONCAT( skill ) as skills'))
                                  ->where('js_userid', $jobseekerid)
                                  ->groupBy('js_userid')
                                  ->first();

        $jobseeker_skill = explode(',', $jobseekerSkills->skills);
        $jobseeker_skill = array_unique(array_map('trim', $jobseeker_skill));

        $skillnotmatch = array_udiff($allskills, $jobseeker_skill, 'strcasecmp');

        $total_not_match = count($skillnotmatch);

        $netpercentage = (($totalskills - $total_not_match) / $totalskills) * 100;
        return round($netpercentage);
        }

        return 0;


        

     }
    
}

if (!function_exists('tracker_match_skill')) {
    /**
     * Get jobseeker match skill to job skill.
     * 
     * @return integer, matching percentage of jobseeker skill.
     */

     function tracker_match_skill($jobid, $trackerid){
        $jobskiils = Jobmanager::select('job_skills')->where('id', $jobid)->first();
        $allskills = explode(',', $jobskiils->job_skills);
        $allskills = array_unique(array_map('trim', $allskills));
        $totalskills = count($allskills);

        if ($totalskills) {
        $trackerk_skill = Tracker::select('key_skills')
                                  ->where('id', $trackerid)
                                  ->first();

        $trackerk_skill = explode(',', $trackerk_skill->key_skills);
        $trackerk_skill = array_unique(array_map('trim', $trackerk_skill));

        $skillnotmatch = array_udiff($allskills, $trackerk_skill, 'strcasecmp');

        $total_not_match = count($skillnotmatch);

        $netpercentage = (($totalskills - $total_not_match) / $totalskills) * 100;
        return round($netpercentage);
        }

        return 0;


        

     }
    
}

/**
* Get jobseeker resume.
* @param $jobseeker_id
* @param $jobseeker_id
* @return resume link.
*/
if (!function_exists('get_jobseeker_resume')) {

    function get_jobseeker_resume($jobseeker_id, $jobid = ''){
        try {
            $profile_resume = JsResume::select('resume', 'updated_at', 'created_at')->where('js_userid', $jobseeker_id)->first();
            if ($profile_resume && $profile_resume->resume) {
                $resume = $profile_resume->resume;
            }

            if ($jobid) {
        $job_resume = JobResume::select('resume', 'created_at')->where('jobseeker_id', $jobseeker_id)->where('job_id', $jobid)->first();
            }
            if ($profile_resume && $jobid && $job_resume) {
           if (strtotime($profile_resume->updated_at) > strtotime($job_resume->created_at) ) {
               return $profile_resume->resume;
           }
           else {
            return $job_resume->resume;
           }
            }
            else if($profile_resume && empty($job_resume)) {
            return $profile_resume->resume;
            }
            else if($job_resume) {
            return $job_resume->resume;
            }
            else {
            return '';
            }
        }
        catch (Throwable $th) {
            return '';
        }
       
    }
}

/**
 * Store attachment.
 * @param object $data
 */
if (!function_exists('store_attachment')) {
    function store_attachment($data){
        MailDownload::create([
            'mail_date' => $data['date'],
            'file_original_name' => $data['filename'],
            'file_name' => $data['stored_file'],
            'download_status' => $data['download_status']
        ]);
    }
}
