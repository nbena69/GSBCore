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


<form action="{{ url('validerFraisHors') }}" method="get">
    @csrf
    <div class="container">
        <div class="col-md-12 col-sm-12 well well-md">
            <center><h1>Titre</h1></center>
            <div class="form-horizontal">
                <input type="hidden" name="id_frais" value="{{ $unFraisHors->id_frais ?? 0 }}"/>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Libelle :</label>
                    <div class="col-md-6 col-sm-6">
                        <input type="text" name="libelle" value=""
                               class="form-control" placeholder="Saisissez le libellé" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Date :</label>
                    <div class="col-md-6 col-sm-6">
                        <input type="text" name="anneemois" value=""
                               class="form-control" placeholder="AAAA-MM" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Montant : </label>
                    <div class="col-md-6 col-sm-6">
                        <input type="text" name="montant" value=""
                               class="form-control" placeholder="Saisissez le montant" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <button type="submit" class="btn btn-default btn-primary">
                            <span class="glyphicon glyphicon-ok"></span> Valider
                        </button>
                        &nbsp;
                        <button type="button" class="btn btn-default btn-primary"
                                onclick="javascript: window.location = '{{ url('/getListeFraisHors') }}/{{$unFraisHors->id_frais}}';">
                            <span class="glyphicon glyphicon-remove"></span> Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
