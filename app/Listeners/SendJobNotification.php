<?php

namespace App\Listeners;

use App\Events\JobPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\JobSeekerNotification;

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
        JobSeekerNotification::firstOrCreate([
            'jobseeker_id' => $event->jobdetails->jobseeker_id,
            'job_id' => $event->jobdetails->jobid
        ],[
            'jobseeker_id' => $event->jobdetails->jobseeker_id,
            'job_id' => $event->jobdetails->jobid,
            'job_post_date' => $event->jobdetails->date
        ]);
    }
}
