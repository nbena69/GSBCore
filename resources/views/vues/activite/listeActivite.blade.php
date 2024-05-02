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
            <th scope="col">Modifier</th>
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mesActivites as $activite)
            <tr>
                <td>{{ $activite->id_activite_compl }}</td>
                <td>{{ $activite->date_activite }}</td>
                <td>{{ $activite->lieu_activite }}</td>
                <td>{{ $activite->theme_activite }}</td>
                <td>{{ $activite->motif_activite }}</td>
                <td style="text-align: center;"><a href="{{url('/modifierActivite')}}/{{$activite->id_activite_compl}}">
                        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top"
                              title="modification"></span>
                    </a></td>
                <td style="text-align: center;"><a
                        class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top"
                        title="suppression" onclick="javascript:if (confirm('Suppression confirmée ?'))
                        {window.location = '{{url('/supprimerActivite')}}/{{$activite->id_activite_compl}}';}"></a></td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="col-md-6 col-md-offset-3">
    @php
        $erreur = session('erreur');
        $erreurSuppression = session('erreurSuppression');
        session()->forget('erreurSuppression');
    @endphp

    @if ($erreurSuppression)
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ $erreurSuppression }}
        </div>
    @endif

    @if ($erreur)
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ $erreur }}
        </div>
    @endif
</div>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
</body>
</html>
