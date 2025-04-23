<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Objet;
use App\Models\Utilisateur;
use App\Models\Reservation;
use App\Models\Notification;

class Annonce extends Model
{
    protected $table = 'Annonce';

    protected $fillable = [
        'date_publication',
        'statut',
        'premium',
        'objet_id',
        'proprietaire_id',
        'date_debut',
        'date_fin',
        'adress',
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'annonce_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'annonce_id');
    }
}
