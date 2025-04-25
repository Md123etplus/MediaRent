<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Annonce;
use App\Models\User;
use App\Models\Image;
use App\Models\Categorie;

class Objet extends Model
{
    use HasFactory;

    protected $table = 'objet';

    protected $fillable = [
        'nom', 
        'description', 
        'ville', 
        'prix_journalier', 
        'etat',
        'categorie_id',
        'proprietaire_id',
        // Ajoute d'autres champs si nécessaire
    ];

    // 🔁 Relation avec les annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    

    // 🔁 Relation avec le propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function categorie(): BelongsTo
{
    return $this->belongsTo(Categorie::class, 'categorie_id');
}
     // Modifiez la relation
public function images()
{
    return $this->hasMany(Image::class, 'objet_id', 'id');
}


}