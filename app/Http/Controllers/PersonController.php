<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Relationship;
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
        $person = Person::with(['children.child', 'parents.parent'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_name'    => 'nullable|string|max:255',
            'middle_names'  => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        // Formatage
        $validated['created_by'] = Auth::id();

        // Prénom : Première lettre majuscule, reste minuscule
        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));

        // Nom : tout en majuscules
        $validated['last_name'] = strtoupper($validated['last_name']);

        // Nom de naissance : majuscule ou = last_name si vide
        $validated['birth_name'] = strtoupper($validated['birth_name'] ?? $validated['last_name']);

        // Prénoms composés : capitaliser chaque prénom
        if (!empty($validated['middle_names'])) {
            $validated['middle_names'] = collect(explode(',', $validated['middle_names']))
                ->map(fn($name) => ucfirst(strtolower(trim($name))))
                ->implode(', ');
        } else {
            $validated['middle_names'] = null;
        }

        // Date : déjà validée par Laravel, si vide reste null
        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne ajoutée avec succès.');
    }

}

