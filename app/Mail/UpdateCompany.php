<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCompany extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mobile;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Update Details')->view('SendMail/updatecompany');
    }
}
