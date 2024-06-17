<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Jobmanager;
use App\Models\Jobseeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecommendedJobController extends Controller
{
    public function recommendedJobs()
    {
        $uid = Session::get('user')['id'];
        $getRelevantKeywords = Jobseeker::with(['skills' => function ($q) {
            $q->select('js_userid', 'skill', 'expert_level');
        }])->select('id', 'industry_id', 'functionalrole_id', 'preferred_location', 'job_type')
            ->where('id', $uid)
            ->get();

        $skills = array();
        foreach ($getRelevantKeywords as $skillKeyword) {
            foreach ($skillKeyword['skills'] as $skill) {
                $skills[] = $skill->skill;
            }
        }

        $job = Jobmanager::with('companies')->where(function ($q) use ($skills) {

            foreach ($skills as $key => $skill) {
                if ($key == 0) {
                    $q->where('job_skills', 'like', '%' . $skill . '%')->where('status','Active');
                } else {
                    $q->orWhere('job_skills', 'like', '%' . $skill . '%')->where('status','Active');
                }
            }

            return $q;

        })->get();

        return response()->json(['data' => $job], 200);
    }
}
