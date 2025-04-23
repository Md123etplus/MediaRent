<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie; // ✅ Ajoute cette ligne

class Objet extends Model
{
    protected $table = 'Objet';

    protected $fillable = [
        'nom', 'description', 'ville', 'proprietaire_id',
        'categorie_id', 'prix_journalier', 'etat'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
