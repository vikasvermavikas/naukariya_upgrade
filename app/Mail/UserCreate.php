<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreate extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $password;
    public $designation;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$designation,$password)
    {
        $this->name = $name;
        $this->designation = $designation;
        $this->password = $password;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Login Details')->view('SendMail/user-created');
    }
}
