<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'nom', 'description', 'ville', 'proprietaire_id', 'categorie_id', 'prix_journalier', 'etat',
    ];

    // 🔁 Relation avec les annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'objet_id');
    }

//     public function images()
// {
//     return $this->hasMany(Image::class);
// }
public function images()
{
    return $this->hasMany(Image::class, 'objet_id', 'id');
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
// Dans app/Models/Objet.php
public function evaluations()
{
    return $this->hasMany(\App\Models\Evaluation::class, 'objet_id');
}

public function getMainImageUrlAttribute()
    {
        $firstImage = $this->images()->first();
        return $firstImage ? asset('storage/' . $firstImage->url) : asset('path/to/default-image.jpg'); // Assurez-vous d'avoir un lien symbolique storage
    }
    
    // Accesseur: Note moyenne de l'objet
    // Ceci est plus complexe car les évaluations sont liées aux réservations.
    public function getAverageRatingAttribute()
    {
        // Récupérer toutes les annonces de cet objet
        $annonceIds = $this->annonces()->pluck('id');
        // Récupérer toutes les réservations liées à ces annonces
        $reservationIds = Reservation::whereIn('annonce_id', $annonceIds)->pluck('id');
        // Calculer la moyenne des notes des évaluations liées à ces réservations
        // Note: la colonne `evaluation.objet_id` est une FK vers `reservation.id` d'après votre schéma.
        // Ce nom de colonne est un peu confusant. Il serait mieux de la nommer `reservation_id`.
        $avgRating = Evaluation::whereIn('objet_id', $reservationIds)->avg('note');
        return $avgRating ? round($avgRating, 1) : null;
    }
    
    // Accesseur: Disponibilité (simplifié : a-t-il des annonces actives ?)
    public function getIsAvailableAttribute()
    {
        // Une logique plus complexe pourrait vérifier les dates des annonces et les réservations existantes.
        // Ici, on vérifie juste s'il y a au moins une annonce "active" (vous devrez définir ce qu'est un statut actif).
        return $this->annonces()
                    ->where('statut', 'active') // Adaptez 'active' à votre logique de statut
                    ->where('date_fin', '>=', now()->toDateString())
                    ->exists();
    }



}

