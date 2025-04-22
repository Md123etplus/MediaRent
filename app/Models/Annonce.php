<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $fillable = [
        'date_publication',
        'statut',
        'premium',
        'objet_id',
        'proprietaire_id',
        'date_debut',
        'date_fin',
        'adress',
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

public function proprietaire()
{
    return $this->belongsTo(User::class, 'proprietaire_id');
}


}
