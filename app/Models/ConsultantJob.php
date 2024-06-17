<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantJob extends Model
{
    protected $fillable = [
        'consultant_id', 'jobmanager_id', 'status'
    ];

    public function jobmanager()
    {
        return $this->belongsTo(Jobmanager::class);
    }
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function job_profile()
    {
        return $this->belongsTo(JobSector::class, 'job_type');
    }
}