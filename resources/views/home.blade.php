@extends('layouts.master')
@section('content')
    <img src="{{ asset('assets/img/gsbFraisLogo.png') }}" alt="Logo GSB Frais" class="gsb-logo">

    <div class="gsb-container">
        <h1 class="gsb-title"> Gestion des frais de déplacements à l'hôpital GSB</h1>
        <p class="gsb-intro">Bienvenue dans le système de gestion des frais de déplacements de l'hôpital GSB. Ce système
            vous permet de suivre et de gérer les dépenses liées aux déplacements du personnel médical.</p>

        <h2 class="gsb-subtitle">Objectifs du système :</h2>
        <ul class="gsb-list">
            <li>Enregistrement des frais de déplacements des employés.</li>
            <li>Consultation et suivi des dépenses par département.</li>
            <li>Génération de rapports mensuels sur les frais de déplacements.</li>
        </ul>
        @if (Session::get('id') == 0)

        <h2 class="gsb-subtitle">Comment utiliser le système :</h2>
        <ol class="gsb-list">
            <li>Connectez-vous à votre compte utilisateur.</li>
            <li>Naviguez vers la section "Gestion des frais de déplacements".</li>
            <li>Enregistrez vos dépenses en fournissant les détails requis.</li>
            <li>Consultez les rapports pour suivre les dépenses par département et par mois.</li>
        </ol>
        @endif
        <p class="gsb-info">Si vous avez des questions ou des problèmes techniques, veuillez contacter le service
            informatique de l'hôpital GSB.</p>

    </div>

@stop
<style>
    .gsb-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f0f8ff;
        border: 1px solid #add8e6;
        border-radius: 10px;
        text-align: center;
    }

    .gsb-logo {
        display: block;
        max-width: 15%;
        height: auto;
        margin: 0 auto 20px;
    }

    .gsb-title {
        color: #000080;
        font-size: 28px;
    }

    .gsb-intro {
        color: #0000cd;
    }

    .gsb-subtitle {
        color: #000080;
        font-size: 24px;
        margin-top: 15px;
    }

    .gsb-list {
        margin-left: 20px;
    }

    .gsb-info {
        color: #1e90ff;
        margin-top: 20px;
    }

</style>
