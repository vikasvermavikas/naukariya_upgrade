<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\Jobnotice;
use App\Models\Jobs;
use App\Models\Designation;
use App\Models\Joblocation;
use App\Models\Joborganisation;
use Illuminate\Support\Facades\DB;
use App\Models\SaveSearchUrl;
use Session;

class SearchController extends Controller
{

    public function joblist()
    {
        $data = DB::table('jobs')
            ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
            ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
            ->leftjoin('recruiters', 'recruiters.id', '=', 'jobs.recruiter_id')
            ->leftjoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type_id')
            ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
            ->leftjoin('joborganisations', 'joborganisations.id', '=', 'jobs.org_id')
            ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'jobs.location_id', 'joblocations.joblocation', 'joborganisations.organisation', 'designations.designation', 'jobtypes.jobtype', 'recruiters.recruiter', 'advertisements.advertisement_no')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function jobdesc($id)
    {
        $data = DB::table('jobs')
            ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
            ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
            ->leftjoin('recruiters', 'recruiters.id', '=', 'jobs.recruiter_id')
            ->leftjoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type_id')
            ->leftjoin('jobattachments', 'jobattachments.id', '=', 'jobs.id')
            ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
            ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'joblocations.joblocation', 'designations.designation', 'jobtypes.jobtype', 'recruiters.recruiter', 'advertisements.advertisement_no', 'jobattachments.attachment')
            ->where('jobs.id', $id)
            ->first();

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function jobnotice($id)
    {
        $data = DB::table('jobnotices')
            ->select('jobnotices.notice_heading', 'jobnotices.notice_attachment')
            ->where('jobnotices.adv_id', $id)
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function jobView()
    {
        $data = DB::table('jobs')
            ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
            ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
            ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
            ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'jobs.location_id', 'joblocations.joblocation', 'joblocations.joblocation', 'designations.designation', 'advertisements.advertisement_no')
            ->limit('20')
            ->orderBy('jobs.id', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function jobNoticeView()
    {
        $data = DB::table('jobnotices')
            ->select('jobnotices.adv_id', 'jobnotices.notice_heading', 'jobnotices.notice_attachment')
            ->limit('10')
            ->orderBy('jobnotices.id', 'DESC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function searchpost()
    {
        $search = \Request::get('s');
        if ($search != null) {
            $data = DB::table('jobs')
                ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
                ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
                ->leftjoin('recruiters', 'recruiters.id', '=', 'jobs.recruiter_id')
                ->leftjoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type_id')
                ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
                ->leftjoin('joborganisations', 'joborganisations.id', '=', 'jobs.org_id')
                ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'jobs.location_id', 'joblocations.joblocation', 'joborganisations.organisation', 'designations.designation', 'jobtypes.jobtype', 'recruiters.recruiter', 'advertisements.advertisement_no')
                ->where('jobs.location_id', 'LIKE', "%$search%")
                //->orWhere('description','LIKE',"%$search%")
                ->get();
            return response()->json(['data' => $data], 200);
        } else {
            return $this->joblist();
        }
    }

    public function searchclosingdate()
    {
        $search = \Request::get('s');
        if ($search != null) {
            $data = DB::table('jobs')
                ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
                ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
                ->leftjoin('recruiters', 'recruiters.id', '=', 'jobs.recruiter_id')
                ->leftjoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type_id')
                ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
                ->leftjoin('joborganisations', 'joborganisations.id', '=', 'jobs.org_id')
                ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'jobs.location_id', 'joblocations.joblocation', 'joborganisations.organisation', 'designations.designation', 'jobtypes.jobtype', 'recruiters.recruiter', 'advertisements.advertisement_no')
                ->where('jobs.closing_date', '<=', $search)
                //->orWhere('description','LIKE',"%$search%")
                ->get();
            return response()->json(['data' => $data], 200);
        } else {
            return $this->joblist();
        }
    }

    public function searchorg()
    {
        $search = \Request::get('s');
        if ($search != null) {
            $data = DB::table('jobs')
                ->leftjoin('advertisements', 'advertisements.id', '=', 'jobs.adv_id')
                ->leftjoin('designations', 'designations.id', '=', 'jobs.designation_id')
                ->leftjoin('recruiters', 'recruiters.id', '=', 'jobs.recruiter_id')
                ->leftjoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type_id')
                ->leftjoin('joblocations', 'joblocations.id', '=', 'jobs.location_id')
                ->leftjoin('joborganisations', 'joborganisations.id', '=', 'jobs.org_id')
                ->select('jobs.id', 'jobs.no_of_vacancy', 'jobs.description', 'jobs.opening_date', 'jobs.closing_date', 'jobs.location_id', 'joblocations.joblocation', 'joborganisations.organisation', 'designations.designation', 'jobtypes.jobtype', 'recruiters.recruiter', 'advertisements.advertisement_no')
                ->where('jobs.org_id', 'LIKE', "%$search%")
                //->orWhere('description','LIKE',"%$search%")
                ->get();
            return response()->json(['data' => $data], 200);
        } else {
            return $this->joblist();
        }
    }

    public function location()
    {
        $data = Joblocation::all();
        return response()->json(['data' => $data], 200);
    }

    public function organisation()
    {
        $data = Joborganisation::all();
        return response()->json(['data' => $data], 200);
    }
    public function AddSearchUrl(Request $request)
    {
        
        $name=$request->params['searchname'];
        $url=$request->params['url'];
        $uid =Session::get('user')['id'];
        $add = new SaveSearchUrl();

        $add->search_name = $name;
        $add->url = $url;
        $add->emp_id = $uid;

        $add->save();
        if (!$add) {
            return response()->json(['status' => 'error', 'message' => 'Not Save'], 406);
        }

        return response()->json(['status' => 'success', 'message' => 'URL saved successfully'], 201);

    }

    public function getAllSearchUrl()
    {
        $emp_id = Session::get('user')['id'];
        $getUrl = DB::table('save_search_urls')
        ->where('emp_id', $emp_id)
        ->get();
        return response()->json(['data' => $getUrl], 200);
    }
   

}
