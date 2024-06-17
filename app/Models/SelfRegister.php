<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfRegister extends Model
{
    protected $table = 'self_registers';
    public $timestamps = false;

    function getStateName(){
        return $this->hasOne(States::class, 'id', 'state');
    }

    function getDistrictName(){
        return $this->hasOne(District::class, 'id', 'district');
    }
}
