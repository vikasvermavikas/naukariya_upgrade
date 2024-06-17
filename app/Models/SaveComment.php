<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveComment extends Model
{
    public function jobSeekers() {
        return $this->belongsTo(Jobseeker::class);
    }
}
