<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB Frais</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/monStyle.css') }}">
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet" type="text/css">
    <style>
        body {
            padding-top: 35px;
            font-family: 'Roboto', sans-serif;
        }

        .navbar {
            margin-bottom: 0;
            background-color: #f8f8f8;
            border-color: #e7e7e7;
        }

        .navbar-fixed-top {
            border: none;
        }

        .navbar-brand {
            color: #333;
            font-weight: bold;
        }

        .navbar-nav > li > a {
            color: #333;
        }

        .navbar-nav > li > a:hover,
        .navbar-nav > li > a:focus {
            color: #555;
            background-color: transparent;
        }

        .container {
            margin-top: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px 0;
            text-align: center;
        }

    </style>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ url('/') }}" id="navbarDropdownMenuLink"
                               data-toggle="dropdown" aria-labelledby="navbarDropdown" aria-haspopup="true"
                               aria-expanded="false">
                                Frais
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"><ul>
                                <li><a class="dropdown-item" href="{{ url('/getListeFrais') }}"
                                   data-toggle="collapse" data-target=".navbar-collapse.in">Mes Frais</a></li>
                                <li><a class="dropdown-item" href="{{ url('/ajouterFrais') }}"
                                   data-toggle="collapse" data-target=".navbar-collapse.in">Ajouter un Frais</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ url('/') }}" id="navbarDropdownMenuLink"
                               data-toggle="dropdown" aria-labelledby="navbarDropdown" aria-haspopup="true"
                               aria-expanded="false">
                                Activité
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"><ul>
                                    <li><a class="dropdown-item" href="{{ url('/getFiltre') }}"
                                           data-toggle="collapse" data-target=".navbar-collapse.in">Liste des Activités</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/ajouterFrais') }}"
                                           data-toggle="collapse" data-target=".navbar-collapse.in">Ajouter une Activité</a></li>
                                </ul>
                            </div>
                        </li>
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
    @yield('content')
</div>
<footer class="footer">
    © 2023 Tous droits réservés à la société GSB Frais
</footer>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
