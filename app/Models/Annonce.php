<?php

namespace App\Models;

use App\Models\User;
use App\Models\Objet; // Ensure the Objet class exists in this namespace. If not, update the namespace accordingly.
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

    // protected $casts = [
    //     'date_publication' => 'datetime',
    //     'date_debut' => 'datetime',
    //     'date_fin' => 'datetime',
    //     'premium' => 'boolean'
    // ];

    // Solution 1: Déclarer les dates pour conversion automatique en Carbon
    protected $dates = [
        'date_debut',
        'date_fin',
        'date_publication',
        'created_at',
        'updated_at'
    ];

    // OU Solution 2 (Laravel 8+): Utiliser $casts pour un meilleur contrôle
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'date_publication' => 'datetime',
        'premium' => 'boolean',
    ];

    // Solution 1: Déclarer les dates pour conversion automatique en Carbon
    // protected $dates = [
    //     'date_debut',
    //     'date_fin',
    //     'date_publication',
    //     'created_at',
    //     'updated_at'
    // ];

    // OU Solution 2 (Laravel 8+): Utiliser $casts pour un meilleur contrôle
    // protected $casts = [
    //     'date_debut' => 'datetime',
    //     'date_fin' => 'datetime',
    //     'date_publication' => 'datetime',
    //     'premium' => 'boolean',
    // ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // public function reservations(): HasMany
    // {
    //     return $this->hasMany(Reservation::class);
    // }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'annonce_id');
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
    // public function proprietaire()
    // {
    //     return $this->belongsTo(User::class, 'proprietaire_id');
    // }
}