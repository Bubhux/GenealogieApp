<?php

namespace App\Http\Controllers;

use App\Models\Modification;
use App\Models\Person;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ModificationApproved;

class ModificationController extends Controller
{
    public function index()
    {
        $modifications = Modification::with(['user', 'person', 'relationship'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('modifications.index', compact('modifications'));
    }

    public function createForPerson(Person $person)
    {
        return view('modifications.create-person', compact('person'));
    }

    public function storeForPerson(Request $request, Person $person)
    {
        $validated = $request->validate([
            'field' => 'required|in:first_name,last_name,birth_name,middle_names,date_of_birth',
            'new_value' => 'required',
            'reason' => 'nullable|string'
        ]);

        $modification = Modification::create([
            'user_id' => Auth::id(),
            'person_id' => $person->id,
            'field' => $validated['field'],
            'old_value' => $person->{$validated['field']},
            'new_value' => $validated['new_value'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('modifications.show', $modification)
            ->with('success', 'Modification proposée avec succès!');
    }

    public function createForRelationship(Request $request)
    {
        $people = Person::all(); // Ou votre logique pour récupérer les personnes

        // Si un person_id est passé en paramètre
        $person = null;
        if ($request->has('person_id')) {
            $person = Person::find($request->input('person_id'));
        }

        return view('modifications.create-relationship', [
            'people' => $people,
            'person' => $person
        ]);
    }

    public function storeForRelationship(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'required|exists:people,id',
            'child_id' => 'required|exists:people,id|different:parent_id',
            'reason' => 'nullable|string'
        ]);

        if (Person::createsCycle($validated['parent_id'], $validated['child_id'])) {
            return back()->with('error', 'Cette relation créerait un cycle dans l\'arbre généalogique!');
        }

        $modification = Modification::create([
            'user_id' => Auth::id(),
            'new_value' => json_encode([
                'parent_id' => $validated['parent_id'],
                'child_id' => $validated['child_id']
            ]),
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('modifications.show', $modification)
            ->with('success', 'Relation proposée avec succès!');
    }

    public function show(Modification $modification)
    {
        $modification->load(['user', 'person', 'relationship', 'votes.user']);

        // Précharger les données de relation si nécessaire
        if (!$modification->person_id) {
            $relationData = json_decode($modification->new_value);
            $modification->parent = Person::find($relationData->parent_id ?? null);
            $modification->child = Person::find($relationData->child_id ?? null);
        }

        $userVote = $modification->votes()->where('user_id', Auth::id())->first();

        return view('modifications.show', compact('modification', 'userVote'));
    }

    public function storeVote(Request $request, Modification $modification)
    {
        $request->validate([
            'vote' => 'required|boolean',
            'comment' => 'nullable|string'
        ]);

        if ($modification->votes()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous avez déjà voté sur cette modification!');
        }

        $modification->votes()->create([
            'user_id' => Auth::id(),
            'vote' => $request->vote,
            'comment' => $request->comment
        ]);

        $this->checkModificationStatus($modification);

        return back()->with('success', 'Votre vote a été enregistré!');
    }

    protected function checkModificationStatus(Modification $modification)
    {
        $approveCount = $modification->approveVotesCount();
        $rejectCount = $modification->rejectVotesCount();

        if ($approveCount >= 3) {
            $modification->update(['status' => 'approved']);
            $this->applyModification($modification);
        } elseif ($rejectCount >= 3) {
            $modification->update(['status' => 'rejected']);
        }
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

        // Notifier les utilisateurs concernés
        $interestedUsers = $this->getInterestedUsers($modification);
        Notification::send(
            $interestedUsers,
            new ModificationApproved($modification)
        );
    }

    protected function getInterestedUsers(Modification $modification)
    {
        // Retourne une collection d'utilisateurs à notifier
        // Exemple basique - à adapter selon vos besoins
        if ($modification->person_id) {
            return User::whereIn('id', [
                $modification->person->created_by,
                $modification->user_id
            ])->get();
        }

        // Pour les relations, notifier les créateurs des personnes concernées
        $data = json_decode($modification->new_value, true);
        $parent = Person::find($data['parent_id']);
        $child = Person::find($data['child_id']);

        return User::whereIn('id', [
            $parent->created_by,
            $child->created_by,
            $modification->user_id
        ])->get();
    }
}