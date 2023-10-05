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
<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#navbar-collapse-target">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">GSB Frais</a>
            </div>
            @if (Session::get('id') == 0)
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/formLogin') }}" data-toggle="collapse"
                               data-target=".navbar-collapse.in">Se connecter</a></li>
                    </ul>
                </div>
            @endif
            @if (Session::get('id') > 0)
                <div class="collapse navbar-collapse" id="navbar-collapse-target">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/getListeFrais') }}" data-toggle="collapse"
                               data-target=".navbar-collapse.in">Lister</a></li>
                        <li><a href="{{ url('/ajouterFrais') }}" data-toggle="collapse" data-target=".navbar-collapse.in">Ajouter</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('/getLogout') }}" data-toggle="collapse"
                               data-target=".navbar-collapse.in">Se déconnecter</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
</div>
<div class="container">
    <table class="table table-bordered table-striped table-responsive">
        <thead>
        <tr>
            <th style="width:60%">Période</th>
            <th style="width:20%">Modifier</th>
            <th style="width:20%">Supprimer</th>
        </tr>
        </thead>
        @foreach($mesFrais as $unFrais)
            <tr>
                <td>{{$unFrais->anneemois}}</td>
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
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
</body>
</html>
