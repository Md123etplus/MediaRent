<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Annonce;
use App\Models\User;
use App\Models\Image;
use App\Models\Categorie;
use App\Services\GeocoderService;
use Illuminate\Support\Facades\DB;

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
        'latitude',
        'longitude',
        'statut'  // Ajout si nécessaire
    ];

    protected $attributes = [
        'etat' => 'bon',      // valeur par défaut
        'ville' => 'N/A',     // valeur par défaut
        'description' => 'Aucune description disponible' // valeur par défaut
    ];

    protected $casts = [
        'prix_journalier' => 'double',
    ];

    // 🔁 Relation avec les annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'objet_id'); // 'objet_id' est la FK dans la table 'annonce'
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'objet_id'); // 'objet_id' est la FK dans la table 'image'
    }

    // 🔁 Relation avec le propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // 🔁 Relation avec la catégorie
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    // 🔁 Relation avec les évaluations
    public function evaluations()
    {
        return $this->hasMany(\App\Models\Evaluation::class, 'objet_id');
    }

    // ✅ Vérifie si les coordonnées sont valides
    public function hasCoordinates(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    // 🚀 Ajoute automatiquement latitude/longitude avant sauvegarde
    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('ville') && !empty($model->ville)) {
                $coords = GeocoderService::getCoordinates($model->ville);
                if (!empty($coords['lat']) && !empty($coords['lng'])) {
                    $model->latitude = $coords['lat'];
                    $model->longitude = $coords['lng'];
                }
            }
        });
    }

    // --- Calculs pour la fiche Objet ---

    // Première image
    public function getPremiereImageUrlAttribute()
    {
        return $this->images()->first()->url ?? 'https://via.placeholder.com/300x200.png?text=Pas+d\'image'; // URL placeholder
    }



    // Date de disponibilité (plus proche date de début d'une annonce active)
    public function getDateDisponibiliteAttribute()
    {
        $premiereAnnonceActive = $this->annonces()
            ->where('statut', 'active') // ou le statut que vous utilisez pour les annonces disponibles
            ->where('date_debut', '>=', now()->toDateString())
            ->orderBy('date_debut', 'asc')
            ->first();

        return $premiereAnnonceActive ? $premiereAnnonceActive->date_debut : null;
    }

    // Note moyenne de l'objet
    public function getNoteMoyenneAttribute()
    {
        // Accède aux évaluations via la relation reservationAssociee dans le modèle Evaluation,
        // puis remonte à l'annonce pour filtrer par l'objet_id de l'annonce.
        $avg = Evaluation::whereHas('reservationAssociee.annonce', function ($query) {
            $query->where('objet_id', $this->id); // Ici, objet_id est la FK de annonce vers objet
        })
            ->avg('note');
        return $avg !== null ? round($avg, 1) : null; // Gère le cas où il n'y a pas d'avis
    }

    public function getNombreAvisAttribute()
    {
        return Evaluation::whereHas('reservationAssociee.annonce', function ($query) {
            $query->where('objet_id', $this->id); // Ici, objet_id est la FK de annonce vers objet
        })
            ->count();
    }

    // Pour obtenir toutes les URLs des images
    public function getPhotosAttribute()
    {
        return $this->images->pluck('url')->toArray();
    }


    // Option de livraison (placeholder)
    public function getOptionLivraisonProposeeAttribute(): bool
    {
        // Si vous ajoutez une colonne 'livraison_possible' à la table 'objet':
        // return $this->livraison_possible;

        // Pour l'instant, une valeur par défaut
        return false; // ou true, selon votre implémentation future
    }
    public function getOptionLivraisonTexteAttribute(): string
    {
        return $this->option_livraison_proposee ? 'Oui' : 'Non';
    }


    // Dates de disponibilité (liste des périodes des annonces actives et futures)
    public function getPeriodesDisponibiliteAttribute()
    {
        return $this->annonces()
            ->where('statut', 'active') // Assurez-vous que 'active' est le bon statut
            ->where('date_fin', '>=', now()->toDateString()) // Annonces pas encore terminées
            ->orderBy('date_debut', 'asc')
            ->get(['date_debut', 'date_fin'])
            ->map(function ($annonce) {
                return [
                    'debut' => \Carbon\Carbon::parse($annonce->date_debut)->isoFormat('LL'),
                    'fin' => \Carbon\Carbon::parse($annonce->date_fin)->isoFormat('LL'),
                ];
            });
    }

    // Note moyenne de l'objet (donnée par les clients)
    public function getNoteMoyenneObjetAttribute()
    {
        return DB::table('evaluation')
            ->join('reservation', 'evaluation.reservation_id', '=', 'reservation.id')
            ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
            ->where('annonce.objet_id', $this->id)
            ->avg('evaluation.note') ?? 0;
    }

    // Nombre d'avis sur l'objet (donnés par les clients)
    public function getNombreAvisObjetAttribute()
    {
        return DB::table('evaluation')
            ->join('reservation', 'evaluation.reservation_id', '=', 'reservation.id')
            ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
            ->where('annonce.objet_id', $this->id)
            ->count();
    }

    // Nombre de fois où l'objet a été loué
    public function getNombreLocationsAttribute()
    {
        return DB::table('reservation')
            ->join('annonce', 'reservation.annonce_id', '=', 'annonce.id')
            ->where('annonce.objet_id', $this->id)
            ->count();
    }
}
