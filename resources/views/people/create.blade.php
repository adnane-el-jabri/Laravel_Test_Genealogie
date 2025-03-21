@extends('layouts.app')

@section('content')
    <h1>Ajouter une personne</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('people.store') }}">
        @csrf

        <label>Prénom :</label>
        <input type="text" name="first_name" required><br>

        <label>Nom :</label>
        <input type="text" name="last_name" required><br>

        <label>Nom de naissance :</label>
        <input type="text" name="birth_name"><br>

        <label>Autres prénoms (séparés par des virgules) :</label>
        <input type="text" name="middle_names"><br>

        <label>Date de naissance :</label>
        <input type="date" name="date_of_birth"><br>

        <button type="submit">Enregistrer</button>
    </form>
@endsection
