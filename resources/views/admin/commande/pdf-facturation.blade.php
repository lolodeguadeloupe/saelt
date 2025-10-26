<!DOCTYPE html>
<html>

<head>
    <title>Facture</title>
    <style>
        @page {
            margin: 50px;
            padding: 50px;
        }

        * {
            font-size: 12px;
            line-height: 1.2em;
            font-weight: 400;
            box-sizing: border-box;
        }

        body {
            width: 700px;
        }

        .break-before {
            page-break-before: auto;
        }

        .break-inside {
            page-break-inside: auto;
        }

        .break-after {
            page-break-after: auto;
        }

        .table {
            display: table;
        }

        .t-row {
            display: table-row;
        }

        .t-cell {
            display: table-cell;
        }

        .d-inline {
            display: inline-block !important;
        }

        .d-block {
            display: block !important;
        }

        .v-middle {
            vertical-align: middle;
        }

        .v-top {
            vertical-align: top;
        }

        .p-relative {
            position: relative !important;
        }

        .col {
            width: 700px;
            padding: 2px 1px;
        }

        .col-2 {
            width: 348px;
        }

        .col-3 {
            width: 230px;
        }

        .p-t {
            padding-top: 10px;
        }

        .p-b {
            padding-bottom: 10px;
        }

        .m-b-text {
            margin-bottom: 2px;
        }

        .logo-image {
            height: 30px;
        }

        .titre {
            font-weight: bold;
        }

        .value {
            padding-left: 5px;
        }

        .supp {
            padding-left: 10px;
        }

        .bloc-facture {
            width: 700px;
        }

        .bloc-facture-separateur {
            width: 700px;
            height: 15px;
        }

        .detail-separateur {
            width: 700px;
            height: 10px;
        }

        .bloc-info-societe {
            text-align: left;
        }

        .bloc-info-client {
            width: 300px;
            text-align: left;
            margin: 0 0 0 auto;
        }

        .titre-facture {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            padding: 2px 10px;
        }

        .detail-facture {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            padding: 2px 10px;
        }

        .produit-titre {
            font-weight: bold;
            text-align: center;
        }

        .devis-facture {
            width: 580px;
            text-align: center;
        }

        .devis-facture-content {
            width: 580px;
        }

        .devis-facture-content-titre {
            width: 580px;
            text-align: center;
        }

        .devis-facture-content-img {
            width: 200px;
            text-align: center;
        }

        .image-une {
            width: 100px;
        }

        .devis-facture-content-detail {
            width: 282px;
            text-align: left;
        }

        .col-detail {
            width: 242px;
        }

        .pu-facture {
            width: 90px;
            text-align: center;
        }

        .total-facture {
            width: 100px;
            text-align: center;
        }



        .frais-dossier {
            font-weight: bold;
            text-align: left;
        }

        .tva-titre {
            width: 590px;
            text-align: center;
            padding-top: 5px;
        }

        .tva-value {
            width: 100px;
            text-align: center;
            padding-top: 5px;
        }

        .ht-titre {
            width: 590px;
            text-align: center;
            padding-top: 5px;
        }

        .ht-value {
            width: 100px;
            text-align: center;
            padding-top: 5px;
        }

        .ttc-titre {
            width: 590px;
            text-align: center;
            padding-top: 5px;
        }

        .ttc-value {
            width: 100px;
            text-align: center;
            padding-top: 5px;
        }

        .info-cond-content {
            width: 580px;
            text-align: left;
        }

        .info-cond-col-2 {
            width: 240px;
        }

        .info-cond-col-3 {
            width: 160px;
        }
    </style>
</head>

