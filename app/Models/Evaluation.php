<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'objet_id',
        'evaluateur_id',
        'evalue_id',
        'note_objet',
        'note_proprietaire',
        'commentaire_objet',
        'commentaire_proprietaire',
        'date',
        'reservation_id',
    ];

    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    public function evalue()
    {
        return $this->belongsTo(User::class, 'evalue_id');
    }

    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}