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
        'longitude'
    ];

    // 🔁 Relation avec les annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    // 🔁 Relation avec les images
    public function images()
    {
        return $this->hasMany(Image::class);
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
}
