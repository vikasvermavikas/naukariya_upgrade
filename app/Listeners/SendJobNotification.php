<?php

namespace App\Listeners;

use App\Events\JobPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\JobSeekerNotification;
use Illuminate\Support\Facades\Mail;
use Auth;

class SendJobNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobPost $event): void
    {
        $email = $event->jobdetails->email;


        // Send Notification to jobseeker.
        JobSeekerNotification::firstOrCreate([
            'jobseeker_id' => $event->jobdetails->jobseeker_id,
            'job_id' => $event->jobdetails->jobid
        ],[
            'jobseeker_id' => $event->jobdetails->jobseeker_id,
            'job_id' => $event->jobdetails->jobid,
            'job_post_date' => $event->jobdetails->date
        ]);

        $jsdata = (array) $event->jobdetails;
        // Send Email to Jobseekers.
         Mail::send('SendMail.requirement', ['jsdata' => $jsdata], function ($message) use ($email) {
                $message->from(env('MAIL_USERNAME'), 'Naukriyan.com');
                // $message->from(env('TEST_USEREMAIL'));
                $message->to($email)->subject('You have a new job in your inbox!');
            });
    }
}
