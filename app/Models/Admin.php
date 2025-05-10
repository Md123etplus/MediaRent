<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_pass',
    ];

    protected $hidden = [
        'mot_pass',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->mot_pass; // Spécifiez le champ personnalisé
    }
}
