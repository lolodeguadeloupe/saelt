@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
@endpush

@section('title', 'Saelt voyages')

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/ct_sea-418742_1920.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md text-center">
                <h1 class="text-uppercase">Saelt Voyages vous remercie de votre confiance</h1>
                <h4> et vous souhaite un excellent séjour dans les îles de Guadeloupe !</h4>
            </div>
        </div>
    </div>
</section>
<section class="pt-5 notification d-none">
    <div class="container p-3" style="background-color:#eaeaea">
        <p class="mb-0"><i class="fas fa-shopping-cart mr-3" style="font-size: 1rem;"></i>Votre panier est actuellement vide.</p>
    </div>
</section>
<remerciement :url="'{{route('remerciement')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="py-5">
        <div class="container order-tab">
            <div class="pt-3 pb-2 mb-4 mx-0 position-relative">
                <div class="pb-3 border-bottom">
                    <h4>Détails de facturation</h4>
                    <hr class="separator mb-4 ml-0">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="nom">Nom :</label>
                                <input readonly class="form-control" type="text" id="nom" name="nom" :value="nom" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="prenom">Prénom(s) :</label>
                                <input readonly class="form-control" type="text" id="prenom" name="prenom" :value="prenom" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="adresse">Adresse :</label>
                                <input readonly class="form-control" type="text" id="adresse" name="adresse" :value="adresse" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="ville">Ville :</label>
                                <input readonly class="form-control" type="text" id="ville" name="ville" :value="ville" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="code-postal">Code postal :</label>
                                <input readonly class="form-control" type="text" id="code-postal" name="code_postal" :value="code_postal" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="telephone">Téléphone :</label>
                                <input readonly placeholder="+261 xx xx xxx xx" class="form-control" type="text" id="telephone" name="telephone" :value="telephone" required>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="mobile">Email :</label>
                                <input readonly class="form-control" type="text" id="email" data-ctr="email" name="email" :value="email" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row title-tab text-white text-uppercase pt-3 pb-2 mb-4 mx-0 text-center position-relative" style="background-color: #77a464; ">
                <div class="col-sm-3"></div>
                <div class="col-sm-7">
                    <h5>Votre devis</h5>
                </div>
                <div class="col-sm-2">
                    <h5>Sous-total</h5>
                </div>
            </div>
            <div class="border my-4 p-3 position-relative" style="background-color: #f6fbf442;" v-if="billeterie.length > 0">
                <div class="categorie-produit position-absolute">{{trans('front-panier.billetterie')}}</div>
                <div class="container border my-4 p-3 position-relative" v-for="(item,index) in billeterie">
                    <div class="row">
                        <div class="col-sm-3 d-block position-relative">
                            <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                        </div>
                        <div class="col-sm-7">
                            <h5 class="text-decoration-none text-primary">
                                @{{item.lieu_depart_name}} - @{{item.lieu_arrive_name}}
                            </h5>
                            <table width="100%" class="my-3">
                                <tbody>
                                    <tr>
                                        <th colspan="2" style="font-size: large;">{{trans('front-billeterie.aller')}} </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                        <td>@{{item.lieu_depart_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                        <td>@{{item.lieu_arrive_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-billeterie.date_et_heure_depart')}} : </th>
                                        <td>@{{$formatDateString(item.date_depart,true)}} à @{{item.heure_aller | formatTime }}</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th colspan="2" style="font-size: large;">{{trans('front-billeterie.retour')}} </th>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                        <td>@{{item.lieu_arrive_name}}</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                        <td>@{{item.lieu_depart_name}}</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th>{{trans('front-billeterie.date_et_heure_retour')}} : </th>
                                        <td>@{{$formatDateString(item.date_retour,true)}} à @{{item.heure_retour | formatTime}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th colspan="2" style="font-size: large;">{{trans('front-billeterie.passagers')}} </th>
                                    </tr>
                                    <tr v-for="_item_personne of item.personne">
                                        <th>@{{_item_personne.type}} : </th>
                                        <td>@{{_item_personne.nb}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center">
                            <div class="subtotal m-auto">@{{item.prix_total}}€</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border my-4 p-3 position-relative" style="background-color: #f6fbf442;" v-if="excursion.length > 0">
                <div class="categorie-produit position-absolute">{{trans('front-panier.excursion')}}</div>
                <div class="container border my-4 p-3 position-relative" v-for="(item,index) in excursion">
                    <div class="row">
                        <div class="col-sm-3 d-block position-relative">
                            <img :src="urlasset+'/'+item.fond_image" class="img-fluid w-100">
                        </div>
                        <div class="col-sm-7">
                            <h5 class="text-decoration-none text-primary">@{{item.title}}</h5>
                            <table width="100%" class="my-3">
                                <tbody>
                                    <tr>
                                        <th width="50%">{{trans('front-excursion.date_excursion')}} :</th>
                                        <td>@{{$formatDateString(item.date_excursion,true)}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-excursion.destination')}} :</th>
                                        <td>@{{item.ile.name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-excursion.duree')}} :</th>
                                        <td>@{{item.duration}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="font-size: large;">{{trans('front-excursion.personnes')}} </th>
                                    </tr>
                                    <tr v-for="_item_personne of item.personne">
                                        <th>@{{_item_personne.type}} : </th>
                                        <td>@{{_item_personne.nb}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-excursion.supplements')}} :</th>
                                        <td>
                                            @{{calculerSupplement(item.supplement)}}€
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="supp-info">
                                            <div class="item">
                                                <ul class="list-info">
                                                    <li v-for="_child_supp of item.supplement"><span style="width: 48%;display: inline-block;font-weight:500">@{{_child_supp.titre}} :</span> <span style="display: inline-block">@{{_child_supp.prix}}€</span></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center">
                            <div class="subtotal m-auto">@{{item.prix_total}}€</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border my-4 p-3 position-relative" style="background-color: #f6fbf442;" v-if="hebergement.length > 0">
                <div class="categorie-produit position-absolute">{{trans('front-panier.hebergement')}}</div>
                <div class="container border my-4 p-3 position-relative" v-for="(item,index) in hebergement">
                    <div class="row">
                        <div class="col-sm-3 d-block position-relative">
                            <img :src="urlasset+'/'+item.chambre_image" class="img-fluid w-100">
                        </div>
                        <div class="col-sm-7">
                            <h5 class="text-decoration-none text-primary">@{{item.chambre_name}}</h5>
                            <table width="100%" class="my-3">
                                <tbody>
                                    <tr>
                                        <th width="50%">{{trans('front-hebergement.transport')}} :</th>
                                        <td v-if="$isEmpty(item.vol) == true">Avec vol</td>
                                        <td v-if="$isEmpty(item.vol) == false">Sans vol</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-hebergement.nombre_nuits')}} : </th>
                                        <td>@{{ $intervalDateDays(item.date_debut,item.date_fin,true)}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-hebergement.dates_sejour')}} : </th>
                                        <td>@{{ $formatDateString(item.date_debut,true) }} au @{{ $formatDateString(item.date_fin,true)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-hebergement.base_type')}} : </th>
                                        <td>@{{item.chambre_base_type_titre}} (@{{item.chambre_base_type_nombre}}Pers.)</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-hebergement.capacite_max')}} : </th>
                                        <td>@{{item.chambre_capacite}} Pers.</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="font-size: large;">{{trans('front-hebergement.personnes')}} </th>
                                    </tr>
                                    <tr v-for="_item_personne of item.personne">
                                        <th>@{{_item_personne.type}} : </th>
                                        <td>@{{_item_personne.nb}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-hebergement.supplements')}} :</th>
                                        <td>
                                            @{{calculerSupplement(item.supplement)}}€
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="supp-info">
                                            <div class="item">
                                                <ul class="list-info">
                                                    <li v-for="_child_supp of item.supplement"><span style="width: 48%;display: inline-block;font-weight:500">@{{_child_supp.titre}} :</span> <span style="display: inline-block">@{{_child_supp.prix}}€</span></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center">
                            <div class="subtotal m-auto">@{{item.prix_total}}€</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="border my-4 p-3 position-relative" style="background-color: #f6fbf442;" v-if="location.length > 0">
                <div class="categorie-produit position-absolute">{{trans('front-panier.location')}}</div>
                <div class="container border my-4 p-3 position-relative" v-for="(item,index) in location">
                    <div class="row">
                        <div class="col-sm-3 d-block position-relative">
                            <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                        </div>
                        <div class="col-sm-7">
                            <h5 class="text-decoration-none text-primary">@{{item.titre}}</h5>
                            <table width="100%" class="my-3">
                                <tbody>
                                    <tr>
                                        <th width="45%">{{trans('front-location.lieu_depart')}} : </th>
                                        <td>@{{item.agence_recuperation_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-location.date_et_heure_depart')}} : </th>
                                        <td>@{{$formatDateString(item.date_recuperation,true)}} à @{{item.heure_recuperation|formatTime}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-location.lieu_retour')}} : </th>
                                        <td>@{{item.agence_restriction_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-location.date_et_heure_retour')}} : </th>
                                        <td>@{{$formatDateString(item.date_restriction,true)}} à @{{item.heure_restriction|formatTime}}</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-location.supplement_deplacements')}} :</th>
                                        <td>@{{item.deplacement_lieu_tarif?item.deplacement_lieu_tarif:0}}€</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('admin.vehicule-location.columns.caution')}} :</th>
                                        <td class="detail-info">
                                            @{{item.caution}}€
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr v-if="item.franchise != 0">
                                        <th>{{trans('admin.vehicule-location.columns.franchise')}} :</th>
                                        <td class="detail-info">
                                            @{{item.franchise}}€
                                        </td>
                                    </tr>
                                    <tr v-if="item.franchise_non_rachatable != 0">
                                        <th>{{trans('admin.vehicule-location.columns.franchise_non_rachatable')}} :</th>
                                        <td class="detail-info">
                                            @{{item.franchise_non_rachatable}}€
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="position: relative;" v-if="item.info_tech && item.info_tech.fiche_technique">
                                <a class="text-success" style="cursor: pointer;" :href="`${urlasset}/${item.info_tech.fiche_technique}`" :download="item.modele_vehicule_titre">Fiche technique <i class="fa fa-download"></i></a>
                            </div>
                            <div style="position: relative;margin-top: 10px;">
                                <input type="checkbox" :id="`info-conduct_${index}`" class="info-conduct">
                                <label :for="`info-conduct_${index}`" class="text-success toogle-info-conducteur info-conducteur-panier-titre">{{trans('front-location.information_conducteur')}}</label>
                                <div class="row content-info-conducteur">
                                    <div class="col-12">
                                        <div class="row" style="text-align: center; ">
                                            <div class="col">
                                                <a style="background-color: #f0e9e9; cursor: pointer;" :href="`${urlbase}/conducteur-info/${item.id}`" target="_blank"> Télécharger en pdf <i class="fa fa-download"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.nom')}} : </span>
                                                <span style="padding-left: 10px">@{{item.nom_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.prenom')}} : </span>
                                                <span style="padding-left: 10px">@{{item.prenom_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.adresse')}} : </span>
                                                <span style="padding-left: 10px">@{{item.adresse_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.ville')}} : </span>
                                                <span style="padding-left: 10px">@{{item.ville_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.code_postal')}} : </span>
                                                <span style="padding-left: 10px">@{{item.code_postal_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.telephone')}} : </span>
                                                <span style="padding-left: 10px">@{{item.telephone_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.email')}} : </span>
                                                <span style="padding-left: 10px">@{{item.email_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_naissance')}} : </span>
                                                <span style="padding-left: 10px">@{{item.date_naissance_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_naissance')}} : </span>
                                                <span style="padding-left: 10px">@{{item.lieu_naissance_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_permis')}} : </span>
                                                <span style="padding-left: 10px">@{{item.num_permis_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_permis')}} : </span>
                                                <span style="padding-left: 10px">@{{item.date_permis_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_permis')}} : </span>
                                                <span style="padding-left: 10px">@{{item.lieu_deliv_permis_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_piece_identite')}} : </span>
                                                <span style="padding-left: 10px">@{{item.num_identite_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_delivrance_identite')}} : </span>
                                                <span style="padding-left: 10px">@{{item.date_emis_identite_conducteur}}</span>
                                            </div>
                                            <div class="col-12" style="margin-bottom: 10px;">
                                                <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_identite')}} : </span>
                                                <span style="padding-left: 10px">@{{item.lieu_deliv_identite_conducteur}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center">
                            <div class="subtotal m-auto">@{{item.prix_total}}€</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border my-4 p-3 position-relative" style="background-color: #f6fbf442;" v-if="transfert.length > 0">
                <div class="categorie-produit position-absolute">{{trans('front-panier.transfert')}}</div>
                <div class="container border my-4 p-3 position-relative" v-for="(item,index) in transfert">
                    <div class="row">
                        <div class="col-sm-3 d-block position-relative">
                            <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                        </div>
                        <div class="col-sm-7">
                            <h5 class="text-decoration-none text-primary">@{{item.titre}}</h5>
                            <table width="100%" class="my-3">
                                <tbody>
                                    <tr>
                                        <th colspan="2" style="font-size: large;">{{trans('front-transfert.aller')}}</th>
                                    </tr>
                                    <tr>
                                        <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                        <td>@{{item.lieu_depart_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                        <td>@{{item.lieu_arrive_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('front-transfert.date_et_heure_depart')}} : </th>
                                        <td>@{{$formatDateString(item.date_depart,true)}} à @{{item.heure_depart|formatTime }}</td>
                                    </tr>
                                    <tr v-if="item.prime_depart > 0">
                                        <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                        <td>@{{item.prime_depart}}€</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th colspan="2" style="font-size: large;">{{trans('front-transfert.retour')}}</th>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                        <td>@{{item.lieu_arrive_name}}</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                        <td>@{{item.lieu_depart_name}}</td>
                                    </tr>
                                    <tr v-if="item.parcours == 2">
                                        <th>{{trans('front-transfert.date_et_heure_retour')}} : </th>
                                        <td>@{{$formatDateString(item.date_retour,true)}} à @{{item.heure_retour | formatTime}}</td>
                                    </tr>
                                    <tr v-if="item.prime_retour > 0">
                                        <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                        <td>@{{item.prime_retour}}€</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="font-size: large;">{{trans('front-transfert.passagers')}} </th>
                                    </tr>
                                    <tr v-for="_item_personne of item.personne">
                                        <th>@{{_item_personne.type}} : </th>
                                        <td>@{{_item_personne.nb}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center">
                            <div class="subtotal m-auto">@{{item.prix_total}}€</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border position-relative mt-3 mb-5 px-3">
                <div class="container position-relative">
                    <div class="row">
                        <div class="col-sm-10 border-bottom d-flex align-items-center" style="margin-bottom: -1px; font-weight: 800; text-transform: uppercase; font-size: 1rem;">
                        {{trans('front-panier.frais_dossier')}}
                        </div>
                        <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                            <div class="subtotal m-auto">@{{frais_dossier}}€</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 p-3 position-relative">
                <div class="row border-top border-left border-right border-bottom">
                    <div class="col-sm-8 text-uppercase text-center p-2 position-relative">
                        <div class="total-titre">
                            <h6 class="font-weight-bold" style="font-size:1.2rem">{{trans('front-panier.tva')}}</h6>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center p-2 border-left">
                        <div class="total font-weight-bold" style="font-size:1.2rem">@{{tva}} €</div>
                    </div>
                </div>
                <div class="row border-left border-right border-bottom">
                    <div class="col-sm-8 text-uppercase text-center p-2 position-relative">
                        <div class="total-titre">
                            <h6 class="font-weight-bold" style="font-size:1.2rem">{{trans('front-panier.ht')}}</h6>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center p-2 border-left">
                        <div class="total font-weight-bold" style="font-size:1.2rem">@{{prix}} €</div>
                    </div>
                </div>
                <div class="row border-left border-right border-bottom">
                    <div class="col-sm-8 text-uppercase text-center p-2 position-relative">
                        <div class="total-titre">
                            <h6 class="font-weight-bold" style="font-size:1.8rem">{{trans('front-panier.total_ttc')}}</h6>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center p-2 border-left">
                        <div class="total font-weight-bold" style="font-size:1.8rem">@{{prix_total}} €</div>
                    </div>
                </div>
                <div class="row border-left border-right border-bottom">
                    <div class="col-sm-8 text-uppercase text-center p-2 position-relative d-flex align-items-center justify-content-center">
                        <div class="total-titre m-auto">
                            <h6 class="font-weight-bold d-flex align-items-center justify-content-center" style="font-size:1.8rem">Mode paiement</h6>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center p-2 border-left">
                        <div class="total font-weight-bold">
                            <img v-if="mode_payement.icon != null" :src="urlasset+'/'+mode_payement.icon" class="img-fluid" style="width: 60px">
                            <span v-if="mode_payement.icon == null" style="font-size:1.8rem">@{{mode_payement.titre}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</remerciement>

@endsection