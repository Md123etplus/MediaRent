<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservation'; 

    protected $fillable = [
        'client_id',
        'annonce_id',
        'date_debut',
        'date_fin',
        'statut'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    protected $appends = ['revenue', 'duration_days'];

    /**
     * Relation avec le client (utilisateur)
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation avec l'annonce
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class)->withDefault();
    }

    /**
     * Accessor pour le revenu de la réservation
     */
    public function getRevenueAttribute(): float
    {
        if (!$this->annonce || !$this->annonce->objet) {
            return 0;
        }

        return $this->duration_days * $this->annonce->objet->prix_journalier;
    }

    /**
     * Accessor pour la durée en jours
     */
    public function getDurationDaysAttribute(): int
    {
        if (!$this->date_debut || !$this->date_fin) {
            return 0;
        }

        return Carbon::parse($this->date_debut)->diffInDays($this->date_fin);
    }

    /**
     * Scope pour les réservations confirmées
     */
    public function scopeConfirmed($query)
    {
        return $query->where('statut', 'confirmée');
    }

    /**
     * Scope pour les réservations dans une période donnée
     */
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }
    // public function annonce()
    // {
    //     return $this->belongsTo(Annonce::class, 'annonce_id');
    // }

    public function evaluation()
    {
        // Spécifiez explicitement la clé étrangère
        return $this->hasOne(Evaluation::class, 'reservation_id');
    }

    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'reservation_id');
    }
    //     public function client()
    // {
    //     return $this->belongsTo(User::class, 'client_id');
    // }

    public function evaluations()
    {
        // La FK evaluation.objet_id référence reservation.id d'après votre schéma.
        // C'est une convention de nommage inhabituelle. J'utilise le nom de la FK comme Laravel le ferait par défaut,
        // mais la contrainte dans votre DDL pointe 'objet_id' de 'evaluation' vers 'reservation.id'.
        // Si la FK dans `evaluation` s'appelle bien `reservation_id` (plus standard), c'est correct.
        // Si elle s'appelle `objet_id` MAIS pointe vers `reservation.id`, vous devez spécifier la FK:
        // return $this->hasMany(Evaluation::class, 'objet_id');
        return $this->hasMany(Evaluation::class, 'reservation_id');
    }
    
    public function evaluationsRecues() // Les évaluations pour cette réservation
    {
        return $this->hasMany(Evaluation::class, 'objet_id'); // FK `objet_id` dans `evaluation` table
    }
}
