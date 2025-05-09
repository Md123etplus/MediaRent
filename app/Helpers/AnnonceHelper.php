<?php

namespace App\Helpers;

use App\Models\Annonce;

class AnnonceHelper
{
    public static function getAnnonceStatus($annonce)
    {
        if ($annonce->date_fin < now()) {
            return 'Expired';
        }

        return match($annonce->statut) {
            'active' => 'Active',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
            default => ucfirst($annonce->statut)
        };
    }
}
