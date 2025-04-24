<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'Utilisateur';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'role',
        'CIN',
        'img_profil',
        'img_cin_front',
        'img_cin_back',
        'email_verified_at',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mot_de_passe' => 'hashed',
        ];
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

    /**
     * Relations
     */
    
    // Réservations où l'utilisateur est client
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    // Évaluations faites par l'utilisateur
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluateur_id');
    }

    // Notifications reçues par l'utilisateur
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    // Annonces où l'utilisateur est propriétaire
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'proprietaire_id');
    }

    // Objets possédés par l'utilisateur
    public function objets()
    {
        return $this->hasMany(Objet::class, 'proprietaire_id');
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
}