<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobSeekerNotification;
use App\Models\EmployerNotification;

class NotificationController extends Controller
{

    /**
     * Get jobseeker job Notifications
     * 
     */

    public function getJobNotifications(){
        $notifications = JobSeekerNotification::join('jobmanagers', 'jobmanagers.id', '=', 'job_seeker_notifications.job_id')->select('jobmanagers.id', 'jobmanagers.title', 'jobmanagers.start_apply_date', 'job_seeker_notifications.job_post_date')->where('job_seeker_notifications.jobseeker_id', auth()->guard('jobseeker')->user()->id)->get();

        return view('jobseeker.notifications', ['notifications' => $notifications]);
    }

       /**
     * Get employer job Notifications
     * 
     */

    public function getEmployerNotifications(){
        $notifications = EmployerNotification::join('jobmanagers', 'jobmanagers.id', '=', 'employer_notifications.job_id')->join('jobseekers', 'jobseekers.id', '=', 'employer_notifications.jobseeker_id')->select('jobmanagers.title', 'jobmanagers.id', 'jobseekers.fname', 'jobseekers.lname', 'employer_notifications.jobseeker_id', 'employer_notifications.created_at')->where('employer_notifications.employer_id', auth()->guard('employer')->user()->id)->orderByDesc('employer_notifications.id')->get();

        return view('employer.notifications', ['notifications' => $notifications]);
    }
}
