<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateFunctionalrole extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mobile;
    public $job_title;
    public $functional;
    public $old_functionalrole;

   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$job_title,$functional,$old_functionalrole)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->job_title = $job_title;
        $this->functional = $functional;
        $this->old_functionalrole=$old_functionalrole;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Functional Role Updated')->view('SendMail/Functionalrole/update');
    }
}
