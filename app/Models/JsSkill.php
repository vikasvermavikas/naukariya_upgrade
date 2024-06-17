<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JsSkill extends Model
{
    protected $fillable = ['js_userid', 'skill', 'expert_level'];
    
    public function jobSeekers() {
        return $this->belongsTo(Jobseeker::class);
    }
}
