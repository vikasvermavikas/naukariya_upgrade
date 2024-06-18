<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangePassword extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $new_pass;
    public $job_title;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$job_title,$new_pass)
    {
        $this->name = $name;
        $this->job_title = $job_title;
        $this->new_pass = $new_pass;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Change')->view('SendMail/change-password');
    }
}
