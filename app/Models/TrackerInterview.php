<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackerInterview extends Model
{
    use HasFactory;

    protected $fillable = ['tracker_id', 'job_id', 'interview_date', 'interview_details'];
}
