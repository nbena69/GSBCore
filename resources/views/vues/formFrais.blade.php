<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB Frais Liste</title>
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

<form action="{{ url('validerFrais') }}" method="get">
    @csrf
    <div class="container">
        <div class="col-md-12 col-sm-12 well well-md">
            <center><h1>Titre</h1></center>
            <div class="form-horizontal">
                <input type="hidden" name="id_frais" value="{{ $unFrais->id_frais ?? 0 }}"/>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Période :</label>
                    <div class="col-md-2 col-sm-2">
                        <input type="text" name="anneemois" value="{{ $unFrais->anneemois ?? '' }}"
                               class="form-control" placeholder="AAAA-MM" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Nb justificatifs :</label>
                    <div class="col-md-2 col-sm-2">
                        <input type="number" name="nbjustificatifs" value="{{ $unFrais->nbjustificatifs ?? 0 }}"
                               class="form-control" placeholder="Nombre de justificatifs" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Montant validé :</label>
                    <div class="col-md-3 col-sm-3">
                        <label class="control-label" >{{ $unFrais->montantvalide ?? 0 }}</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <button type="submit" class="btn btn-default btn-primary">
                            <span class="glyphicon glyphicon-ok"></span> Valider
                        </button>
                        &nbsp;
                        <button type="button" class="btn btn-default btn-primary"
                                onclick="javascript: window.location = '{{url('/getListeFrais')}}';">
                            <span class="glyphicon glyphicon-remove"></span> Annuler
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <a href="{{ url('frais-hors-forfait') }}">
                            <button type="button" class="btn btn-default btn-primary">
                                <span class="glyphicon glyphicon-list"></span> Frais hors forfait
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
