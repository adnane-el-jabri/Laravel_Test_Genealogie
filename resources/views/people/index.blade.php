@extends('layouts.app')

@section('content')
    <h1>Liste des personnes</h1>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <a href="{{ route('people.create') }}">➕ Ajouter une personne</a>
    <ul>
        @foreach($people as $person)
            <li>
                <a href="{{ route('people.show', $person->id) }}">
                    {{ $person->first_name }} {{ $person->last_name }}
                </a>
                - Créé par : {{ $person->creator->name ?? 'Inconnu' }}
            </li>
        @endforeach
    </ul>
@endsection
