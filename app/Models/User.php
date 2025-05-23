<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe', // Laravel s'attend à 'password' pour le hashage.
        'role',
        'CIN',
        'img_profil',
        'img_cin_front',
        'img_cin_back',
        'is_suspended'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
     * Accessor pour le "surnom"
     */
    public function getSurnomAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Relations
     */
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
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

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluateur_id');
    }

    // Nouvelles relations
    public function evaluationsRecues()
    {
        return $this->hasMany(Evaluation::class, 'evalue_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    // Méthodes utilitaires
    public function toggleSuspension()
    {
        $this->update(['is_suspended' => !$this->is_suspended]);
        return $this->is_suspended;
    }

    // --- Rôles ---
    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isPartenaire()
    {
        return $this->role === 'partenaire';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // --- Calculs pour la fiche Partenaire ---
    public function getNoteMoyennePartenaireAttribute()
    {
        return $this->evaluationsRecues()
                    ->whereHas('evaluateur', fn($q) => $q->where('role', 'client'))
                    ->avg('note');
    }

    public function getNombreAvisPartenaireAttribute()
    {
        return $this->evaluationsRecues()
                    ->whereHas('evaluateur', fn($q) => $q->where('role', 'client'))
                    ->count();
    }

    public function getNombreAnnoncesPublieesAttribute()
    {
        return $this->annonces()->count();
    }

    public function getNombreLocationsRealiseesPartenaireAttribute()
    {
        return Reservation::whereHas('annonce', fn($q) => $q->where('proprietaire_id', $this->id))->count();
    }

    public function getObjetsEnLigneAttribute()
    {
        return $this->objets()
                    ->whereHas('annonces', function ($query) {
                        $query->where('statut', 'active')
                              ->where('date_debut', '<=', now())
                              ->where('date_fin', '>=', now());
                    })
                    ->get();
    }

    // --- Calculs pour la fiche Client ---
    public function getNoteMoyenneClientAttribute()
    {
        return $this->evaluationsRecues()
                    ->whereHas('evaluateur', fn($q) => $q->where('role', 'partenaire'))
                    ->avg('note');
    }

    public function getNombreAvisClientAttribute()
    {
        return $this->evaluationsRecues()
                    ->whereHas('evaluateur', fn($q) => $q->where('role', 'partenaire'))
                    ->count();
    }

    public function getNombreLocationsEffectueesClientAttribute()
    {
        return $this->reservations()
                    ->count();
    }

    // --- Méthodes supplémentaires ---
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
    
    
}
