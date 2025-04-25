<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    // Spécifiez le nom exact de la table
    protected $table = 'Evaluation';

    // Désactivez les timestamps si vous n'avez pas created_at et updated_at
    public $timestamps = false;

    // Définissez les champs remplissables
    protected $fillable = [
        'objet_id',
        'evaluateur_id',
        'evalue_id',
        'note',
        'commentaire',
        'date'
    ];

    // Relation avec l'objet évalué
    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    // Relation avec l'évaluateur (client)
    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    // Relation avec l'évalué (partenaire)
    public function evalue()
    {
        return $this->belongsTo(User::class, 'evalue_id');
    }
}