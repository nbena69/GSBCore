<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB Frais</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/monStyle.css') }}">
    <!-- Inclure jQuery avant Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <th style="width:50%">Libellé</th>
            <th style="width:30%">Montant</th>
            <th style="width:10%">Modifier</th>
            <th style="width:10%">Supprimer</th>
        </tr>
        </thead>
        @if(!empty($mesFraisHors))
            @foreach($mesFraisHors as $unFraisHors)
                <tr>
                    <td>{{$unFraisHors->lib_fraishorsforfait}}</td>
                    <td>{{$unFraisHors->montant_fraishorsforfait}}</td>
                    <td style="text-align: center;"><a href="{{url('/modifierFraisHors')}}/{{$unFraisHors->id_fraishorsforfait}}">
                        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top"
                              title="modification"></span>
                        </a></td>
                    <td style="text-align: center;"><a
                            class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top"
                            title="suppression" onclick="javascript:if (confirm('Suppression confirmée ?'))
                        {window.location = '{{url('/supprimerFraisHors')}}/{{$unFraisHors->id_fraishorsforfait}}';}"></a></td>
                </tr>
            @endforeach
        <td>Montant Total : </td>
                <td></td>
        @else
            <p>Aucun frais hors forfait trouvé.</p>
        @endif
    </table>

</div>
<div class="col-md-6 col-md-offset-3">
    @if (!empty($erreur))
        @include('vues/error')
    @endif
</div>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
</body>
</html>
