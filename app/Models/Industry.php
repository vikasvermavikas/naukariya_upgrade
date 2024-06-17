<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    public function jobManagers()
    {
        return  $this->hasMany(Jobmanager::class, 'job_industry_id');
    }

    public function allusers()
    {
        return  $this->hasMany(AllUser::class);
    }
}