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
    <h1>Inviter un praticien</h1>
    <p>Activité concernée n° {{$id_activite ?? 0}}</p>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Inviter</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mesPraticiens as $praticien)
            <tr>
                <td>{{ $praticien->nom_praticien }}</td>
                <td>{{ $praticien->prenom_praticien }}</td>
                <td style="text-align: center;"><a href="{{url('/ajoutInviter')}}/{{$praticien->id_praticien}}">
                        <span class="glyphicon glyphicon-plus" data-toggle="tooltip" data-placement="top"
                              title="ajouter"></span>
                    </a></td>            </tr>
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
