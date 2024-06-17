<?php

namespace App\Http\Controllers;

use App\Models\ConsultantJob;
use App\Models\ConsultantCandidate;
use App\Models\Jobmanager;
use App\Models\Consultant;
use App\Http\Requests\ConsultantRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class ConsultantController extends Controller
{
    public function session_user()
    {
        $data = Session::get('user');
        return response()->json(['data' => $data], 200);
    }

    public function index(Request $request)
    {
        $jobmanager = Jobmanager::with(['companies' => function ($query) {
            return $query->select('id', 'company_name');
        }, 'companies.ratings' => function ($query) {
            $query->selectRaw('sum(ratings) as avg_rating, company_id')->groupBy('company_id');
        }])->select('id', 'company_id', 'job_role', 'job_for', 'job_ctc', 'job_exp', 'status')
            ->where('job_for', 'Consultant')
            ->where('status', 'Active')
            ->orderBy('created_at', 'DESC');

        if ($request->industry_id && $request->industry_id != '') {
            $jobmanager->where('job_industry_id', $request->industry_id);
        }

        if ($request->company_id && $request->company_id != '') {
            $jobmanager->where('company_id', $request->company_id);
        }

        if ($request->state_id && $request->state_id != '') {
            $jobmanager->where('job_state_id', $request->state_id);
        }

        return $jobmanager->paginate(10);
    }

    public function showJobDetails($id)
    {
        return Jobmanager::with(['companies' => function ($query) {
            return $query->select('id', 'company_name');
        }, 'companies.ratings' => function ($query) {
            $query->selectRaw('sum(ratings) as avg_rating, company_id')->groupBy('company_id');
        }])->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    public function getConsultantJob()
    {
        $emp_id = Session::get('user')['id'];
        return Jobmanager::with(['consultantJob', 'companies' => function ($query) {
            return $query->select('id', 'company_name');
        }])->select('id', 'company_id', 'job_role', 'job_ctc', 'job_exp', 'status', 'title', 'last_apply_date')
            ->where('job_for', 'Consultant')
            ->where('userid', $emp_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getAcceptedJobByConsultant()
    {
        $auth_id = Session::get('user')['id'];
        return ConsultantJob::with([
            'jobmanager' => function ($query) {
                return $query->select('id', 'company_id', 'job_exp', 'job_ctc', 'job_role');
            },
            'jobmanager.companies' => function ($query) {
                return $query->select('id', 'company_name');
            },
            'jobmanager.companies.ratings' => function ($query) {
                $query->selectRaw('sum(ratings) as avg_rating, company_id')->groupBy('company_id');
            }
        ])->where('status', 'accept')->where('consultant_id', $auth_id)->orderBy('created_at', 'DESC')->get();
    }

    public function acceptJob(Request $request)
    {
        $jobId = $request->job_id;
        $status = $request->status;
        $consultantId = Session::get('user')['id'];

        $data = [
            'consultant_id' => $consultantId,
            'jobmanager_id' => $jobId,
            'status' => $status
        ];

        if (isset($request->status) && $request->status !== null) {

            // Check consultant already applied or not
            $check = ConsultantJob::where('consultant_id', $consultantId)
                ->where('status', $status)
                ->where('jobmanager_id', $jobId)
                ->first();

            if (!$check) {
                $consultantJob = ConsultantJob::create($data);

                if ($consultantJob) {
                    return response()->json(['status' => 'success', 'message' => 'You have applied this job.', 'type' => $request->status], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Job not accept.'], 201);
                }
            }

            return response()->json(['status' => 'error', 'message' => 'You have already applied this job.'], 201);
        }

        return response()->json(['status' => 'error', 'message' => 'Status not set'], 201);
    }

    public function consultantRegistration(ConsultantRegistrationRequest $request)
    {
        $tags = $request->specialization;

        $comma_string = array();

        foreach ($tags as $key => $value) {
            $comma_string[] = $value['text'];
        }

        $specializations = implode(",", $comma_string);

        $last_id = Consultant::orderBy('id', 'DESC')->first();
        if ($last_id) {
            $id = $last_id->id;
        } else {
            $id = 0;
        }
        $id = $id + 1;
        $mob = $request->contact;
        $un = substr($mob, -4);
        $uid = "CON/" . $id . "/" . $un;
        $consultant = new Consultant();
        $consultant->unique_id = $uid;
        $consultant->first_name = $request->fname;
        $consultant->last_name = $request->lname;
        $consultant->email = $request->email;
        $consultant->password = Hash::make($request->password);
        $consultant->mobile = $request->contact;
        $consultant->gender = $request->gender;
        $consultant->company_name = $request->company_name;
        $consultant->designation = $request->designation;
        $consultant->industry_id = $request->industry;
        $consultant->job_type = $request->job_profile;
        $consultant->specialization = $specializations;
        $consultant->company_location = $request->company_location;
        $consultant->company_size = $request->company_size;
        $consultant->mobile_otp = $this->generateNumericOTP(4);
        $consultant->email_otp = $this->generateNumericOTP(6);
        $consultant->corporate_address = $request->address;
        $consultantRegistered = $consultant->save();

        if (!$consultantRegistered) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 201);
        }

        return response()->json(['status' => 'success', 'message' => 'Registration successfully'], 200);
    }

    function generateNumericOTP($n)
    {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    public function getAppliedActiveJobs()
    {
        $authId = Session::get('user')['id'];
        $activeJobs = ConsultantJob::with([
            'jobmanager' => function ($query) {
                $query->select('id', 'company_id', 'job_exp', 'job_ctc', 'job_role', 'status')->where('status', 'Active');
            },
            'jobmanager.companies' => function ($query) {
                $query->select('id', 'company_name');
            },
            'jobmanager.companies.ratings' => function ($query) {
                $query->selectRaw('sum(ratings) as avg_rating, company_id')->groupBy('company_id');
            }
        ])->select('id', 'jobmanager_id', 'percentage', 'status', 'created_at')
            ->where('consultant_id', $authId)
            ->where('status', 'accept')
            ->orderBy('created_at', 'DESC')
            ->get();

        $holdActiveJobs = array();

        foreach ($activeJobs as $actJob) {
            if (isset($actJob->jobmanager) && $actJob->jobmanager != null) {
                $holdActiveJobs[] = $actJob;
            }
        }

        return response()->json(['data' => $holdActiveJobs], 200);
    }

    public function getAppliedInactiveJobs()
    {
        $activeJobs = ConsultantJob::with([
            'jobmanager' => function ($query) {
                $query->select('id', 'company_id', 'job_exp', 'job_ctc', 'job_role', 'status')->where('status', 'Deactive');
            },
            'jobmanager.companies' => function ($query) {
                $query->select('id', 'company_name');
            },
            'jobmanager.companies.ratings' => function ($query) {
                $query->selectRaw('sum(ratings) as avg_rating, company_id')->groupBy('company_id');
            }
        ])->select('id', 'jobmanager_id', 'status', 'created_at')
            ->where('status', 'accept')
            ->orderBy('created_at', 'DESC')
            ->get();

        $holdInactiveJobs = array();

        foreach ($activeJobs as $actJob) {
            if (isset($actJob->jobmanager) && $actJob->jobmanager != null) {
                $holdInactiveJobs[] = $actJob;
            }
        }

        return response()->json(['data' => $holdInactiveJobs], 200);
    }

    public function getJobPositionLists($company_id)
    {
        $authId = Session::get('user')['id'];

        return DB::table('consultant_jobs')
            ->join('jobmanagers', 'jobmanagers.id', '=', 'consultant_jobs.jobmanager_id')
            ->select('jobmanagers.id', 'jobmanagers.title', 'jobmanagers.company_id', 'jobmanagers.job_role')
            ->where('consultant_jobs.consultant_id', '=', $authId)
            ->where('jobmanagers.company_id', '=', $company_id)
            ->where('consultant_jobs.assigned', '=', 'Yes')
            ->get();
    }

    public function getJobPositionCompany()
    {
        $authId = Session::get('user')['id'];

        return $companies = ConsultantJob::with(['jobmanager.companies' => function ($q) {
            $q->select('id', 'company_name')->distinct('company_name');
        }, 'jobmanager' => function ($query) {
            $query->select('id', 'title', 'company_id', 'job_role', 'status');
        }])->whereHas('jobmanager', function ($query) {
            $query->select('id', 'title', 'company_id', 'job_role', 'status')->where('status', 'Active');
        })->select('id', 'consultant_id', 'jobmanager_id', 'status')
            ->where('assigned', 'Yes')
            ->where('consultant_id', $authId)
            ->get();

        $demo = [];

        foreach ($companies as $company) {
            $demo[] = array('id' => $company->jobmanager->companies->id, 'company_name' => $company->jobmanager->companies->company_name);
        }

        $companies = collect($demo)->unique();

        if ($companies) {
            return response()->json(['status' => 'success', 'data' => $companies], 200);
        }

        return response()->json(['status' => 'error'], 201);
    }

    public function get_download()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/agreement/download.pdf";

        $headers = array(
            'Content-Type: application/pdf',
        );
        $filename = 'Agr.pdf';

        return Response::download($file, $filename, $headers);
    }

    public function login_consultant(Request $request)
    {
        $username = $request->email;
        $data = DB::table('consultants')
            ->where('email', $username)
            ->first();

        if (isset($data) && password_verify($request->password, $data->password)) {

            if ($data->email_verified == 'No') {
                return response()->json(['status' => 'email_unverified', 'message' => 'Please verify your email.'], 201);
            }

            if ($data->agreement_verified == 'No') {
                return response()->json(['status' => 'error', 'message' => 'Your document is under verification.'], 201);
            }

            if ($data->status == 'Active') {
                Session::put('user', ['id' => $data->id, 'first_name' => $data->first_name, 'last_name' => $data->last_name, 'email' => $data->email, 'last_login' => $data->last_login]);
                return response()->json(['status' => 'success', 'message' => 'Login success'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Your account is not active. Please contact your administrator.'], 201);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'You have entered wrong credentials.'], 201);
        }
    }

    public function consultantProfile()
    {
        $cons_uid = Session::get('user');

        return Consultant::where('id', $cons_uid)->first();
    }

    public function consultantLogout()
    {
        Auth::guard('jobseeker')->logout();
        $data = Session::forget('user');
        if ($data) {
            return response()->json(['success' => 'true'], 200);
        }
    }

    public function showconsultant()
    {
        $consultant = Consultant::with(['job_profile' => function ($q) {
            $q->select('id', 'job_sector');
        }, 'industries' => function ($q) {
            $q->select('id', 'category_name');
        }])->get();
        return response()->json(['data' => $consultant], 200);
    }

    public function consultantjobs()
    {
        $jobs = Jobmanager::with(['companies'])->where('job_for', 'Consultant')->where('status', 'Active')->get();
        return response()->json(['data' => $jobs], 200);
    }

    public function jdaccept()
    {

        $jd = ConsultantJob::with(['consultant' => function ($q) {
            $q->select('id', 'company_name');
        }, 'jobmanager' => function ($q) {
            $q->select('id', 'title');
        }])->where('status', 'accept')->get();


        return response()->json(['data' => $jd], 200);
    }

    public function update_status(Request $request)
    {
        $consultantId = $request->can_id;
        $status = $request->status;

        $consultant = Consultant::find($consultantId);


        if ($consultant) {
            $consultant->status = $status;
            $update = $consultant->update();

            if ($update) {
                return response()->json(['status' => true, 'message' => 'Consultant status changed.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Consultant status not changed.'], 201);
            }
        }
    }

    public function update_agreement(Request $request)
    {
        $consultantId = $request->can_id;
        $status = $request->status;

        $consultant = Consultant::find($consultantId);


        if ($consultant) {
            $consultant->agreement_verified = $status;
            $update = $consultant->update();

            if ($update) {
                return response()->json(['status' => true, 'message' => 'Consultant status changed.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Consultant status not changed.'], 201);
            }
        }
    }

    public function getEmployerDetailByConsultantJob($job_id)
    {
        return Jobmanager::with(['allusers', 'allusers.industry' => function ($q) {
            $q->select('id', 'category_name');
        }, 'allusers.functional_role' => function ($q) {
            $q->select('id', 'subcategory_name');
        }, 'companies' => function ($q) {
            $q->select('id', 'company_name');
        },])->where('id', $job_id)->first();
    }

    public function verifiedConsultant($job_id)
    {
        return ConsultantJob::with('consultant', 'consultant.industries', 'consultant.job_profile')
            ->where('status', 'accept')
            ->where('assigned', 'No')
            ->where('jobmanager_id', $job_id)->get();
    }

    public function verifiedConsultantAfterAssigned($job_id)
    {
        return ConsultantJob::with('consultant', 'consultant.industries', 'consultant.job_profile')
            ->where('status', 'accept')
            ->where('assigned', 'Yes')
            ->where('jobmanager_id', $job_id)->get();
    }

    public function assignJobConsultant(Request $request)
    {
        $consultant_job_id = $request->cons_job_id;
        $consultant_id = $request->cons_id;
        $input_vacancy = $request->inp_vac;
        $input_percentage = $request->inp_per;

        // Check vacancy available or not
        $countRemainingVacancy = $this->getOnlyRemainingVacancy($consultant_job_id);

        if ($input_vacancy > $countRemainingVacancy) {
            return response()->json(['status' => 'error', 'message' => 'You did not assign more then ' . $countRemainingVacancy], 201);
        }

        $consultant = ConsultantJob::where('consultant_id', $consultant_id)->where('jobmanager_id', $consultant_job_id)->update([
            'assigned_no_of_vaccancy' => $input_vacancy,
            'percentage' => $input_percentage,
            'assigned' => 'Yes'

        ]);
        if ($consultant) {
            return response()->json(['status' => 'success', 'message' => 'Assigned Success.'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Assigned Not Success.'], 201);
        }
    }

    public function getOnlyRemainingVacancy($job_id)
    {
        $data['job_detail'] = Jobmanager::select('id', 'title', 'job_vaccancy')
            ->where('id', $job_id)
            ->first();

        if (!$data['job_detail']) {
            return response()->json(['status' => 'error', 'message' => 'Whoops, Job id did not match '], 201);
        }

        $data['assigned_vaccancy'] = ConsultantJob::selectRaw('SUM(`assigned_no_of_vaccancy`) `total_assigned`')
            ->where('jobmanager_id', $job_id)
            ->first();

        $data['remaining_vaccany'] = $data['job_detail']->job_vaccancy - $data['assigned_vaccancy']->total_assigned;

        return $data['remaining_vaccany'];
    }

    public function getRemainingVaccancy($job_id)
    {
        $data = array();

        $data['job_detail'] = Jobmanager::select('id', 'title', 'job_vaccancy')
            ->where('id', $job_id)
            ->first();

        if (!$data['job_detail']) {
            return response()->json(['status' => 'error', 'message' => 'Whoops, Job id did not match '], 201);
        }

        $data['assigned_vaccancy'] = ConsultantJob::selectRaw('SUM(`assigned_no_of_vaccancy`) `total_assigned`')
            ->where('jobmanager_id', $job_id)
            ->first();

        $data['remaining_vaccany'] = $data['job_detail']->job_vaccancy - $data['assigned_vaccancy']->total_assigned;

        return response()->json(['data' => $data], 200);
    }

    public function getCandidateDetails($job_id)
    {

        return ConsultantCandidate::with(['consultant' => function ($q) {
            $q->select('id', 'unique_id');
        }])
            ->where('jobmanager_id', $job_id)->get();
    }

    public function updateCandidateStatus(Request $request)
    {
        $candidateId = $request->can_id;
        $status = $request->status;
        $jobId = $request->job_manager_id;

        $candidate = ConsultantCandidate::where(['jobmanager_id' => $jobId, 'id' => $candidateId])->first();

        if ($candidate) {
            $candidate->status = $status;
            $update = $candidate->update();

            if ($update) {
                return response()->json(['status' => true, 'message' => 'Candidate status changed.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Candidate status not changed.'], 201);
            }
        }
    }

    public function sendEmailOTP(Request $request)
    {
        $email = $request->email;

        $consultant = Consultant::where('email', $email)->first();

        $opt = $consultant->email_otp ? $consultant->email_otp : $this->generateNumericOTP(6);
        $consultant->email_otp = $opt;
        $consultant->save();

        if (!$consultant) {
            return response()->json(['status' => 'error', 'message' => 'Your are not registered with us'], 201);
        }

        $toEmail = $request->email;

        $data = ['otp' => $opt, 'name' => $consultant->first_name];

        Mail::send('SendMail.consultant.send-otp-consultant', $data, function ($message) use ($toEmail) {
            $message->to($toEmail)->subject('OTP Verification');
            $message->from('info@naukriyan.com', 'Naukriyan');
        });

        return response()->json(['status' => 'success', 'message' => 'OTP has been sent to your email'], 200);
    }

    public function verifyEmailOTP(Request $request)
    {
        $email = $request->params['email'];
        $emailOTP = $request->params['emailOTP'];

        // VERIFY OTP
        $consultant = Consultant::where(['email' => $email, 'email_otp' => $emailOTP])->first();

        if (!$consultant) {
            return response()->json(['status' => 'error', 'message' => 'OTP not match'], 201);
        }

        if ($consultant->email_verified === 'Yes') {
            return response()->json(['status' => 'error', 'message' => 'Email already verified'], 201);
        }

        // UPDATE EMAIL VERIFY COLUMN
        $consultantEmailUpdate = Consultant::where('email', $email)->update(['email_verified' => 'Yes', 'email_otp' => null]);

        if (!$consultantEmailUpdate) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again'], 201);
        }

        return response()->json(['status' => 'success', 'message' => 'OTP Verified. Please login to continue'], 200);
    }

    public function getCommissionAndJobLastDate($id)
    {
        $authId = Session::get('user')['id'];

        $jobLastDate = Jobmanager::where('id', $id)->first();

        $consultantCommission = Consultant::where('id', $authId)->first();

        $consultant['job_last_date'] = $jobLastDate->last_apply_date;
        $consultant['consultant_commission'] = $consultantCommission->commision_at_agreement;
        $consultant['job_id'] = $id;

        return $consultant;
    }

    public function getConsultantCompanyInfo()
    {
        $authId = Session::get('user')['id'];

        return Consultant::where('id', $authId)->first();
    }
}
