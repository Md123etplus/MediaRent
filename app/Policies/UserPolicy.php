<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewClient(User $user, User $client)
    {
        // Un admin peut voir tous les profils
        if ($user->role === 'admin') return true;
        
        // Un partenaire peut voir le profil d'un client
        if ($user->role === 'partenaire') return true;
        
        // Un client ne peut voir que son propre profil
        if ($user->role === 'client') {
            return $user->id === $client->id;
        }

        return false;
    }

    public function viewPartenaire(User $user, User $partenaire)
    {
        // Tout le monde peut voir le profil d'un partenaire
        return true;
    }
    
    /**
     * Determine whether the user can view any models.
     * Les admins peuvent tout voir.
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin(); // Ou une permission spécifique
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $currentUser, User $targetUser)
    {
        // Un utilisateur peut voir son propre profil
        if ($currentUser->id === $targetUser->id) {
            return true;
        }

        // Un client peut voir la fiche d'un partenaire
        if ($currentUser->role === 'client' && $targetUser->role === 'partenaire') {
            return true;
        }
        
        if ($currentUser->role === 'client' && $targetUser->role === 'client') {
            return true;
        }
        
        

        // Un partenaire peut voir la fiche d'un client (potentiellement s'il y a une interaction,
        // par exemple une réservation. Pour l'instant, on l'autorise).
        if ($currentUser->role === 'partenaire' && $targetUser->role === 'client') {
            // Vous pourriez ajouter une condition : s'ils ont eu une réservation ensemble.
            // $hasInteraction = $currentUser->reservationsAsClient()->whereHas('annonce', function ($query) use ($targetUser) {
            //     $query->where('proprietaire_id', $targetUser->id);
            // })->exists() || $targetUser->reservationsAsClient()->whereHas('annonce', function ($query) use ($currentUser) {
            //     $query->where('proprietaire_id', $currentUser->id);
            // })->exists();
            // return $hasInteraction;
            return true; // Simplifié pour l'instant
        }
        
        // Un admin peut voir n'importe quelle fiche utilisateur
        if ($currentUser->isAdmin()) { // Assurez-vous que la méthode isAdmin() est définie dans User model
            return true;
        }

        // Par défaut, on interdit de voir la fiche d'un autre client
        return false;
    }
}