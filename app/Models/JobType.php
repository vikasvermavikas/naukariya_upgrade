<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    public function jobManagers() {
        return $this->hasMany(Jobmanager::class);
    }
}
