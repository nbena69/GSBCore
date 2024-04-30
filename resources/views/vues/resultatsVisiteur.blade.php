<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
</head>
<body>
<h1>Résultats de la recherche</h1>
<ul>
    @foreach($visiteurs as $visiteur)
        <li>{{ $visiteur->nom_visiteur }} - {{ $visiteur->id_laboratoire }}</li>
    @endforeach
</ul>
</body>
</html>
