<!DOCTYPE html>
<html>

<head>
    <title>Information conducteur</title>
    <style>
        @page {
            margin: 50px;
            padding: 50px;
        }

        * {
            font-size: 12px;
            font-weight: 400;
        }

        .bloc-info {
            width: 100%;
            position: relative;
        }

        .row {
            width: 100%;
            position: relative;
            margin-bottom: 10px;
        }

        .separateur {
            height: 10px;
        }

        .float-right {
            float: right;
        }

        .float-left {
            float: left;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .v-middle {
            vertical-align: middle;
        }

        .col {
            width: 100%;
            position: relative;
        }

        .col-2 {
            width: 49%;
            position: relative;
            display: inline-block;
        }

        .col-3 {
            width: 32%;
            position: relative;
            display: inline-block;
        }

        p.title {
            font-weight: 900;
            margin-bottom: 0px;
        }

        p.value {
            margin-top: 5px;
            padding-left: 5px;
        }

        span.title {
            font-weight: 900;
            margin-bottom: 0px;
            margin-right: 10px;
        }

        span.value {
            margin-top: 5px;
            padding-left: 5px;
        }
    </style>
</head>

<body>
    <div class="bloc-info">
        <div class="row">
            <h4 class="text-center" style="font-size: 18px; margin-bottom: 35px;">Information conduteur</h4>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Nom :</span>
                <span class="value">{{$data['nom_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Prénom(s) :</span>
                <span class="value">{{$data['prenom_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Adresse :</span>
                <span class="value">{{$data['adresse_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Ville :</span>
                <span class="value">{{$data['ville_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Code postal :</span>
                <span class="value">{{$data['code_postal_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Téléphone :</span>
                <span class="value">{{$data['telephone_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Email :</span>
                <span class="value">{{$data['email_conducteur']}}</span>
            </div>
        </div>
        <div class="row" style="height: 5px;" ></div>
        <div class="row">
            <div class="col-2">
                <span class="title">Date de naissance :</span>
                <span class="value">{{$data['date_naissance_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Lieu de naissance :</span>
                <span class="value">{{$data['lieu_naissance_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Numero de permis :</span>
                <span class="value">{{$data['num_permis_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Date de permis :</span>
                <span class="value">{{$data['date_permis_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Lieu de délivrance du permis :</span>
                <span class="value">{{$data['lieu_deliv_permis_conducteur']}}</span>
            </div>
        </div>
        <div class="row" style="height: 5px;" ></div>
        <div class="row">
            <div class="col-2">
                <span class="title">Numero de pièce d'identité :</span>
                <span class="value">{{$data['num_identite_conducteur']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Date émission pièce d'identité :</span>
                <span class="value">{{$data['date_emis_identite_conducteur']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Lieu de délivrance pièce d'identité :</span>
                <span class="value">{{$data['lieu_deliv_permis_conducteur']}}</span>
            </div>
        </div>
        <div class="separateur"></div>
        <div class="row">
            <h4 class="text-center" style="font-size: 18px; margin-bottom: 35px;">Information véhicule</h4>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Modèle de véhicule :</span>
                <span class="value">{{$data['modele_vehicule_titre']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Catégorie de vehicule :</span>
                <span class="value">{{$data['categorie_vehicule_titre']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Marque de véhicule :</span>
                <span class="value">{{$data['marque_vehicule_titre']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Nombre de place :</span>
                <span class="value">{{$data['vehicule_technique']['nombre_place']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Nombre de porte :</span>
                <span class="value">{{$data['vehicule_technique']['nombre_porte']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Boite de vitesse :</span>
                <span class="value">{{$data['vehicule_technique']['boite_vitesse']}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <span class="title">Nombre de vitesse :</span>
                <span class="value">{{$data['vehicule_technique']['nombre_vitesse']}}</span>
            </div>
            <div class="col-2">
                <span class="title">Type de carburant :</span>
                <span class="value">{{$data['vehicule_technique']['type_carburant']}}</span>
            </div>
        </div>
    </div>
</body>

</html>