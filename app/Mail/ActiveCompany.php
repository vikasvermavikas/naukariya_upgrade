<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveCompany extends Mailable
{
    use Queueable, SerializesModels;
    
    public $company_name;
    public $mobile;
   
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company_name,$mobile)
    {
        $this->company_name = $company_name;
        $this->mobile = $mobile;
        
       
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account activated')->view('SendMail/activecompany');
    }
}
