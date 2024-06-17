<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplyJob extends Model
{
    protected $fillable = [
        'full_name', 'email_id', 'phone_num', 'location', 'experience', 'current_ctc', 'expected_ctc', 'career_id', 'resume'
    ];

    public function careers()
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    public function getFullNameAttribute($value) {
        return ucwords($value);
    }
}
