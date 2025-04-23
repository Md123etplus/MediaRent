<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservation';

    protected $fillable = [
        'client_id',
        'annonce_id',
        'date_debut',
        'date_fin',
        'statut',
    ];
    

    protected $dates = [
        'date_debut',
        'date_fin',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function user()
    {
        return $this->belongsTo(Utilisateur::class);
    }
    public function client()
{
    return $this->belongsTo(Utilisateur::class, 'client_id');
}

}