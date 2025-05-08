<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        // 'password',
        'mot_de_passe',
        'role',
        'CIN',
        'img_profil',
        'img_cin_front',
        'img_cin_back',
        'is_suspended'
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

   

    /**
     * Override getAuthPassword pour utiliser mot_de_passe
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
    public function getFullNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
    
        public function annonces()
        {
            return $this->hasMany(Annonce::class, 'proprietaire_id');
        }
    
        public function objets()
        {
            return $this->hasMany(Objet::class, 'proprietaire_id');
        }
    
        public function images()
        {
            return $this->hasMany(Image::class);
        }
    
        // Nouvelles méthodes pour le UserController
        
        public function evaluations()
        {
            return $this->hasMany(Evaluation::class, 'evaluateur_id');
        }
    
        public function scopeWithReservationsCount($query)
        {
            return $query->withCount(['reservations as total_reservations']);
        }
    
        public function getRegistrationDateAttribute()
        {
            return $this->created_at->format('d/m/Y');
        }
    
        public function getRoleLabelAttribute()
        {
            return $this->role === 'propriétaire' ? 'Propriétaire' : 'Client';
        }
    
        public function getRoleColorAttribute()
        {
            return $this->role === 'propriétaire' ? 'blue' : 'green';
        }
    
        public function getProfileImageUrlAttribute()
        {
            return $this->img_profil ? asset('storage/'.$this->img_profil) : 'https://via.placeholder.com/150';
        }
    
        public function toggleSuspension()
        {
            $this->update(['is_suspended' => !$this->is_suspended]);
            return $this->is_suspended;
        }
    
        // Évaluations reçues (quand l'utilisateur est évalué)
        public function evaluationsRecues()
        {
            return $this->hasMany(Evaluation::class, 'evalue_id');
        }
    
        // Notifications non lues
        public function unreadNotifications()
        {
            return $this->notifications()->where('lue', false);
        }
    
        /**
         * Méthodes utilitaires
         */
        
        // Vérifie si l'utilisateur est un client
        public function isClient()
        {
            return $this->role === 'client';
        }
    
        // Vérifie si l'utilisateur est un partenaire
        public function isPartenaire()
        {
            return $this->role === 'partenaire';
        }
    
        // Vérifie si l'utilisateur est un admin
        public function isAdmin()
        {
            return $this->role === 'admin';
        }
    
        // Note moyenne reçue (pour les partenaires)
        public function noteMoyenne()
        {
            return $this->evaluationsRecues()->avg('note_proprietaire');
        }
        public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    /**
     * Relations
     */
    
    // Réservations où l'utilisateur est client
    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class, 'client_id');
    // }

    // Évaluations faites par l'utilisateur
    // public function evaluations()
    // {
    //     return $this->hasMany(Evaluation::class, 'evaluateur_id');
    // }

    // Notifications reçues par l'utilisateur
    

    // Annonces où l'utilisateur est propriétaire
    // public function annonces()
    // {
    //     return $this->hasMany(Annonce::class, 'proprietaire_id');
    // }

    // Objets possédés par l'utilisateur
    // public function objets()
    // {
    //     return $this->hasMany(Objet::class, 'proprietaire_id');
    // }

 /**
     * The attributes that should be hidden for serialization.
     */
    // protected $hidden = [
    //     'mot_de_passe',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     */
    // protected function casts(): array
    // {
    //     return [
    //         'is_suspended' => 'boolean',
    //         'email_verified_at' => 'datetime',
    //         'mot_de_passe' => 'hashed',
    //     ];
    // }
    

    // Relation: Un utilisateur (client) a plusieurs réservations
    public function reservationsAsClient()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    // Relation: Un utilisateur (partenaire) possède plusieurs objets
    
    // Relation: Un utilisateur (partenaire) a publié plusieurs annonces
    public function annoncesAsProprietaire()
    {
        return $this->hasMany(Annonce::class, 'proprietaire_id');
    }

    // Relation: Evaluations reçues par cet utilisateur
    public function evaluationsReceived()
    {
        return $this->hasMany(Evaluation::class, 'evalue_id');
    }

    // Relation: Evaluations données par cet utilisateur
    public function evaluationsGiven()
    {
        return $this->hasMany(Evaluation::class, 'evaluateur_id');
    }

    // Accesseur: Surnom (on utilise prenom comme surnom ici)
    public function getSurnomAttribute()
    {
        return $this->prenom;
    }

    // Accesseur: Note moyenne de l'utilisateur (client ou partenaire)
    public function getAverageRatingAttribute()
    {
        // On arrondit à 1 décimale, ou null si pas de notes
        return $this->evaluationsReceived()->avg('note') ? round($this->evaluationsReceived()->avg('note'), 1) : null;
    }

    // Accesseur: Nombre de locations (pour un client)
    public function getNombreLocationsAttribute()
    {
        return $this->reservationsAsClient()->count();
    }

    // Accesseur: Nombre d'annonces (pour un partenaire)
    public function getNombreAnnoncesAttribute()
    {
        return $this->annoncesAsProprietaire()->count();
    }

    
}