<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;



class AllUser extends Authenticatable
{
    use HasFactory;
    protected $table = 'all_users';
    public function jobmanager()
    {
        return $this->hasMany(Jobmanager::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function functional_role()
    {
        return $this->belongsTo(FunctionalRole::class, 'functionalrole_id');
    }
}
