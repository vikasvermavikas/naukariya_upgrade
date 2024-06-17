<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JsProfessionalDetail extends Model
{
    public function jobSeekers() {
        return $this->belongsTo(Jobseeker::class);
    }
}
