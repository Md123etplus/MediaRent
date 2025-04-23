<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'Reservation'; // correspond au nom de ta table

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
