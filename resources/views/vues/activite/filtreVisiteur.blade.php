@extends('layouts.master')
<body>
<h1>Sélectionnez des éléments dans les listes déroulantes</h1>

<form action="{{ route('traitement') }}" method="POST">
    @csrf
    <label for="liste1">Liste 1 :</label>
    <select name="liste1" id="liste1">
        @foreach($elementsListe1 as $element)
            <option value="{{ $element }}">{{ $element }}</option>
        @endforeach
    </select>

    <label for="liste2">Liste 2 :</label>
    <select name="liste2" id="liste2">
        @foreach($elementsListe2 as $element)
            <option value="{{ $element }}">{{ $element }}</option>
        @endforeach
    </select>

    <button type="submit">Valider</button>
</form>
</body>
</html>
