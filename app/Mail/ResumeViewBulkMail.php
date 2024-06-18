<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ResumeViewBulkMailJob;

class ResumeViewBulkMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name; 
    public $description;
    public $subject;
   
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
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $input = array(
            'fname'     => $this->name,
            'message' => $this->description,
            'subject' => $this->subject,
        );
        return $this->subject($this->subject)->view('SendMail/ResumeViewBulkMail')
        ->with([
            'data' => $input,
          ]);;
        //return $this->markdown('SendMail.ResumeViewBulkMail');
    }
}
