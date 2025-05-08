<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    // Spécifiez le nom exact de la table
    use HasFactory;
    protected $table = 'evaluation';

    // Désactivez les timestamps si vous n'avez pas created_at et updated_at
    public $timestamps = false;

    // Définissez les champs remplissables
    protected $fillable = [
        'objet_id',
        'evaluateur_id',
        'evalue_id',
        'reservation_id',
        'note',
        'commentaire',
        'date',
        'type', // 'objet' ou 'utilisateur'
    ];

    protected $casts = [
        'note' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relation avec l'objet évalué
     */
    public function objet(): BelongsTo
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    /**
     * Relation avec l'utilisateur qui a fait l'évaluation
     */
    public function evaluateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    /**
     * Relation avec l'utilisateur évalué (si c'est une évaluation d'utilisateur)
     */
    public function evalue(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evalue_id');
    }

    /**
     * Relation avec la réservation associée
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    /**
     * Scope pour les évaluations d'objets
     */
    public function scopeObjets($query)
    {
        return $query->where('type', 'objet');
    }

    /**
     * Scope pour les évaluations d'utilisateurs
     */
    public function scopeUtilisateurs($query)
    {
        return $query->where('type', 'utilisateur');
    }

    /**
     * Accessor pour le texte de la note
     */
    public function getNoteTextAttribute(): string
    {
        return $this->note.'/5';
    }
    
}
