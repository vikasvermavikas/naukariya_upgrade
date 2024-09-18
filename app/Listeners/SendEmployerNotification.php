<?php

namespace App\Listeners;

use App\Events\JobApplied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\EmployerNotification;

class SendEmployerNotification
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
    public function handle(JobApplied $event): void
    {
          EmployerNotification::firstOrCreate([
            'jobseeker_id' => $event->appliedjobdetails->jobseeker_id,
            'job_id' => $event->appliedjobdetails->job_id
        ],[
            'jobseeker_id' => $event->appliedjobdetails->jobseeker_id,
            'job_id' => $event->appliedjobdetails->job_id,
            'employer_id' => $event->appliedjobdetails->employer_id,
            'read_notification' => 0,
            'type' => '\App\Jobmanager',
            'status' => 1
        ]);
    }
}
