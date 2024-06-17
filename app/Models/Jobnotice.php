<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobnotice extends Model
{
    public function jobs(){
       return $this->hasMany(Jobs::class,'adv_id'); 
   }
}
