<?php

namespace App\Models;

use App\Models\Jobmanager;
use App\Models\Industry;
use App\Models\JobSector;


use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{

    protected $fillable = ['status', 'agreement_verified'];

    protected $hidden = ['password'];

    public function consultantCandidate()
    {
        return $this->hasMany(ConsultantCandidate::class);
    }
    public function jobmanager()
    {
        return $this->belongsTo(Jobmanager::class);
    }
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
    public function industries()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
    public function job_profile()
    {
        return $this->belongsTo(JobSector::class, 'job_type');
    }
    public function consultant_job()
    {
        return $this->hasMany(ConsultantJob::class, 'consultant_id');
    }
}                     