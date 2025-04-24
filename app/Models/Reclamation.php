<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Reservation; // Ensure the Reservation class exists in this namespace

class Reclamation extends Model
{
    protected $table = 'reclamation';

    protected $fillable = [
        'contenu', 'utilisateur_id', 'reservation_id', 'date_creation', 'statut'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
