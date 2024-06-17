<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Jobseeker extends Authenticatable 
{
    use Notifiable;

        protected $guard = 'jobseeker';

        protected $fillable = [
             'id','fname','email', 'password','last_login',
        ];

        protected $hidden = [
             'remember_token',
        ];

        protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function skills() {
        return $this->hasMany(JsSkill::class, 'js_userid');
    }

    public function educations() {
        return $this->hasMany(JsEducationalDetail::class, 'js_userid');
    }

    public function resumes() {
        return $this->hasMany(JsResume::class, 'js_userid');
    }
    public function professionals() {
        return $this->hasMany(JsProfessionalDetail::class, 'js_userid');
    }

    public function comments() {
        return $this->hasMany(SaveComment::class, 'js_userid');
    }
}
