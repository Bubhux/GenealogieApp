<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RelationshipController extends Controller
{
    public function create()
    {
        $people = Person::all();
        return view('relationships.create', compact('people'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => [
                'required',
                'exists:people,id',
                Rule::unique('relationships')->where(function ($query) use ($request) {
                    return $query->where('child_id', $request->child_id);
                })
            ],
            'child_id' => 'required|exists:people,id|different:parent_id',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (Person::createsCycle($request->parent_id, $request->child_id)) {
                $validator->errors()->add('child_id', 'Cette relation créerait un cycle dans l\'arbre généalogique');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Relationship::create([
            'parent_id' => $request->parent_id,
            'child_id' => $request->child_id,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('people.show', $request->child_id)
            ->with('success', 'Relation ajoutée!');
    }
}