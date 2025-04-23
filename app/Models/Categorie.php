<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    protected $table = 'categorie'; // Ou le nom exact de votre table
    
    protected $fillable = [
        'nom',
        // Ajoutez d'autres champs si nécessaire
    ];

    public function objets(): HasMany
    {
        return $this->hasMany(Objet::class, 'categorie_id');
    }
}