<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;

class PersonPolicy
{
    public function proposeModification(User $user, Person $person): bool
    {
        // Autoriser tous les utilisateurs à proposer des modifications
        return true;
        
        // OU pour limiter aux utilisateurs connectés depuis X jours
        // return $user->created_at->diffInDays(now()) > 3;
    }

    public function voteOnModification(User $user): bool
    {
        // Autoriser tous les utilisateurs actifs à voter
        return $user->is_active; // Suppose que vous avez ce champ

        // OU pour limiter aux utilisateurs avec un certain score
        // return $user->reputation_score > 50;
    }
}