<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllUser;
use App\Models\Jobseeker;
use App\Models\Jobmanager;

class MasterController extends Controller
{
    public function real_time_updates(){
        $jobs = Jobmanager::where('status', 'Active')->count();
        $employers = AllUser::where('active', 'Yes')->count();
        $jobseekers = Jobseeker::where('active', 'Yes')->count();
        return response()->json(['jobs' => $jobs, 'employers' => $employers, 'jobseeker' => $jobseekers], 200);
    }
}
