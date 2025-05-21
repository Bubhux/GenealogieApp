<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}