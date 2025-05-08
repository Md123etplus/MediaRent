<?php

namespace App\Models;

use App\Models\User;
use App\Models\Objet; // Ensure the Objet class exists in this namespace. If not, update the namespace accordingly.
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAnnonceNotification; // Ensure this is the correct namespace for the Mailable class

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
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function evaluations()
    {
        return $this->hasManyThrough(
            Evaluation::class,
            Objet::class,
            'id', // Clé étrangère sur la table objets
            'objet_id', // Clé étrangère sur la table evaluations
            'objet_id', // Clé locale sur la table annonces
            'id' // Clé locale sur la table objets
        );
    }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when(isset($filters['ville']), function($q) use ($filters) {
                $q->where('adress', 'like', "%{$filters['ville']}%");
            })
            ->when(isset($filters['categorie']), function($q) use ($filters) {
                $q->whereHas('objet.categorie', function($query) use ($filters) {
                    $query->where('nom', $filters['categorie']);
                });
            })
            ->when(isset($filters['prix_min']), function($q) use ($filters) {
                $q->whereHas('objet', function($query) use ($filters) {
                    $query->where('prix_journalier', '>=', $filters['prix_min']);
                });
            })
            ->when(isset($filters['prix_max']), function($q) use ($filters) {
                $q->whereHas('objet', function($query) use ($filters) {
                    $query->where('prix_journalier', '<=', $filters['prix_max']);
                });
            })
            ->when(isset($filters['date_debut']) && isset($filters['date_fin']), function($q) use ($filters) {
                $q->where('date_debut', '<=', $filters['date_fin'])
                  ->where('date_fin', '>=', $filters['date_debut']);
            });
    }

    public function scopeWithRating($query, $minRating)
    {
        return $query->whereHas('objet.evaluations', function($q) use ($minRating) {
            $q->selectRaw('objet_id, avg(note) as average_rating')
              ->groupBy('objet_id')
              ->having('average_rating', '>=', $minRating);
        });


    }
    protected static function booted()
{
    static::created(function ($annonce) {
        if ($annonce->statut === 'active') { // Only send emails when status is active
            $subscribers = Subscriber::where('is_confirmed', 1)->get();

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewAnnonceNotification($annonce)); // Send email directly
            }
        }
    });
}



}
