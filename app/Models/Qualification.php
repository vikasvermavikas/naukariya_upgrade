<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    public function jobManagers() {
        return $this->hasMany(Jobmanager::class, 'job_qualification_id');
    }
}
