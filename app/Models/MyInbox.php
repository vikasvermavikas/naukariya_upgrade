<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyInbox extends Model
{
    protected $fillable = [
        'sender_email', 'sender_usertype', 'receiver_email', 'receiver_usertype', 'subject', 'attachment', 'message'
    ];
}
