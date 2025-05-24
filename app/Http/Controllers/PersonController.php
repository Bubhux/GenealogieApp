<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\FamilyInvitationMail;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::with('creator')->get();
        return view('people.index', compact('people'));
    }

    public function show($id)
    {
        $person = Person::with(['children', 'parents', 'creator'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePerson($request);

        try {
            Person::create($validated);
            return redirect()->route('people.index')->with('success', 'Person created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating person: ' . $e->getMessage());
        }
    }

    protected function validatePerson(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        // Formatage des données
        $data['created_by'] = Auth::id();
        $data['first_name'] = ucfirst(strtolower($data['first_name']));

        if (!empty($data['middle_names'])) {
            $middleNames = explode(',', $data['middle_names']);
            $middleNames = array_map(function($name) {
                return ucfirst(strtolower(trim($name)));
            }, $middleNames);
            $data['middle_names'] = implode(',', $middleNames);
        } else {
            $data['middle_names'] = null;
        }

        $data['last_name'] = strtoupper($data['last_name']);
        $data['birth_name'] = $data['birth_name'] ? strtoupper($data['birth_name']) : $data['last_name'];

        return $data;
    }

    public function showInviteForm(Person $person)
    {
        return view('people.invite', compact('person'));
    }

    public function sendInvitation(Request $request, Person $person)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        try {
            // Créer un token d'invitation
            $token = Str::random(60);

            // Enregistrer l'invitation en base
            Invitation::create([
                'person_id' => $person->id,
                'email' => $request->email,
                'token' => $token,
                'message' => $request->message,
                'invited_by' => auth()->id(),
                'expires_at' => now()->addDays(7),
            ]);

            // Envoyer l'email
            Mail::to($request->email)->send(new FamilyInvitationMail($person, $token, $request->message));

            // Redirection vers la page de la personne avec message de succès
            return redirect()->route('people.show', $person->id)
                ->with('success', 'Invitation envoyée avec succès à ' . $request->email);

        } catch (\Exception $e) {
            // Redirection vers la page précédente avec message d'erreur
            return back()->with('error', "Erreur lors de l'envoi: " . $e->getMessage());
        }
    }
}