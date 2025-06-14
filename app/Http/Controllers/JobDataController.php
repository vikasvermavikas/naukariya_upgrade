<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CURLFILE;

class JobDataController extends Controller
{
    /**
     * Get jobs from job board API.
     */ 
    public function index(Request $request)
    {
        $jobs = [];
        $search = "";
        if ($request->search) {
            $search = $request->search; 
        }
        $total_jobs = self::get_job_ids($search);
        arsort($total_jobs);
        $topTen = array_slice($total_jobs, 0, 10);
        if($topTen && count($topTen) > 0){
            for ($i=0; $i < count($topTen) ; $i++) { 
                $jobs[] = self::get_job_info($topTen[$i]);
            }
        }
        return view('public.job-board.job-listing', compact('jobs', 'search'));
    }

    /**
     * Get job ids
     */
    public static function get_job_ids($search = '')
    {
             $curl = curl_init();
            $data = array('employment_type' => 'full-time', 'location' => 'India');
            if ($search) {
               $data['title'] = $search;
            }
        $new_data = json_encode($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.coresignal.com/cdapi/v2/job_base/search/filter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $new_data,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'apikey: h4hUWO76eGkJkDWysr3EKtywBqCbSTok',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }  

    /**
     * Get job info
     */
    public static function get_job_info($jobid)
    {
         $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.coresignal.com/cdapi/v2/job_base/collect/' . $jobid . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'apikey: h4hUWO76eGkJkDWysr3EKtywBqCbSTok',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    }  

    /**
     * Get active jobs using active job api.
     */ 
    public function activejobs(Request $request)
    {
        $search = '';

        if ($request->search) {
            $search = $request->search;
        }
        $jobs = self::get_active_jobs($search);
        if (isset($jobs['message'])) {
           return $jobs['message'];
        }
        return view('public.job-board.active-jobs', compact('jobs', 'search'));
    }

    /**
     * Call active job api.
     */
    public static function get_active_jobs($title = '')
    {
         $curl = curl_init();
         $endpoint = 'https://active-jobs-db.p.rapidapi.com/active-ats-7d';
         $params = ['limit' => '10', 'offset' => '0', 'location_filter' => 'india', 'title_filter' => $title];
         $url = $endpoint . '?' . http_build_query($params);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-rapidapi-host: active-jobs-db.p.rapidapi.com',
                'x-rapidapi-key: 8ff07dba8amsh849fc07587cad6dp1a47edjsnd350f91cbf3b'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    } 

    /**
     * Get jobs using proxy curl api.
     */ 
    public function proxycurl(Request $request)
    {
        $search = '';
        $jobs = [];
        if ($request->search) {
            $search = $request->search;
        }
        $jobs = self::get_proxycurl_jobs($search);
        if (isset($jobs['description'])) {
           return $jobs['description'];
        }
        return view('public.job-board.proxy-curl', compact('jobs', 'search'));
    }

    /**
     * Call active job api.
     */
    public static function get_proxycurl_jobs($title = '')
    {
         $curl = curl_init();
         $endpoint = 'https://nubela.co/proxycurl/api/v2/linkedin/company/job';
         $params = ['keyword' => $title];
         $url = $endpoint . '?' . http_build_query($params);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer mPiL7fSxvMcRvLIDtUbjMw'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    } 



}
