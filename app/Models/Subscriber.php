<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'confirmation_token',
        'is_confirmed',
        'last_notified_at',
    ];
    protected $casts = [
        'is_confirmed' => 'boolean',
        'last_notified_at' => 'datetime',
    ];
}
