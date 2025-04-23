<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    // Désactive le hashage automatique des mots de passe
    public function setPasswordAttribute($value)
    {
        $this->attributes['mot_de_passe'] = $value;
    }

    // Surcharge la vérification du mot de passe
    public function validatePassword($password)
    {
        return $this->mot_de_passe === $password;
    }
}