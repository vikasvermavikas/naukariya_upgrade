<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewScheduled extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $application_id;
    public $job_title;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$application_id,$job_title)
    {
        $this->name = $name;
        $this->application_id = $application_id;
        $this->job_title = $job_title;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Interview Scheduled')->view('SendMail/Jobmanager/interviewscheduled');
    }
}
