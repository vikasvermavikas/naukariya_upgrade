<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use SoftDeletes, Sluggable;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'post_name'
            ]
        ];
    }

    public function careerAppliedJobs()
    {
        return $this->hasMany(CareerApplyJob::class);
    }

    protected $fillable = [
        'post_name', 'post_short_desc', 'post_long_desc', 'skill_required', 'min_exp', 'max_exp', 'total_opening', 'current_ctc', 'interview_process'
    ];

    public function getPostNameAttribute($value) {
        return ucwords($value);
    }
}
