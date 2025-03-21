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

        $validated['created_by'] = Auth::id();
        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));
        $validated['last_name'] = strtoupper($validated['last_name']);
        $validated['birth_name'] = strtoupper($validated['birth_name'] ?? $validated['last_name']);

        if (!empty($validated['middle_names'])) {
            $validated['middle_names'] = collect(explode(',', $validated['middle_names']))
                ->map(fn($name) => ucfirst(strtolower(trim($name))))
                ->implode(', ');
        }

        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne ajoutée avec succès.');
    }
}

