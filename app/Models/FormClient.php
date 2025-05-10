<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormClient extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'CIN',
        'annonce_id',
        'date_debut',
        'date_fin',
        'prix_total'
    ];

    public $timestamps = true;

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}