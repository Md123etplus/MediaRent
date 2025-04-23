<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'Annonce';

    protected $fillable = [
        'date_publication',
        'statut',
        'premium',
        'objet_id',
        'proprietaire_id',
        'date_debut',
        'date_fin',
        'adress' // Note: 'address' serait une orthographe plus standard
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'premium' => 'boolean'
    ];

    public function objet(): BelongsTo
    {
        return $this->belongsTo(Objet::class);
    }
    
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

    // Scopes utiles
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('statut', 'archivée');
    }

    public function scopePremium($query)
    {
        return $query->where('premium', true);
    }
}