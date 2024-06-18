<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mobile;
    public $remarks;
    public $email;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$remarks,$email)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->remarks = $remarks;
        $this->email = $email;
        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Query Raised')->view('SendMail/contact-us');
    }
}
