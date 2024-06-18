<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Updatejobmanager extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mobile;
    public $job_title;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$job_title)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->job_title = $job_title;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Jobmanager Update')->view('SendMail/Jobmanager/updatejobmanager');
    }
}
