<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@extends('layouts.master')
@section('content')
    {!!Form::open(['url' => 'login']) !!}
    <div class="col-md-12 well well-md">
        <center><h1>Authentification</h1></center>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Identifiant : </label>
                <div class="col-md-6  col-md-3">
                    <input type="text" name="login" class="form-control" placeholder="Votre identifiant" required
                           autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Mot de passe : </label>
                <div class="col-md-6 col-md-3">
                    <input type="password" name="pwd" class="form-control" placeholder="Votre mot de passe" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default btn-primary"><span
                            class="glyphicon glyphicon-log-in"></span> Valider
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">

            </div>
        </div>
    </div>
</body>
</html>
@stop
