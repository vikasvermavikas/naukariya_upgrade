<?php

namespace App\Http\Controllers;

use App\Models\ConsolidateData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ConsolidateDataController extends Controllera
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $keyword = $request->keyword;
        $multikeyword = $request->multikeyword;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $source = $request->source;
        
        $location = $request->location;
        $skills = $request->skills;

        $data = ConsolidateData::orderBy('id','desc');

        if (isset($source) && $source != '') {
            $data->Where('source', $source);
        }
       
         if (isset($from_date) && $from_date != '') {
                $data->whereDate('created_at', '>=', $from_date);
        }
    
        if (isset($to_date) && $to_date != '') {
        $data->whereDate('created_at', '<=', $to_date);
        }

        if (isset($location) && $location != '') {
            $data->Where('current_location', 'like', "%$location%")
            ->orWhere('preferred_location', 'like', "%$location%");
        }

        if (isset($skills) && $skills != '') {
            $data->Where('key_skills', 'like', "%$skills%");
        }
        // if ($request->has('location')) {
        //     $data->whereHas('current_location', 
        //         function ($query) use ($request) {
        //             $query->whereIn('key_skills', 
        //                 $request->input('skills'));
        //         });
        // }
       

        if (isset($keyword) && $keyword != '') {
            $data->Where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('mobile_no', 'like', "%$keyword%")
            ->orWhere('annual_salary', 'like', "%$keyword%")
            ->orWhere('designation', 'like', "%$keyword%")
            ->orWhere('current_location', 'like', "%$keyword%")
            ->orWhere('preferred_location', 'like', "%$keyword%")
            ->orWhere('key_skills', 'like', "%$keyword%")
            ->orWhere('work_experience', 'like', "%$keyword%");
        }
        if (isset($multikeyword) && $multikeyword != '') {
            $key = explode(',',$multikeyword);
            //type1
            $data->whereIn('name',$key)
            ->orwhereIn('email', $key)
            ->orwhereIn('mobile_no', $key)
            ->orwhereIn('annual_salary', $key)
            ->orwhereIn('designation', $key)
            ->orwhereIn('current_location', $key)
            ->orwhereIn('preferred_location', $key)
            ->orwhereIn('key_skills', $key)
            ->orwhereIn('work_experience', $key);
            //type 2
        //     $data->Where(function ($query) use($key) {
        //         for ($i = 0; $i < count($key); $i++){
        //            $query->orwhere('name', 'like',  '%' . $key[$i] .'%')
        //            ->orWhere('email','like',  '%' . $key[$i] .'%')
        //            ->orWhere('mobile_no','like',  '%' . $key[$i] .'%')
        //            ->orWhere('annual_salary','like',  '%' . $key[$i] .'%')
        //            ->orWhere('designation','like',  '%' . $key[$i] .'%')
        //            ->orWhere('current_location','like',  '%' . $key[$i] .'%')
        //            ->orWhere('preferred_location','like',  '%' . $key[$i] .'%')
        //            ->orWhere('key_skills','like',  '%' . $key[$i] .'%')
        //            ->orWhere('work_experience','like',  '%' . $key[$i] .'%');
        //         }      
        //    })->get();

        //type 3
            // $data->Where('name', 'like', "%$key%")
            // ->orWhere('email', 'like', "%$key%")
            // ->orWhere('mobile_no', 'like', "%$key%")
            // ->orWhere('annual_salary', 'like', "%$key%")
            // ->orWhere('designation', 'like', "%$key%")
            // ->orWhere('current_location', 'like', "%$key%")
            // ->orWhere('preferred_location', 'like', "%$key%")
            // ->orWhere('key_skills', 'like', "%$key%")
            // ->orWhere('work_experience', 'like', "%$key%");
            
        }

        $data =$data->paginate(100);
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        
        $counter = 0;
        $totalRecords = 0;
        $filetype = $request->csvFile->getClientOriginalExtension();

        if($filetype == 'csv')
        {
            ini_set('max_execution_time', 3600);
            $imageName = time() . '.' . $request->csvFile->getClientOriginalExtension();

             $request->csvFile->move(public_path('/consolidateData/csv_file/'), $imageName);

            if (($handle = fopen(public_path('/consolidateData/csv_file/') . $imageName, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
    
                    //saving to db logic goes here
                    if (!$counter == 0) {
                        $totalRecords = $counter;
    
                        $requestData = [
                            'name' => mb_convert_encoding($data[0] ?? '', 'UTF-8', 'UTF-8'),
                            'resumeid' => mb_convert_encoding($data[1] ??  '', 'UTF-8', 'UTF-8'),
                            'dob' => mb_convert_encoding($data[2] ??   '', 'UTF-8', 'UTF-8'),
                            'designation' => mb_convert_encoding($data[3] ?? '', 'UTF-8', 'UTF-8'),
                            'education' => mb_convert_encoding($data[4] ??'', 'UTF-8', 'UTF-8'),
                            'ug_course' => mb_convert_encoding($data[5] ?? '', 'UTF-8', 'UTF-8'),
                            'pg_course' => mb_convert_encoding($data[6] ?? '', 'UTF-8', 'UTF-8'),
                            'ppg_course' => mb_convert_encoding($data[7] ??'', 'UTF-8', 'UTF-8'),
                            'work_experience' => mb_convert_encoding($data[8] ?? '', 'UTF-8', 'UTF-8'),
                            'current_employer' => mb_convert_encoding($data[9] ?? '', 'UTF-8', 'UTF-8'),
                            'previous_employers' => mb_convert_encoding($data[10] ?? '', 'UTF-8', 'UTF-8'),
                            'key_skills' => mb_convert_encoding($data[11] ?? '', 'UTF-8', 'UTF-8'),
                            'current_location' => mb_convert_encoding($data[12] ?? '', 'UTF-8', 'UTF-8'),
                            'preferred_location' => mb_convert_encoding($data[13] ?? '', 'UTF-8', 'UTF-8'),
                            'state' => mb_convert_encoding($data[14] ?? '', 'UTF-8', 'UTF-8'),
                            'nationality' => mb_convert_encoding($data[15] ?? '', 'UTF-8', 'UTF-8'),
                            'work_authorization' => mb_convert_encoding($data[16] ?? '', 'UTF-8', 'UTF-8'),
                            'category' => mb_convert_encoding($data[17] ?? '', 'UTF-8', 'UTF-8'),
                            'roles' => mb_convert_encoding($data[18] ?? '', 'UTF-8', 'UTF-8'),
                            'industry' => mb_convert_encoding($data[19] ?? '', 'UTF-8', 'UTF-8'),
                            'status' => mb_convert_encoding($data[20] ?? '', 'UTF-8', 'UTF-8'),
                            'source' => mb_convert_encoding($data[21] ?? '', 'UTF-8', 'UTF-8'),
                            'received_date' => mb_convert_encoding($data[22] ?? '', 'UTF-8', 'UTF-8'),
                            'postal_address' => mb_convert_encoding($data[23] ?? '', 'UTF-8', 'UTF-8'),
                            'email' => mb_convert_encoding($data[24] ?? '', 'UTF-8', 'UTF-8'),
                            'telephone_no' => mb_convert_encoding($data[25] ?? '', 'UTF-8', 'UTF-8'),
                            'mobile_no' => mb_convert_encoding($data[26] ?? '', 'UTF-8', 'UTF-8'),
                            'mobile_verified' => mb_convert_encoding($data[27] ?? '', 'UTF-8', 'UTF-8'),
                            'annual_salary' => mb_convert_encoding($data[28] ?? '', 'UTF-8', 'UTF-8'),
                            'last_active_date' => mb_convert_encoding($data[29] ?? '', 'UTF-8', 'UTF-8'),
                            'notes' => mb_convert_encoding($data[30] ?? '', 'UTF-8', 'UTF-8'),
                            'active' => '1',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        //dd($requestData);
                        DB::table('consolidate_datas')->insert($requestData);
                    }
    
                    $counter++;
                }
    
                fclose($handle);
    
                unlink(public_path('/consolidateData/csv_file/') . $imageName);
                return response()->json(['status' => 'success', 'message' => 'You have successfully import File.', 'total_record' => $totalRecords], 201);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Went wrong.'], 203);
        }

        
        return response()->json(['status' => 'alert', 'message' => 'Only CSV Files Allowed.'], 202);
        
    }
    public function getUniqueSource()
    {
        $data =ConsolidateData::distinct()->pluck('source');
        //$data =$data->unique();

        return response()->json(['data'=>$data]);
    }
    public function exportBulkData()
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=bulk-export.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = DB::table('consolidate_datas')
            ->select('consolidate_datas.*')
            ->orderBy('id', 'desc')
            ->get(); 
            $no =0;
        $list = collect($list)->map(function ($x ,$no)  {
            return [
                'S.No' => $no +1,
                'Name' => $x->name,
                'Email' => $x->email,
                'Contact' => $x->mobile_no,
                'Designation' => $x->designation ? $x->designation :'Not Available',
                'Experience' => $x->work_experience ? $x->work_experience:'Fresher',
                'Annual Salary' => $x->annual_salary ? $x->annual_salary :'Not Available',
                'Date' => $x->created_at
                // 'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                // 'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
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
    public function ExportBulkCheckedData($id)
    {
        $ids = explode(',', $id);
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=bulk-export.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];
    
            $list = DB::table('consolidate_datas')
            ->select('consolidate_datas.*')
            ->orderBy('id', 'desc')
            ->whereIn('id', $ids)
            ->get(); 
          $no =0;  
        $list = collect($list)->map(function ($x,$no)  {
            return [
                'S.No' => $no +1,
                'Name' => $x->name,
                'Email' => $x->email,
                'Contact' => $x->mobile_no,
                'Designation' => $x->designation ? $x->designation :'Not Available',
                'Experience' => $x->work_experience ? $x->work_experience:'Fresher',
                'Annual Salary' => $x->annual_salary ? $x->annual_salary :'Not Available',
                'Date' => $x->created_at
                // 'Resume' => $x->resume ? url('resume/' . $x->resume) : 'Not Available',
                // 'Video Resume' => $x->resume_video_link ? $x->resume_video_link : 'Not Available',
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

}
