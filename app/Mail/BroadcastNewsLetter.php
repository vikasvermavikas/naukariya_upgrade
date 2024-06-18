<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastNewsLetter extends Mailable
{
    use Queueable, SerializesModels;
    public $mail;
    public $msg;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$msg)
    {
        $this->mail = $mail;
        $this->msg = $msg;
        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Naukriyan')->view('SendMail/newsletter_broadcast');
    }
}
