<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Jobmanager;
use App\Models\Top3VideoResumes;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ProfileCompleteController extends Controller
{
    public function ProfilePercentage(){
        $maximumPoints  = 100;
        $point = 0; 
        // $id = Session::get('user')['id'];
        $getlastSavedstage = Auth::guard('jobseeker')->user()->savestage;  // get last saved stage.
        $percentage = ($getlastSavedstage - 1) * 20;   // every stage has a percentage of 20.


        // $data = DB::table('jobseekers')
        //     ->leftjoin('js_educational_details', 'js_educational_details.js_userid', '=', 'jobseekers.id')
        //     ->leftjoin('js_professional_details', 'js_professional_details.js_userid', '=', 'jobseekers.id')
        //     ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'jobseekers.id')
        //     ->leftjoin('js_certifications', 'js_certifications.js_userid', '=', 'jobseekers.id')
        //     ->leftjoin('js_skills', 'js_skills.js_userid', '=', 'jobseekers.id')
        //     ->select('jobseekers.*', 'js_educational_details.*', 'js_professional_details.*', 'js_resumes.*', 'js_certifications.*','js_skills.*')
        //     ->where('jobseekers.id', $id)
        //     ->first();

        //     {
        //         //assign personal and resume 40 points start
        //         if($data->fname != '')
        //         $point+=2;
        //         if($data->lname != '')
        //         $point+=2;
        //         if($data->email != '')
        //         $point+=2;
        //         if($data->contact != '')
        //         $point+=2;
        //         if($data->gender!= '')
        //         $point+=2;
        //         if($data->dob!= '')
        //         $point+=2;
        //         if($data->preferred_location!= '')
        //         $point+=2;
        //         if($data->candidate_type!= '')
        //         $point+=2;
        //         if($data->address!= '')
        //         $point+=2;
        //         if($data->profile_pic_thumb!= '')
        //         $point+=2;
        //         if($data->resume!= '')
        //         $point+=20;
        //         if($data->resume_video_link!= '')
        //         $point+=10;
        // //assign personal and resume 40 points end

        // //assign education 10 points start
        //         if($data->education!= '')
        //         $point+=2;
        //         if($data->degree_name!= '')
        //         $point+=2;
        //         if($data->percentage_grade!= '')
        //         $point+=2;
        //         if($data->passing_year!= '')
        //         $point+=2;
        //         if($data->institute_name!= '')
        //         $point+=1;
        //         if($data->institute_location!= '')
        //         $point+=1;
        //  //assign education 10 points end

        //  //assign skills 10 points start
        //         if($data->skill!= '')
        //         $point+=5;
        //         if($data->expert_level!= '')
        //         $point+=5;
        // //assign skills 10 points end

        // //assign certificates 5 points start
        //         if($data->course!= '')
        //         $point+=1;
        //         if($data->certificate_institute_name!= '')
        //         $point+=1;
        //         if($data->cert_from_date!= '')
        //         $point+=1;
        //         // if($data->cert_to_date!= '')
        //         // $point+=1;
        //         if($data->grade!= '')
        //         $point+=1;
        //         if($data->certification_type!= '')
        //         $point+=1;
        // //assign certificates 5 points end

        // //assign professional 20 points start
        //         if($data->designations!= '')
        //         $point+=4;
        //         if($data->organisation!= '')
        //         $point+=4;
        //         if($data->job_type!= '')
        //         $point+=4;
        //         if($data->from_date!= '')
        //         $point+=1;
        //         if($data->to_date!= '')
        //         $point+=1;
        //         if($data->industry_name!= '')
        //         $point+=2;
        //         if($data->functional_role!= '')
        //         $point+=2;
        //         if($data->responsibility!= '')
        //         $point+=2;
        // //assign certificates 20 points end

        // //assign personal for experience only 5 points start
        //         if($data->notice_period!= '')
        //         $point+=1;
        //         if($data->current_salary!= '')
        //         $point+=1;
        //         if($data->exp_year!= '')
        //         $point+=0.5;
        //         if($data->exp_month!= '')
        //         $point+=0.5;
        //         if($data->designation!= '')
        //         $point+=1;
        //         if($data->job_type!= '')
        //         $point+=1;
                
        // //assign personal for experience only 5 points end
                
        //      }
        //     //  $percentage = ($point*$maximumPoints)/100;
        //     $percentage = round(($point / $maximumPoints) * 100);

            // New code for getting percentage.
            
            return response()->json(['percentage' => $percentage], 200);
        
    }
    public function filterResume(Request $request)
    {
        
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $keyword =$request->keyword;
        $data = DB::table('js_resumes')
        ->leftjoin('jobseekers', 'jobseekers.id', '=', 'js_resumes.js_userid')
            ->select('js_resumes.id','js_userid','js_resumes.resume','js_resumes.created_at','jobseekers.fname','jobseekers.lname','jobseekers.email','jobseekers.contact','jobseekers.designation',
            'jobseekers.candidate_type','js_resumes.resume_video_link','jobseekers.preferred_location','jobseekers.exp_year','jobseekers.exp_month')->orderBy('id', 'desc'); 

       
        if (isset($from_date) && $from_date != '') {
            $data->Where('js_resumes.created_at', '>=', $from_date);
        }

        if (isset($to_date) && $to_date != '') {
            $data->Where('js_resumes.created_at', '<=', $to_date);
        }
        if (isset($keyword) && $keyword != '') {
            $data->Where('fname', 'like', "%$keyword%")
            ->orWhere('lname', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('contact', 'like', "%$keyword%")
            ->orWhere('designation', 'like', "%$keyword%")
            ->orWhere('preferred_location', 'like', "%$keyword%")
            ->orWhere('exp_year', 'like', "%$keyword%")
            ->orWhere('exp_month', 'like', "%$keyword%")
            ->orWhere('candidate_type', 'like', "%$keyword%");
        }
        
        $data = $data->get();
        $newCollection = $data->map(function ($item) use($from_date,$to_date){
            $multipleSkills = DB::table('js_skills')
            ->join('js_resumes', 'js_resumes.js_userid', 'js_skills.js_userid')
                ->select('js_skills.skill')->where('js_skills.js_userid', $item->js_userid);

                
                $multipleSkills = $multipleSkills->get();
                //close education


            $educations = ['skills' => $multipleSkills];
            
            

            $collection1 = collect($item)->merge($educations);
            

            return $collection1;
        });
        


        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $prePage = 25;

        $category = new \Illuminate\Pagination\LengthAwarePaginator(
        $newCollection->forPage($currentPage, $prePage), $newCollection->count(), $prePage, $currentPage
        );

        return response()->json(['data' => $category], 200);
    }
    public function getJobs()
    {
     $jobs = Jobmanager::leftjoin('apply_jobs', 'apply_jobs.job_id', '=', 'jobmanagers.id' )
     ->leftjoin('client_names', 'client_names.id', '=', 'jobmanagers.client_id' )
        ->select('jobmanagers.id', 'jobmanagers.title','jobmanagers.job_role','client_names.name as client_name',DB::raw("count(apply_jobs.id) as total"))
        ->groupBy('jobmanagers.id','jobmanagers.title','jobmanagers.job_role','client_names.name')
        ->get();
        return response()->json($jobs);
    }
    public function exportresumedetails()
    {
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=resume-export.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];
    
            $list = DB::table('js_resumes')
                ->leftjoin('jobseekers', 'jobseekers.id', '=', 'js_resumes.js_userid')
                ->select('jobseekers.fname','jobseekers.lname','jobseekers.email','jobseekers.contact','resume','resume_video_link','js_resumes.created_at')
                ->orderBy('js_resumes.id', 'desc')
                ->get(); 
                
            $list = collect($list)->map(function ($x)  {
                return [
                    'Name' => $x->fname . ' ' . $x->lname,
                    'Email' => $x->email,
                    'Contact' => $x->contact,
                    'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                    'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
                    'Date' => $x->created_at
                ];
            })->toArray();
    
            # add headers for each column in the CSV download
            array_unshift($list, array_keys($list[0]));
    
            $callback = function () use ($list) {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
    
            return Response::stream($callback, 200, $headers);
        
    }
    public function exportCheckedresumeDetails($id)
    {
        $ids = explode(',', $id);
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=resume-export.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];
    
            $list = DB::table('js_resumes')
                ->leftjoin('jobseekers', 'jobseekers.id', '=', 'js_resumes.js_userid')
                ->select('jobseekers.fname','jobseekers.lname','jobseekers.email','jobseekers.contact','resume','resume_video_link','js_resumes.created_at')
                ->orderBy('js_resumes.id', 'desc')
                ->whereIn('js_resumes.id', $ids)
                ->get(); 
                
            $list = collect($list)->map(function ($x)  {
                return [
                    'Name' => $x->fname . ' ' . $x->lname,
                    'Email' => $x->email,
                    'Contact' => $x->contact,
                    'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                    'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
                    'Date' => $x->created_at
                ];
            })->toArray();
    
            # add headers for each column in the CSV download
            array_unshift($list, array_keys($list[0]));
    
            $callback = function () use ($list) {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
    
            return Response::stream($callback, 200, $headers); 
    }
    public function filterResumeByJobs(Request $request)
    {
        $data = DB::table('apply_jobs')
        ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
        ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
        ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
        ->leftjoin('client_names', 'client_names.id', '=', 'jobmanagers.client_id' )
            ->select('apply_jobs.*','jobmanagers.title','jobmanagers.status','jobmanagers.job_role','jobseekers.fname','jobseekers.lname','jobseekers.email',
            'jobseekers.contact','js_resumes.resume','js_resumes.resume_video_link','client_names.name as clientname')
            ->orderBy('apply_jobs.id', 'desc'); 
        //dd($data);
       if (isset($request->keyword) && $request->keyword != '') {
            $data->Where('jobmanagers.title', 'like', "%$request->keyword%")
            ->orWhere('jobmanagers.status', 'like', "%$request->keyword%")
            ->orWhere('jobmanagers.job_role', 'like', "%$request->keyword%")
            ->orWhere('jobseekers.fname', 'like', "%$request->keyword%")
            ->orWhere('jobseekers.lname', 'like', "%$request->keyword%")
            ->orWhere('jobseekers.email', 'like', "%$request->keyword%")
            ->orWhere('jobseekers.contact', 'like', "%$request->keyword%")
            ->orWhere('apply_jobs.application_id', 'like', "%$request->keyword%");
        }
        if (isset($request->job_title) && $request->job_title != '') {
            $data->Where('jobmanagers.id', $request->job_title);
        }
        if (isset($request->status) && $request->status != '') {
                $data->Where('jobmanagers.status', $request->status);
         }
         if (isset($request->from_date) && $request->from_date != '') {
                $data->Where('apply_jobs.created_at', '>=', $request->from_date);
        }
    
        if (isset($request->to_date) && $request->to_date != '') {
        $data->Where('apply_jobs.created_at', '<=', $request->to_date);
        }


        $data = $data->paginate(100);

        return response()->json(['data' => $data], 200);    
    }
    public function exportresumedetailsByjobs()
    {
        
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=resumeByJobs.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];
    
            $list = DB::table('apply_jobs')
                ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
                ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
                ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
                ->leftjoin('client_names', 'client_names.id', '=', 'jobmanagers.client_id' )
                ->select('apply_jobs.*','jobmanagers.title','jobmanagers.status','jobseekers.fname','jobseekers.lname','jobseekers.email','jobseekers.contact',
                'js_resumes.resume','js_resumes.resume_video_link','apply_jobs.created_at','client_names.name as clientname')
                ->orderBy('apply_jobs.id', 'desc')
                ->get(); 
                
            $list = collect($list)->map(function ($x)  {
                return [
                    'Name' => $x->fname . ' ' . $x->lname,
                    'Email' => $x->email,
                    'Contact' => $x->contact,
                    'Applied For' => $x->title,
                    'Client name' => $x->clientname ? $x->clientname:'Not Specify(Internal Requirement)',
                    'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                    'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
                    'Date' => $x->created_at
                ];
            })->toArray();
    
            # add headers for each column in the CSV download
            array_unshift($list, array_keys($list[0]));
    
            $callback = function () use ($list) {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
    
            return Response::stream($callback, 200, $headers);
    }
    public function exportCheckedresumeDetailsByJobs($id)
    {
        $ids = explode(',', $id);
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=resumeByJobs.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];
    
            $list = DB::table('apply_jobs')
                ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
                ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
                ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
                ->leftjoin('client_names', 'client_names.id', '=', 'jobmanagers.client_id' )
                ->select('apply_jobs.*','jobmanagers.title','jobmanagers.status','jobseekers.fname','jobseekers.lname','jobseekers.email','jobseekers.contact',
                'js_resumes.resume','js_resumes.resume_video_link','apply_jobs.created_at','client_names.name as clientname')
                ->orderBy('apply_jobs.id', 'desc')
                ->whereIn('apply_jobs.id', $ids)
                ->get(); 
                
            $list = collect($list)->map(function ($x)  {
                return [
                    'Name' => $x->fname . ' ' . $x->lname,
                    'Email' => $x->email,
                    'Contact' => $x->contact,
                    'Applied For' => $x->title,
                    'Client name' => $x->clientname ? $x->clientname:'Not Specify(Internal Requirement)',
                    'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                    'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
                    'Date' => $x->created_at
                ];
            })->toArray();
    
            # add headers for each column in the CSV download
            array_unshift($list, array_keys($list[0]));
    
            $callback = function () use ($list) {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
    
            return Response::stream($callback, 200, $headers);
    }

    public function profileByVideo()
    {
        $data = DB::table('apply_jobs')
        ->leftjoin('jobmanagers', 'jobmanagers.id', '=', 'apply_jobs.job_id')
        ->leftjoin('jobseekers', 'jobseekers.id', '=', 'apply_jobs.jsuser_id')
        ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
        ->leftjoin('client_names', 'client_names.id', '=', 'jobmanagers.client_id' )
            ->select('apply_jobs.*','jobmanagers.title','jobmanagers.status','jobmanagers.job_role','jobseekers.fname','jobseekers.lname','jobseekers.email',
            'jobseekers.contact','js_resumes.resume_video_link','client_names.name as clientname')
            ->orderBy('apply_jobs.id', 'desc'); 
        //dd($data);
        $data->Where('js_resumes.resume_video_link', '<>', null);


        $data = $data->paginate(100);

        return response()->json(['data' => $data], 200);    
    }

    public function setTop3VideoResume($id)
    {
        $ids = explode(',', $id);
        $resumes = new Top3VideoResumes();
        $resumes->js_userid = $id;
        $resumes->save();
        return response()->json(['data' => $resumes], 200);    
    }

    public function getVideoResume(){
        $user_ids = Top3VideoResumes::first();
        $videoResumes = DB::table('apply_jobs')
        ->leftjoin('js_resumes', 'js_resumes.js_userid', '=', 'apply_jobs.jsuser_id')
        ->whereRaw("FIND_IN_SET(apply_jobs.id, '$user_ids->js_userid')")->get();
        return response()->json(['data' => $videoResumes], 200);   
    }
}
