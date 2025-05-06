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
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class, 'annonce_id')->with(['objet.images']);
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
        return $this->hasOne(Evaluation::class, 'objet_id', 'annonce_id');
    }


    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'reservation_id');
    }
//     public function client()
// {
//     return $this->belongsTo(User::class, 'client_id');
// }
}
