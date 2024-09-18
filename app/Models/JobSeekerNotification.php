<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerNotification extends Model
{
    use HasFactory;

    protected $fillable = ['jobseeker_id', 'job_id', 'job_post_date', 'seen']; 
}
