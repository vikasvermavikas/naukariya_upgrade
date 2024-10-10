<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackerSelection extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'tracker_id', 'job_id', 'employer_id'];
}
