<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonce';
    
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

    // Solution 1: Déclarer les dates pour conversion automatique en Carbon
    protected $dates = [
        'date_debut',
        'date_fin',
        'date_publication',
        'created_at',
        'updated_at'
    ];

    // OU Solution 2 (Laravel 8+): Utiliser $casts pour un meilleur contrôle
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'date_publication' => 'datetime',
        'premium' => 'boolean',
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }
}