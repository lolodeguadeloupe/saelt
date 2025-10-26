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
        <div class="produit-titre">{{trans('front-panier.billetterie')}}</div>
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
                                <span>{{trans('front-billeterie.aller')}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.port_depart')}} :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.port_arrive')}} :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.date_et_heure_depart')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_depart']))}} à {{date('H:i', strtotime($item['heure_aller']))}}
                                </span>
                            </div>
                            @if($item['parcours'] == 2)
                            <div class="col-detail m-b-text" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>{{trans('front-billeterie.retour')}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.port_depart')}} :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.port_arrive')}} :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-billeterie.date_et_heure_retour')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_retour']))}} à {{date('H:i', strtotime($item['heure_retour']))}}
                                </span>
                            </div>
                            @endif
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>{{trans('front-billeterie.passagers')}}</span>
                            </div>
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
        <div class="produit-titre">{{trans('front-panier.excursion')}}</div>
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
                                <span class="titre">{{trans('front-excursion.date_excursion')}} :</span>
                                <span class="value">{{date('d-m-Y', strtotime($item['date_excursion']))}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-excursion.destination')}} :</span>
                                <span class="value">{{$item['ile']['name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-excursion.duree')}} :</span>
                                <span class="value">
                                    {{$item['duration']}}
                                </span>
                            </div>
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>{{trans('front-excursion.personnes')}}</span>
                            </div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                            @if(count($item['supplement']))
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-excursion.supplements')}} :</span>
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
        <div class="produit-titre">{{trans('front-panier.hebergement')}}</div>
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
                                <span class="titre">{{trans('front-hebergement.transport')}} :</span>
                                @if($item['vol'] == null)
                                <span class="value">Sans vol</span>
                                @else
                                <span class="value">Avec vol</span>
                                @endif
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.nombre_nuits')}} :</span>
                                <span class="value">{{diff_days($item['date_fin'],$item['date_debut'])}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.dates_sejour')}} :</span>
                                <span class="value">{{date('d-m-Y', strtotime($item['date_debut']))}} au {{date('d-m-Y', strtotime($item['date_fin']))}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.base_type')}} :</span>
                                <span class="value">
                                    {{$item['chambre_base_type_titre']}} ({{$item['chambre_base_type_nombre']}}Pers.)
                                </span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.capacite_max')}} :</span>
                                <span class="value">
                                    {{$item['chambre_capacite']}}Pers.
                                </span>
                            </div>
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.personnes')}} :</span>
                            </div>
                            @foreach($item['personne'] as $item_pers)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{$item_pers['type']}} :</span>
                                <span class="value">{{$item_pers['nb']}}</span>
                            </div>
                            @endforeach
                            @if(count($item['supplement']))
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-hebergement.supplements')}} :</span>
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
        <div class="produit-titre">{{trans('front-panier.location')}}</div>
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
                                <span class="titre">{{trans('front-location.lieu_depart')}} :</span>
                                <span class="value">{{$item['agence_recuperation_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-location.date_et_heure_depart')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_recuperation']))}} à {{date('H:i', strtotime($item['heure_recuperation']))}}
                                </span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-location.lieu_retour')}} :</span>
                                <span class="value">{{$item['agence_restriction_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-location.date_et_heure_retour')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_restriction']))}} à {{date('H:i', strtotime($item['heure_restriction']))}}
                                </span>
                            </div>
                            @if($item['deplacement_lieu_tarif'] != null && $item['deplacement_lieu_tarif'] != 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-location.supplement_deplacements')}} :</span>
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
                        {{trans('front-location.information_conducteur')}}
                    </div>
                    <div class="info-cond-content d-block" style="height: 10px;"></div>
                    <div style="width: 95%;margin:auto">
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.nom')}} :</span>
                                <span class="value">{{$item['nom_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.prenom')}} :</span>
                                <span class="value">{{$item['prenom_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.adresse')}} :</span>
                                <span class="value">{{$item['adresse_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.ville')}} :</span>
                                <span class="value">{{$item['ville_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.code_postal')}} :</span>
                                <span class="value">{{$item['code_postal_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle"></div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.telephone')}} :</span>
                                <span class="value">{{$item['telephone_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.email')}} :</span>
                                <span class="value">{{$item['email_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.date_naissance')}} :</span>
                                <span class="value">{{$item['date_naissance_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.lieu_naissance')}}:</span>
                                <span class="value">{{$item['lieu_naissance_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.numero_permis')}} :</span>
                                <span class="value">{{$item['num_permis_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.date_permis')}} :</span>
                                <span class="value">{{$item['date_permis_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.lieu_delivrance_permis')}} :</span>
                                <span class="value">{{$item['lieu_deliv_permis_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle"></div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.numero_piece_identite')}} :</span>
                                <span class="value">{{$item['num_identite_conducteur']}}</span>
                            </div>
                            <div class="info-cond-col-2 d-inline v-middle">
                                <span class="titre">{{trans('front-location.date_delivrance_identite')}} :</span>
                                <span class="value">{{$item['date_emis_identite_conducteur']}}</span>
                            </div>
                        </div>
                        <div class="info-cond-content d-block m-b-text">
                            <div class="info-cond-col d-inline v-middle">
                                <span class="titre">{{trans('front-location.lieu_delivrance_identite')}} :</span>
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
        <div class="produit-titre">{{trans('front-panier.transfert')}}</div>
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
                        @{{item.titre}}
                    </div>
                    <div class="devis-facture-content d-block p-relative">
                        <div class="devis-facture-content-img d-inline v-middle">
                            <img src="{{public_path($item['image'])}}" alt="" class="image-une">
                        </div>
                        <div class="devis-facture-content-detail d-inline v-top">
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>{{trans('front-transfert.aller')}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.lieu_depart')}} :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.lieu_arrive')}} :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.date_et_heure_depart')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_depart']))}} à {{date('H:i', strtotime($item['heure_depart']))}}
                                </span>
                            </div>
                            @if($item['prime_depart'] > 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.prime_nuit')}} :</span>
                                <span class="value">{{$item['prime_depart']}}</span>
                            </div>
                            @endif
                            @if($item['parcours'] == 2)
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span>{{trans('front-transfert.retour')}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.lieu_depart')}} :</span>
                                <span class="value">{{$item['lieu_arrive_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.lieu_arrive')}} :</span>
                                <span class="value">{{$item['lieu_depart_name']}}</span>
                            </div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.date_et_heure_retour')}} :</span>
                                <span class="value">
                                    {{date('d-m-Y', strtotime($item['date_retour']))}} à {{date('H:i', strtotime($item['heure_retour']))}}
                                </span>
                            </div>
                            @if($item['prime_retour'] > 0)
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.prime_nuit')}} :</span>
                                <span class="value">{{$item['prime_retour']}}</span>
                            </div>
                            @endif
                            @endif
                            <div class="col-detail" style="height: 10px;"></div>
                            <div class="col-detail m-b-text">
                                <span class="titre">{{trans('front-transfert.passagers')}} :</span>
                            </div>
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
                        {{trans('front-panier.frais_dossier')}}
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
                    {{trans('front-panier.tva')}}
                </div>
                <div class="tva-value d-inline">
                    {{$data['tva']}}€
                </div>
            </div>
            <div class="col" style="border-top: 1px solid black;">
                <div class="ht-titre d-inline">
                    {{trans('front-panier.ht')}}
                </div>
                <div class="ht-value d-inline">
                    {{$data['prix']}}€
                </div>
            </div>
            <div class="col" style="border-top: 1px solid black;">
                <div class="ttc-titre d-inline">
                    {{trans('front-panier.total_ttc')}}
                </div>
                <div class="ttc-value d-inline">
                    {{$data['prix_total']}}€
                </div>
            </div>
        </div>
    </div>
</body>

</html>