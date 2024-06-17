<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSector extends Model
{
    public function jobmanagers() {
        return $this->hasMany(Jobmanager::class)->orderBy('created_at', 'DESC');
    }
}
