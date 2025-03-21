@extends('layouts.app')

@section('content')
    <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>

    <h3>Parents :</h3>
    <ul>
        @foreach($person->parents as $relation)
            <li>{{ $relation->parent->first_name }} {{ $relation->parent->last_name }}</li>
        @endforeach
    </ul>

    <h3>Enfants :</h3>
    <ul>
        @foreach($person->children as $relation)
            <li>{{ $relation->child->first_name }} {{ $relation->child->last_name }}</li>
        @endforeach
    </ul>

    <a href="{{ route('people.index') }}">⬅ Retour</a>
@endsection
