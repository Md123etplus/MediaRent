<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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
        'nom', 'prenom', 'email', 'mot_de_passe', 'role', 'CIN',
        'img_profil', 'img_cin_front', 'img_cin_back'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mot_de_passe', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
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
}
