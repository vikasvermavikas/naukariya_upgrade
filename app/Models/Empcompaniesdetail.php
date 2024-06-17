<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empcompaniesdetail extends Model
{
    public function scopeActive($query, $type) {
        return $query->whereActive($type);
    }

    public function scopeTop($query, $type) {
        return $query->whereMarkedTop($type);
    }

    public function jobManagers()
    {
        return $this->hasMany(Jobmanager::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class, 'company_id');
    }
}
