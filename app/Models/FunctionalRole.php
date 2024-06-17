<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionalRole extends Model
{

    public function jobManagers()
    {
        return $this->hasMany(Jobmanager::class, 'job_functional_role_id');
    }

    public function allusers()
    {
        return $this->hasMany(AllUser::class);
    }
}