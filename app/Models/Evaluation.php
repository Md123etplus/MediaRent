<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Objet;

class Evaluation extends Model
{
    protected $table = 'evaluation';

    protected $fillable = [
        'objet_id', 'evaluateur_id', 'evalue_id', 'note', 'commentaire', 'date'
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    public function evaluateur()
    {
        return $this->belongsTo(Utilisateur::class, 'evaluateur_id');
    }

    public function evalue()
    {
        return $this->belongsTo(Utilisateur::class, 'evalue_id');
    }
}
