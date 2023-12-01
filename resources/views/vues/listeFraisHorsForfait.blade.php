@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="col-md-8 col-sm-8">
            <div class="blanc">
                <h1>Liste des frais hors forfait</h1>
            </div>

            <table class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Montant</th>
                    <th style="width:80px">Modifier</th>
                    <th style="width:80px">Supprimer</th>
                </tr>
                </thead>
                @foreach($mesFrais as $unFrais)
                    <tr>
                        <td>  {{ $unFrais->lib_fraishorsforfait }}</td>
                        <td>  {{ $unFrais->montant_fraishorsforfait }}</td>
                        <td style="text-align: center;"><a
                                href="{{ url('/modifierFraisHorsForfait') }}/{{ $unFrais->id_fraishorsforfait }}"><span
                                    class="glyphicon glyphicon-pencil" data-toggle="tootltip" data-olacement="top"
                                    title=""></span> </a></td>
                        <td style="text-align:center;">
                            <a class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top"
                               title="Supprimer" href="#"
                               onclick="javascript:if (confirm('Suppression confirmée ?')){window.location='{{ url('/supprimerFraisHors') }}/{{$unFrais->id_fraishorsforfait}}'; }">
                            </a>
                        </td>
                    </tr>

                @endforeach

                <tr>
                    <td style="text-align: right"> Montant total :</td>
                    <td>{{ $montantTotal ?? 0}}</td>
                </tr>

            </table>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <a href="{{ url('/ajouterFraisHorsForfait') }}/{{ request()->route('id') }}">
                            <button type="button" class="btn btn-default btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> Ajouter
                            </button>
                        </a>
                    &nbsp;
                    <button type="button" class="btn btn-default btn-primary"
                            onclick="javascript: window.history.back();">
                        <span class="glyphicon glyphicon-remove"></span> Annuler
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                @include('vues/error')
            </div>

        </div>
    </div>
@stop
