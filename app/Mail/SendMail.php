<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $description;
    public $subject;
    //public $from;
    
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$description,$subject)
    {
        $this->name = $name;
        $this->description = $description;
        $this->subject = $subject;
        //$this->from = $from;
        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->view('SendMail/sendmail');
    }
}
