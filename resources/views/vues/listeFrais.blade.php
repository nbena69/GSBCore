<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB Frais Liste</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/monStyle.css') }}">
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet" type="text/css">
</head>
<body class="body">
@extends('layouts.master')

<div class="container">
    <table class="table table-bordered table-striped table-responsive">
        <thead>
        <tr>
            <th style="width:40%">Période</th>
            <th style="width:20%">Nombre de Justificatifs</th>
            <th style="width:20%">Modifier</th>
            <th style="width:20%">Supprimer</th>
        </tr>
        </thead>
        @foreach($mesFrais as $unFrais)
            <tr>
                <td>{{$unFrais->anneemois}}</td>
                <td>{{$unFrais->nbjustificatifs}}</td>
                <td style="text-align: center;"><a href="{{url('/modifierFrais')}}/{{$unFrais->id_frais}}">
                        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top"
                              title="modification"></span>
                    </a></td>
                <td style="text-align: center;"><a
                        class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top"
                        title="suppression" onclick="javascript:if (confirm('Suppression confirmée ?'))
                        {window.location = '{{url('/supprimerFrais')}}/{{$unFrais->id_frais}}';}"></a></td>
            </tr>
        @endforeach
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
