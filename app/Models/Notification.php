<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function jobseekers() {
        return $this->belongsTo(Jobseeker::class);
    }
}
