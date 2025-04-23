<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'Categorie'; // Assure-toi que c'est bien le nom exact de ta table

    protected $fillable = [
        'nom' // adapte si tu as d'autres colonnes
    ];

    // Une catégorie peut avoir plusieurs objets
    public function objets()
    {
        return $this->hasMany(Objet::class, 'categorie_id');
    }
}
