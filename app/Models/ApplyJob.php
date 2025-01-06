<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyJob extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['application_id', 'jsuser_id', 'job_id', 'username', 'status'];
}
