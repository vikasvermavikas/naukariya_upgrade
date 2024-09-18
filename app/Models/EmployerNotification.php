<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerNotification extends Model
{
	/**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;
    
	protected $fillable = ['jobseeker_id', 'employer_id', 'read_notification', 'type', 'job_id', 'status'];
}
