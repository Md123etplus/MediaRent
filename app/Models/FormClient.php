<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormClient extends Model
{
    protected $table = 'reservation'; // On insère dans la table users

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
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public $timestamps = true;
}