<body>
    @php
    $count = 0;
    $divise = 2;
    @endphp
    <div class="bloc-facture">
        <div class="bloc-info-societe">
            <div class="col">
                <img src="{{public_path('assets/img/logo.png')}}" alt="" class="logo-image">
            </div>
            <div class="col">
                <span class="titre">{{$data['app']['nom']}}</span>
            </div>
            <div class="col">
                <span> {{$data['app']['adresse']}}</span>
            </div>
            <div class="col">
                <span>{{$data['app']['ville'] ? $data['app']['ville']['name']:''}} - {{$data['app']['ville']?$data['app']['ville']['code_postal']:''}} </span>
            </div>
            <div class="col">
                <span> {{$data['app']['telephone']}}</span>
            </div>
            <div class="col">
                <span>{{$data['app']['email']}} </span>
            </div>
            <div class="col">
                <span>{{$data['app']['site_web']}} </span>
            </div>
        </div>
    </div>
    <div class="bloc-facture">
        <div class="bloc-info-client">
            <div class="d-block">
                <span>{{$data['facture']['nom']}}</span>
            </div>
            <div class="d-block">
                <span>{{$data['facture']['prenom']}}</span>
            </div>
            <div class="d-block">
                <span>{{$data['facture']['ville']}} - {{$data['facture']['code_postal']}}</span>
            </div>
            <div class="d-block">
                <span>{{$data['facture']['telephone']}}</span>
            </div>
            <div class="d-block">
                <span>{{$data['facture']['email']}}</span>
            </div>
        </div>
    </div>
    <div class="bloc-facture-separateur"></div>
    <div class="bloc-facture" style="background-color: #cecbb3;padding-right: 5px;">
        <div class="titre-facture">Facture</div>
    </div>
    <div class="bloc-facture-separateur"></div>
    <div class="bloc-facture d-block">
        <div class="col d-block">
            <span class="titre">Commande : </span><span class="value">{{$data['id']}}</span>
        </div>
        <div class="col d-block">
            <span class="titre">Date commade : </span><span class="value">{{parse_date_string($data['date'])}}</span>
        </div>
        <div class="col d-block">
            <div class="col-3 d-inline"><span class="titre">Mode paiement : </span><span class="value">{{$data['mode_payement']['titre']}}</span></div>
            <div class="col-3 d-inline"><span class="titre">Status : </span><span class="value">{{config('ligne-commande.status')[$data['status']]['value']}}</span></div>
            <div class="col-3 d-inline"><span class="titre">Total payé : </span><span class="value">{{$data['prix_total']}}€</span></div>
        </div>
    </div>
    <div class="bloc-facture-separateur"></div>
    <div class="bloc-facture">
        <div class="detail-facture">Détail</div>
    </div>
    <div class="bloc-facture-separateur"> </div>
    <div class="bloc-facture">
        <div class="col d-block" style="background-color: rgb(119, 164, 100);">
            <div class="devis-facture d-inline v-middle">Dévis</div>
            <div class="total-facture d-inline v-middle">Sous total</div>
        </div>
    </div>
    @if(count($data['billeterie']))
    <div class="bloc-facture-separateur" style="height: 30px;"> </div>
    <div class="bloc-facture p-t" style="border-top: 1px dashed gray;">
        <div class="produit-titre">Billeterie</div>
    </div>
    @endif
    @foreach($data['billeterie'] as $key => $item)
    @php $count++ @endphp
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture p-b" style="border-bottom: 1px dashed gray;">
            <div class="col d-block" style="border-right: 1px dashed gray;border-left: 1px dashed gray;">
                <div class="devis-facture d-inline v-top">
                    <div class="devis-facture-content-titre d-block m-b-text">
                        {{$item['lieu_depart_name']}} - {{$item['lieu_arrive_name']}}
                    </div>
                    <div class="devis-facture-content d-block p-relative m-b-text">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>Aller</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Port de départ :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Port d'arrivée :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de départ :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_depart']))}} à {{date('H:i', strtotime($item['heure_aller']))}}
                                </span>
                            </div>
                            @if($item['parcours'] == 2)
                            <div class="col-detail m-b-text" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>Retour</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Port de départ :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Port d'arrivée :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de départ :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_retour']))}} à {{date('H:i', strtotime($item['heure_retour']))}}
                                </span>
                            </div>
                            @endif
                            <div class="col-detail" style="height: 10px;"></div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="total-facture d-inline v-middle">
                    {{$item['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
    @if($count%$divise == 0)
    @php
    $count=0;
    $divise = 3;
    @endphp
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
    <!-- -->
    @if($count%$divise == 0)
    @php $count=0;@endphp
    @endif
    <!--  -->
    @if(count($data['excursion']))
    <div class="bloc-facture-separateur"> </div>
    <div class="bloc-facture p-t" style="border-top: 1px dashed gray;">
        <div class="produit-titre">Excursion</div>
    </div>
    @endif
    @foreach($data['excursion'] as $key => $item)
    @php $count++ @endphp
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture p-b" style="border-bottom: 1px dashed gray;">
            <div class="col d-block" style="border-right: 1px dashed gray;border-left: 1px dashed gray;">
                <div class="devis-facture d-inline v-top">
                    <div class="devis-facture-content-titre d-block">
                        {{$item['title']}}
                    </div>
                    <div class="devis-facture-content d-block p-relative">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['fond_image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date d'excursion :</span>
                                <span class="value">{{date('d-m-Y', strtotime($item['date_excursion']))}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Destination :</span>
                                <span class="value">{{$item['ile']['name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Durée :</span>
                                <span class="value">
                                    {{$item['duration']}}
                                </span>
                            </div>
                            <div class="col-detail" style="height: 10px;"></div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                            @if(count($item['supplement']))
                            <div class="col-detail m-b-text">
                                <span class="titre">Supplement :</span>
                            </div>
                            @foreach($item['supplement'] as $item_supp)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_supp['titre']}} :</span>
                                <span class="value">{{$item_supp['prix']}}€</span>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="total-facture d-inline v-middle">
                    {{$item['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
    @if($count%$divise == 0)
    @php $count=0;@endphp
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach

    <!-- -->
    @if($count%$divise == 0)
    @php $count=0;@endphp
    @endif
    <!--  -->
    @if(count($data['hebergement']))
    <div class="bloc-facture-separateur"> </div>
    <div class="bloc-facture p-t" style="border-top: 1px dashed gray;">
        <div class="produit-titre">Hébérgment</div>
    </div>
    @endif
    @foreach($data['hebergement'] as $key => $item)
    @php $count++ @endphp
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture p-b" style="border-bottom: 1px dashed gray;">
            <div class="col d-block" style="border-right: 1px dashed gray;border-left: 1px dashed gray;">
                <div class="devis-facture d-inline v-top">
                    <div class="devis-facture-content-titre d-block">
                        {{$item['chambre_name']}}
                    </div>
                    <div class="devis-facture-content d-block p-relative">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['chambre_image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Hébergement :</span>
                                @if($item['vol'] == null)
                                <span class="value">Sans vol</span>
                                @else
                                <span class="value">Avec vol</span>
                                @endif
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Nombre de nuitées :</span>
                                <span class="value">{{diff_days($item['date_fin'],$item['date_debut'])}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Dates de séjour :</span>
                                <span class="value">{{date('d-m-Y', strtotime($item['date_debut']))}} au {{date('d-m-Y', strtotime($item['date_fin']))}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Base type :</span>
                                <span class="value">
                                    {{$item['chambre_base_type_titre']}} ({{$item['chambre_base_type_nombre']}}Pers.)
                                </span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Capacité max :</span>
                                <span class="value">
                                    {{$item['chambre_capacite']}}Pers.
                                </span>
                            </div>
                            <div class="col-detail" style="height: 10px;"></div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                            @if(count($item['supplement']))
                            <div class="col-detail m-b-text">
                                <span class="titre">Supplement :</span>
                            </div>
                            @foreach($item['supplement'] as $item_supp)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_supp['titre']}} :</span>
                                <span class="value">{{$item_supp['prix']}}€</span>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="total-facture d-inline v-middle">
                    {{$item['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
    @if($count%$divise == 0)
    @php $count=0;@endphp
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
    <!--  -->
    @if($count%$divise == 0)
    @php $count=0;@endphp
    @endif
    <!--  -->
    @if(count($data['location']))
    <div class="bloc-facture-separateur"> </div>
    <div class="bloc-facture p-t" style="border-top: 1px dashed gray;">
        <div class="produit-titre">Location</div>
    </div>
    @endif
    @foreach($data['location'] as $key => $item)
    @php $count++ @endphp
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture p-b" style="border-bottom: 1px dashed gray;">
            <div class="col d-block" style="border-right: 1px dashed gray;border-left: 1px dashed gray;">
                <div class="devis-facture d-inline v-top">
                    <div class="devis-facture-content-titre d-block">
                        {{$item['titre']}}
                    </div>
                    <div class="devis-facture-content d-block p-relative">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieu de départ :</span>
                                <span class="value">{{$item['agence_recuperation_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de départ :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_recuperation']))}} à {{date('H:i', strtotime($item['heure_recuperation']))}}
                                </span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieur de retour :</span>
                                <span class="value">{{$item['agence_restriction_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de retour :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_restriction']))}} à {{date('H:i', strtotime($item['heure_restriction']))}}
                                </span>
                            </div>
                            @if($item['deplacement_lieu_tarif'] != null && $item['deplacement_lieu_tarif'] != 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">Supplément de déplacements :</span>
                                <span class="value">
                                    {{$item['deplacement_lieu_tarif']}}€
                                </span>
                            </div>
                            @endif
                            @if($item['caution'] != null && $item['caution'] != 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('admin.vehicule-location.columns.caution')}} :</span>
                                <span class="value">
                                    {{$item['caution']}}€
                                </span>
                            </div>
                            @endif
                            @if($item['franchise'] != null && $item['franchise'] != 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('admin.vehicule-location.columns.franchise')}} :</span>
                                <span class="value">
                                    {{$item['franchise']}}€
                                </span>
                            </div>
                            @endif
                            @if($item['franchise_non_rachatable'] != null && $item['franchise_non_rachatable'] != 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('admin.vehicule-location.columns.franchise_non_rachatable')}} :</span>
                                <span class="value">
                                    {{$item['franchise_non_rachatable']}}€
                                </span>
                            </div>
                            @endif
                            <div class="col-detail" style="height: 10px;"></div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                            @if(count($item['supplement']))
                            <div class="col-detail m-b-text">
                                <span class="titre">Supplement :</span>
                            </div>
                            @foreach($item['supplement'] as $item_supp)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_supp['titre']}} :</span>
                                <span class="value">{{$item_supp['prix']}}€</span>
                            </div>
                            @endforeach
                            @endif
                            @if(isset($item['info_tech']['fiche_technique']))
                            <div class="col-detail m-b-text">
                                <a href="{{asset($item['info_tech']['fiche_technique'])}}">
                                    Fiche technique
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="info-cond-content d-block" style="height: 10px;"></div>
                    <div class="info-cond-content d-block" style="text-align: center;">
                        Information conducteur
                    </div>
                    <div class="info-cond-content d-block" style="height: 10px;"></div>
                    <div style="width: 95%;margin:auto">
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Nom :</span>
                                <span class="value">{{$item['nom_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Prénom(s) :</span>
                                <span class="value">{{$item['prenom_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Adresse :</span>
                                <span class="value">{{$item['adresse_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Ville :</span>
                                <span class="value">{{$item['ville_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Code postal :</span>
                                <span class="value">{{$item['code_postal_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle"></div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Téléphone :</span>
                                <span class="value">{{$item['telephone_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Email :</span>
                                <span class="value">{{$item['email_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Date de naissance :</span>
                                <span class="value">{{$item['date_naissance_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Lieu de naissance :</span>
                                <span class="value">{{$item['lieu_naissance_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Numero de permis :</span>
                                <span class="value">{{$item['num_permis_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Date de permis :</span>
                                <span class="value">{{$item['date_permis_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Lieu de délivrance du permis :</span>
                                <span class="value">{{$item['lieu_deliv_permis_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle"></div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Numero de pièce d'identité :</span>
                                <span class="value">{{$item['num_identite_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">Date émission pièce d'identité :</span>
                                <span class="value">{{$item['date_emis_identite_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col d-inline v-middle">
                                <span class="titre">Lieu de délivrance pièce d'identité :</span>
                                <span class="value">{{$item['lieu_deliv_permis_conducteur']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total-facture d-inline v-middle">
                    {{$item['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
    @if($count%$divise == 0)
    @php $count=0; @endphp
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
    <!-- -->
    @if($count%$divise == 0)
    @php $count=0;@endphp
    @endif
    <!--  -->
    @if(count($data['transfert']))
    <div class="bloc-facture-separateur"> </div>
    <div class="bloc-facture p-t" style="border-top: 1px dashed gray;">
        <div class="produit-titre">Transfert</div>
    </div>
    @endif
    @foreach($data['transfert'] as $key => $item)
    @php $count++ @endphp
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture p-b" style="border-bottom: 1px dashed gray;">
            <div class="col d-block" style="border-right: 1px dashed gray;border-left: 1px dashed gray;">
                <div class="devis-facture d-inline v-top">
                    <div class="devis-facture-content-titre d-block">
                        {{$item['titre']}}
                    </div>
                    <div class="devis-facture-content d-block p-relative">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>Aller</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieu de départ :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieu d'arrivée :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de départ :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_depart']))}} à {{date('H:i', strtotime($item['heure_depart']))}}
                                </span>
                            </div>
                            @if($item['prime_depart'] > 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">Prime nuit :</span>
                                <span class="value">{{$item['prime_depart']}}</span>
                            </div>
                            @endif
                            @if($item['parcours'] == 2)
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>Retour</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieu de départ :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Lieu d'arrivée :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">Date et heure de départ :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_retour']))}} à {{date('H:i', strtotime($item['heure_retour']))}}
                                </span>
                            </div>
                            @if($item['prime_retour'] > 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">Prime nuit :</span>
                                <span class="value">{{$item['prime_retour']}}</span>
                            </div>
                            @endif
                            @endif
                            <div class="col-detail" style="height: 10px;"></div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="total-facture d-inline v-middle">
                    {{$item['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
    @if($count%$divise == 0)
    @php $count=0; @endphp
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
    <!--  -->
    @if($count%$divise == 0)
    @php $count=0;@endphp
    @endif
    <!--   -->
    <div class="detail-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture" style="border-bottom: 1px dashed gray;">
            <div class="col">
                <div class="devis-facture d-inline">
                    <div class="frais-dossier">
                        Frais de dossier
                    </div>
                </div>
                <div class="total-facture d-inline">
                    {{$data['frais_dossier']}}€
                </div>
            </div>
        </div>
    </div>
    <div class="bloc-facture-separateur"></div>
    <div style="width: 590px;border-right: 1px dashed gray;">
        <div class="bloc-facture" style="border: 1px solid black;">
            <div class="col">
                <div class="tva-titre d-inline">
                    TVA
                </div>
                <div class="tva-value d-inline">
                    {{$data['tva']}}€
                </div>
            </div>
            <div class="col" style="border-top: 1px solid black;">
                <div class="ht-titre d-inline">
                    HT
                </div>
                <div class="ht-value d-inline">
                    {{$data['prix']}}€
                </div>
            </div>
            <div class="col" style="border-top: 1px solid black;">
                <div class="ttc-titre d-inline">
                    Total TTC
                </div>
                <div class="ttc-value d-inline">
                    {{$data['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
</body>

</html>