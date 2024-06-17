<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantCandidate extends Model
{
    protected $fillable = ['name', 'email', 'mobile', 'gender', 'resume_url', 'jobmanager_id', 'consultant_id','company_id'];

    public function jobmanager()
    {
        return $this->belongsTo(Jobmanager::class);
    }

    public function consultant() {
        return $this->belongsTo(Consultant::class);
    }
}