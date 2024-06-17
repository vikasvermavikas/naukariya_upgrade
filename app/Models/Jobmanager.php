<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobmanager extends Model
{
    protected $fillable = ['status'];

    public function jobsectors()
    {
        return $this->belongsTo(JobSector::class, 'job_sector_id');
    }

    public function companies()
    {
        return $this->belongsTo(Empcompaniesdetail::class, 'company_id');
    }


    public function consultantJob()
    {
        return $this->hasMany(ConsultantJob::class);
    }

    public function consultantCandidates()
    {
        return $this->hasMany(ConsultantCandidate::class);
    }

    public function allusers()
    {
        return $this->belongsTo(AllUser::class, 'userid');
    }
}
