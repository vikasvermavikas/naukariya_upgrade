<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateConsultant extends Mailable
{
    use Queueable, SerializesModels;
    
    public $name;
    public $mobile;
    public $company_name;
    public $emailid;
    public $password;
   
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$company_name,$password,$emailid)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->company_name = $company_name;
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
        return $this->subject('Update Account')->view('SendMail/Consultant/updateconsultant');
    }
}
