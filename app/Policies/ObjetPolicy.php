<?php
namespace App\Policies;

use App\Models\Objet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true; // Tout le monde peut lister les objets (typiquement)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Objet $objet)
    {
        // Un client peut voir la fiche d'un objet
        if ($user->role === 'client') {
            return true;
        }

        // Un partenaire peut voir n'importe quel objet (y compris les siens)
        if ($user->role === 'partenaire') {
            return true;
        }
        
        // Un admin peut voir n'importe quel objet
        if ($user->isAdmin()) {
             return true;
        }

        return false;
    }
}