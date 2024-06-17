<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{

    public  function advertisement(){
        return $this->belongsTo(Advertisement::class,'adv_id');
    }

    public  function recruiter(){
        return $this->belongsTo(Recruiter::class,'recruiter_id');
    }

    public  function jobtype(){
        return $this->belongsTo(Jobtype::class,'job_type_id');
    }

    public  function designation(){
        return $this->belongsTo(Designation::class,'designation_id');
    }
   
    public  function jobnotice(){
        return $this->belongsTo(Jobnotice::class,'adv_id');
    }

    public  function joblocation(){
        return $this->belongsTo(Joblocation::class,'location_id');
    }

}
