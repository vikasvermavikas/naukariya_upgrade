<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateEmployer extends Mailable
{
    use Queueable, SerializesModels;
    
    public $name;
    public $mobile;
    public $company_name;
   

    public function __construct($name,$mobile,$company_name)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->company_name = $company_name;
    }

    public function build()
    {
        return $this->subject('Update Account')->view('SendMail/updateemployer');
    }
}
