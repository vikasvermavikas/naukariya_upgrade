<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailResumeData extends Model
{
    use HasFactory;

    protected $table = 'mail_resume_datas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */     
    protected $fillable = ['mailid', 'jobid', 'status','status_url', 'attachmentid', 'filename', 'candidate_name', 'candidate_email', 'candidate_phone', 'candidate_address', 'skills', 'candidate_spoken_languages', 'education_qualifications', 'positions'];

}
