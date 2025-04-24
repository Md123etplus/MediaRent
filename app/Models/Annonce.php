<?php

namespace App\Models;

use App\Models\User;
use App\Models\Objet;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'annonce';

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

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
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
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'annonce_id');
    }

    // !!!N'existait pas
    public function partenaire()
{
    return $this->belongsTo(User::class, 'partenaire_id');
}
}