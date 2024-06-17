<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\BecilUserData;

class GetBecilJobsDataController extends Controller
{
    public function getBecilData(Request $request)
    {
        
        $client = new Client();
        ini_set('memory_limit', '2048M');
		$response = $client->get('https://beciljobs.com/getdata/beciljobs');
// 		echo $response->getStatusCode(); // 200
//         echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
//         echo $response->getBody();
		$data = json_decode($response->getBody());
		echo $data;
		
		exit();
		
		//return response()->json($data);
		foreach ($data as $p)
	    {
            $becil = BecilUserData::firstOrCreate([
                    'fname'=>$p->fname,
                    'mname'=>$p->mname,
                    'lname'=>$p->lname,
                    'mobile'=>$p->mobile,
                    'email1'=>$p->email1,
                    'email2'=>$p->email2,
                    'registration_id'=>$p->registration_id,
                    'aadhar_no'=>$p->aadhar_no,
                    'pan_no'=>$p->pan_no,
                    'dob'=>$p->dob,
                    'nationality'=>$p->nationality,
                    'gender'=>$p->gender,
                    'prefered_location'=>$p->prefered_location1.','.$p->prefered_location2,
                    'category'=>$p->cat_name,
                    'highest_qualification'=>$p->higest_qualification,
                    'eight_school_name'=>$p->eight_school_name,
                    'eight_passing_year'=>$p->eight_passing_year,
                    'eight_marks'=>$p->eight_marks,
                    'ten_board_name'=>$p->ten_board_name,
                    'ten_passing_year'=>$p->ten_passing_year,
                    'ten_marks'=>$p->ten_marks,
                    'ten_stream'=>$p->ten_stream,
                    'twelve_board_name'=>$p->twelve_board_name,
                    'twelve_passing_year'=>$p->twelve_passing_year,
                    'twelve_marks'=>$p->twelve_marks,
                    'twelve_stream'=>$p->twelve_stream,
                    'diploma_institute_name'=>$p->diploma_institute_name,
                    'diploma_name'=>$p->diploma_name,
                    'diploma_passing_year'=>$p->diploma_passing_year,
                    'diploma_marks'=>$p->diploma_marks,
                    'diploma_stream'=>$p->diploma_stream,
                    'ug_degree'=>$p->ug_degree,
                    'ug_branch'=>$p->ug_branch,
                    'ug_university'=>$p->ug_university,
                    'ug_year'=>$p->ug_year,
                    'ug_marks'=>$p->ug_marks,
                    'ug_edu_type'=>$p->ug_edu_type,
                    'pg_degree'=>$p->pg_degree,
                    'pg_branch'=>$p->pg_branch,
                    'pg_university'=>$p->pg_university,
                    'pg_year'=>$p->pg_year,
                    'pg_marks'=>$p->pg_marks,
                    'pg_edu_type'=>$p->pg_edu_type,
                    'additional_institute_name'=>$p->additional_institute_name,
                    'additional_qual'=>$p->additional_qual,
                    'additional_qual_year'=>$p->additional_qual_year,
                    'additional_qual_marks'=>$p->additional_qual_marks,
                    'additional_qual_type'=>$p->additional_qual_type,
                    
                ]); // add $data here
            $msg =$becil->save();
        }
	    
        if($msg)
        {
            echo "Success";
        }else{
            echo "failed";
        }
    }
}
