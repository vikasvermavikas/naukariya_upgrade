<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddIndustry extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mobile;
    public $job_title;
    public $industry_name;

   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mobile,$job_title,$industry_name)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->job_title = $job_title;
        $this->industry_name = $industry_name;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Industry Added')->view('SendMail/Industry/add');
    }
}