<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
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
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_suspended' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

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
}
