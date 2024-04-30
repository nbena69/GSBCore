<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
</head>
@extends('layouts.master')
<body>
<div class="container">
    <h1 class="mt-5">Résultats de la recherche</h1>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Nom du Visiteur</th>
            <th scope="col">Laboratoire</th>
        </tr>
        </thead>
        <tbody>
        @foreach($visiteurs as $visiteur)
            <tr>
                <td>{{ $visiteur->nom_visiteur }}</td>
                <td>{{ $visiteur->laboratoire->nom_laboratoire }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
