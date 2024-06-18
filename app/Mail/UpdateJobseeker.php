<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateJobseeker extends Mailable
{
    use Queueable, SerializesModels;
    
    public $name;
    public $mobile;
    public $emailid;
    public $password;
   
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$password,$emailid)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->password = $password;
         $this->emailid = $emailid;
       
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Updated')->view('SendMail/Jobseeker/updatejobseeker');
    }
}
