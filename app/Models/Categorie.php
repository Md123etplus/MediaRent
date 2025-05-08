<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'categorie';

    /**
     * Les champs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom' // Seul champ modifiable autre que les timestamps
    ];

    /**
     * Les champs qui doivent être cachés pour les tableaux.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Relation avec les objets de cette catégorie.
     */
    public function objets(): HasMany
    {
        return $this->hasMany(Objet::class, 'categorie_id');
    }

    /**
     * Accesseur pour le nom en majuscules.
     */
    public function getNomAttribute($value): string
    {
        return ucfirst($value);
    }

    /**
     * Mutateur pour nettoyer le nom avant sauvegarde.
     */
    public function setNomAttribute($value): void
    {
        $this->attributes['nom'] = trim($value);
    }

    /**
     * Scope pour les catégories actives (si vous ajoutez un champ 'actif' plus tard)
     */
    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }
    
    
}