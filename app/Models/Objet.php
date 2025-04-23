<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo; // ✅ Bon namespace
use Illuminate\Database\Eloquent\Model;

class Objet extends Model
{
    protected $table = 'Objet'; // Spécifiez le nom exact de votre table
    
    protected $fillable = [
        'nom',
        'description', 
        'ville',
        'proprietaire_id',
        'categorie_id',
        'prix_journalier',
        'etat'
    ];

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }
}