<?php

namespace App\Models;

use App\Models\Annonce;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'Utilisateur'; // Important, car le nom est personnalisé

    protected $fillable = [
        'nom', 'prenom', 'email', 'mot_de_passe', 'role', 'CIN',
        'img_profil', 'img_cin_front', 'img_cin_back',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'proprietaire_id');
    }

}
