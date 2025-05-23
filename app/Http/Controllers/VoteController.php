<?php

namespace App\Http\Controllers;

use App\Models\Modification;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, Modification $modification)
    {
        $request->validate([
            'vote' => 'required|boolean',
            'comment' => 'nullable|string'
        ]);

        // Vérifier si l'utilisateur a déjà voté
        if ($modification->votes()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous avez déjà voté sur cette modification!');
        }

        // Créer le vote
        Vote::create([
            'modification_id' => $modification->id,
            'user_id' => Auth::id(),
            'vote' => $request->vote,
            'comment' => $request->comment
        ]);

        // Vérifier si la modification peut être approuvée/rejetée
        $approveCount = $modification->approveVotesCount();
        $rejectCount = $modification->rejectVotesCount();

        if ($approveCount >= 3) {
            $this->applyModification($modification);
            $modification->update(['status' => 'approved']);
        } elseif ($rejectCount >= 3) {
            $modification->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Votre vote a été enregistré!');
    }

    protected function applyModification(Modification $modification)
    {
        if ($modification->person_id) {
            // Modification d'une personne
            $person = $modification->person;
            $person->update([$modification->field => $modification->new_value]);
        } else {
            // Ajout d'une relation
            $data = json_decode($modification->new_value, true);
            Relationship::create([
                'parent_id' => $data['parent_id'],
                'child_id' => $data['child_id'],
                'created_by' => $modification->user_id
            ]);
        }
    }
}