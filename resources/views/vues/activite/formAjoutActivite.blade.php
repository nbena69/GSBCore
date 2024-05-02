@extends('layouts.master')
@section('content')

    {!! Form::open(['url' => 'validerActivite']) !!}
    <div class="col-md-12  col-sm-12 well well-md">
        <center><h1>Ajouter une activité</h1></center>
        <div class="form-horizontal">
            <input type="hidden" name="id_activite_compl" value="{{$uneActivite->id_activite_compl ?? 0}}"/>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Date de l'activité : </label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="date_activite" value="{{$uneActivite->date_activite ?? ''}}" class="form-control"
                           placeholder="Date de l'activité" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Lieu de l'activité : </label>
                <div class="col-md-6  col-sm-6">
                    <input type="text" name="lieu_activite" value="{{$uneActivite->lieu_activite ?? ''}}"
                           class="form-control" placeholder="Lieu de l'activité" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Thème de l'activité : </label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name="theme_activite" value="{{$uneActivite->theme_activite ?? ''}}"
                           placeholder="Thème de l'activité" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Motif de l'activité : </label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name="motif_activite" value="{{$uneActivite->motif_activite ?? ''}}"
                           placeholder="Motif de l'activité" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <button type="submit" class="btn btn-default btn-primary">
                        <span class="glyphicon glyphicon-ok"></span> Valider
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-default btn-primary"
                            onclick="javascript: window.history.back();">
                        <span class="glyphicon glyphicon-remove"></span> Annuler
                    </button>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop
