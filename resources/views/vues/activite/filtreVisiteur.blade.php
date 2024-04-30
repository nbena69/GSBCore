@extends('layouts.master')
<body>
<div class="container">
    <h1 class="mt-5">Recherche de Visiteur</h1>
    <form action="/searchVisiteur" method="GET" class="mt-4">
        <div class="form-group">
            <label for="nom">Nom ou laboratoire du Visiteur:</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom du visiteur">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
</div>
</body>
</html>
