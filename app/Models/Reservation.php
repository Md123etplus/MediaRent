<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservation'; // correspond au nom de ta table
    protected $fillable = [
        'client_id',
        'annonce_id',
        'date_debut',
        'date_fin',
        'statut',
    ];
    protected $dates = [
        'date_debut',
        'date_fin',
    ];
    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
//     public function client()
// {
//     return $this->belongsTo(User::class, 'client_id');
// }
}
