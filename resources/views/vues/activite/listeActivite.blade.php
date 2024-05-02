<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/monStyle.css') }}">
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <link href="//fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet" type="text/css">
</head></head>
<body>
@extends('layouts.master')

<div class="container">
    <h1>Liste des Activités</h1>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Date</th>
            <th scope="col">Lieu</th>
            <th scope="col">Thème</th>
            <th scope="col">Motif</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mesActivites as $activite)
            <tr>
                <td>{{ $activite['id_activite_compl'] }}</td>
                <td>{{ $activite['date_activite'] }}</td>
                <td>{{ $activite['lieu_activite'] }}</td>
                <td>{{ $activite['theme_activite'] }}</td>
                <td>{{ $activite['motif_activite'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
</body>
</html>
