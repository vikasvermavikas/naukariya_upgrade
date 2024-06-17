<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JsEducationalDetail extends Model
{
    protected $fillable = ['js_userid', 'degree_name', 'course_type', 'percentage_grade','passing_year', 'institute_name', 'institute_location'];
    
    
    public function jobSeekers() {
        return $this->belongsTo(Jobseeker::class);
    }
}
