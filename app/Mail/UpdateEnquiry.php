<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateEnquiry extends Mailable
{
    use Queueable, SerializesModels;
    
    public $name;
    public $mobile;
    public $enq_status;
    public $enq_message;
    public $enq_usertype;
    //public $message;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$enq_status,$enq_message,$enq_usertype)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->enq_status = $enq_status;
        $this->enq_message = $enq_message;
        $this->enq_usertype = $enq_usertype;
        //$this->message = $message;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Enquiry Status')->view('SendMail/updateenquiry');
    }
}
